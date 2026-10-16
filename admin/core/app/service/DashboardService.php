<?php
namespace App\Service;

use Database;
use PDO;

/**
 * Servicio para recopilar métricas, contadores y datos de analítica
 * para el panel principal de administración de Katana Lite.
 */
class DashboardService {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getPdo();
    }

    private function getCoin(): string {
        $stmt = $this->pdo->prepare("SELECT val FROM configuration WHERE name = 'general_coin' LIMIT 1");
        $stmt->execute();
        $val = $stmt->fetchColumn();
        return $val !== false && !empty($val) ? $val : '$';
    }

    private function getIva(): float {
        $stmt = $this->pdo->prepare("SELECT val FROM configuration WHERE name = 'general_iva' LIMIT 1");
        $stmt->execute();
        $val = $stmt->fetchColumn();
        return $val !== false ? (float)$val : 0.0;
    }

    /**
     * Retorna todos los datos requeridos por el Dashboard
     */
    public function getDashboardData(): array {
        $coin = $this->getCoin();
        $iva = $this->getIva();

        // 1. Widgets (6 contadores)
        $widgets = $this->getWidgetsData($coin, $iva);

        // 2. Gráfica de ventas de los últimos 30 días
        $sales30Days = $this->getSalesLast30Days($iva);

        // 3. Top productos para gráfica Pie
        $topProducts = $this->getTopProducts(5);

        // 4. Últimas ventas
        $latestSales = $this->getLatestSales(7, $coin, $iva);

        // 5. Últimos clientes
        $latestClients = $this->getLatestClients(7);

        return [
            'coin' => $coin,
            'widgets' => $widgets,
            'sales_chart' => $sales30Days,
            'top_products' => $topProducts,
            'latest_sales' => $latestSales,
            'latest_clients' => $latestClients,
        ];
    }

    /**
     * Obtiene los 6 contadores principales
     */
    private function getWidgetsData(string $coin, float $iva): array {
        // Conteo y suma de ventas no canceladas
        $buys = \BuyData::getAll();
        $totalIncome = 0.0;
        $totalOrders = count($buys);
        $pendingOrders = 0;
        $completedOrders = 0;

        foreach ($buys as $b) {
            $statusId = (int)$b->status_id;
            if ($statusId === 1) {
                $pendingOrders++;
            }
            if ($statusId === 2 || $statusId === 5) {
                $completedOrders++;
            }
            if ($statusId !== 3) { // No cancelado
                $tot = $b->getTotal();
                $totalFinal = $tot + ($tot * ($iva / 100));
                $totalIncome += $totalFinal;
            }
        }

        // Productos
        $stmt = $this->pdo->query("SELECT COUNT(*) as total, SUM(CASE WHEN in_existence = 1 THEN 1 ELSE 0 END) as in_stock FROM product");
        $prodRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalProducts = (int)($prodRow['total'] ?? 0);
        $inStockProducts = (int)($prodRow['in_stock'] ?? 0);

        // Clientes
        $stmt = $this->pdo->query("SELECT COUNT(*) as total, SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active FROM client");
        $clientRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalClients = (int)($clientRow['total'] ?? 0);
        $activeClients = (int)($clientRow['active'] ?? 0);

        // Categorías
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM category");
        $totalCategories = (int)$stmt->fetchColumn();

        // Sliders
        $stmt = $this->pdo->query("SELECT COUNT(*) as total, SUM(CASE WHEN is_public = 1 THEN 1 ELSE 0 END) as active FROM slide");
        $slideRow = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalSlides = (int)($slideRow['total'] ?? 0);
        $activeSlides = (int)($slideRow['active'] ?? 0);

        return [
            'income' => [
                'total' => $totalIncome,
                'formatted' => $coin . ' ' . number_format($totalIncome, 2),
                'label' => 'Ventas Totales',
                'completed_count' => $completedOrders
            ],
            'orders' => [
                'total' => $totalOrders,
                'pending' => $pendingOrders,
                'label' => 'Total Pedidos'
            ],
            'products' => [
                'total' => $totalProducts,
                'in_stock' => $inStockProducts,
                'label' => 'Productos'
            ],
            'clients' => [
                'total' => $totalClients,
                'active' => $activeClients,
                'label' => 'Clientes'
            ],
            'categories' => [
                'total' => $totalCategories,
                'label' => 'Categorías'
            ],
            'slides' => [
                'total' => $totalSlides,
                'active' => $activeSlides,
                'label' => 'Sliders'
            ]
        ];
    }

    /**
     * Calcula las ventas día a día de los últimos 30 días
     */
    private function getSalesLast30Days(float $iva): array {
        $meses = ['01'=>'Ene', '02'=>'Feb', '03'=>'Mar', '04'=>'Abr', '05'=>'May', '06'=>'Jun',
                  '07'=>'Jul', '08'=>'Ago', '09'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dic'];

        $days = [];
        $startDate = new \DateTime('-29 days');
        $endDate = new \DateTime('today');
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($startDate, $interval, (clone $endDate)->modify('+1 day'));

        foreach ($period as $dt) {
            $key = $dt->format('Y-m-d');
            $d = $dt->format('d');
            $m = $dt->format('m');
            $label = $d . ' ' . ($meses[$m] ?? $m);
            $days[$key] = [
                'label' => $label,
                'total' => 0.0,
                'orders' => 0
            ];
        }

        // Consultar compras en el rango (excluyendo canceladas)
        $startStr = $startDate->format('Y-m-d 00:00:00');
        $stmt = $this->pdo->prepare("SELECT id, DATE(created_at) as buy_date, status_id FROM buy WHERE created_at >= :start AND status_id != 3");
        $stmt->execute(['start' => $startStr]);
        $buys = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $periodTotal = 0.0;
        $periodOrders = 0;

        foreach ($buys as $row) {
            $buyDate = $row['buy_date'];
            if (!isset($days[$buyDate])) continue;

            $buy = \BuyData::find($row['id']);
            if (!$buy) continue;

            $tot = $buy->getTotal();
            $finalAmount = $tot + ($tot * ($iva / 100));

            $days[$buyDate]['total'] += $finalAmount;
            $days[$buyDate]['orders'] += 1;

            $periodTotal += $finalAmount;
            $periodOrders += 1;
        }

        $labels = [];
        $totals = [];
        $orders = [];

        foreach ($days as $item) {
            $labels[] = $item['label'];
            $totals[] = round($item['total'], 2);
            $orders[] = $item['orders'];
        }

        return [
            'labels_json' => json_encode($labels),
            'totals_json' => json_encode($totals),
            'orders_json' => json_encode($orders),
            'period_total' => $periodTotal,
            'period_orders' => $periodOrders,
        ];
    }

    /**
     * Obtiene el Top de productos más vendidos
     */
    private function getTopProducts(int $limit = 5): array {
        $sql = "SELECT p.id, p.name, p.price, p.image,
                       SUM(bp.q) as total_units,
                       SUM(bp.q * p.price) as total_revenue
                FROM buy_product bp
                JOIN product p ON bp.product_id = p.id
                JOIN buy b ON bp.buy_id = b.id
                WHERE b.status_id != 3
                GROUP BY p.id, p.name, p.price, p.image
                ORDER BY total_units DESC
                LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $palette = ['#6366f1', '#06b6d4', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6'];

        $labels = [];
        $data = [];
        $colors = [];
        $products = [];

        foreach ($rows as $index => $r) {
            $color = $palette[$index % count($palette)];
            $labels[] = mb_strimwidth($r['name'], 0, 24, '...');
            $data[] = (int)$r['total_units'];
            $colors[] = $color;
            $products[] = [
                'id' => (int)$r['id'],
                'name' => $r['name'],
                'price' => (float)$r['price'],
                'image' => $r['image'],
                'units' => (int)$r['total_units'],
                'revenue' => (float)$r['total_revenue'],
                'color' => $color
            ];
        }

        return [
            'has_data' => count($rows) > 0,
            'labels_json' => json_encode($labels),
            'data_json' => json_encode($data),
            'colors_json' => json_encode($colors),
            'items' => $products
        ];
    }

    /**
     * Obtiene las ventas más recientes
     */
    private function getLatestSales(int $limit, string $coin, float $iva): array {
        $stmt = $this->pdo->prepare("SELECT * FROM buy ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $buys = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, \BuyData::class);

        $statusBadges = [
            1 => ['class' => 'bg-amber-100 text-amber-700', 'icon' => 'bi-clock-history', 'name' => 'Pendiente'],
            2 => ['class' => 'bg-emerald-100 text-emerald-700', 'icon' => 'bi-check-circle', 'name' => 'Pagado'],
            3 => ['class' => 'bg-rose-100 text-rose-700', 'icon' => 'bi-x-circle', 'name' => 'Cancelado'],
            4 => ['class' => 'bg-cyan-100 text-cyan-700', 'icon' => 'bi-truck', 'name' => 'Enviado'],
            5 => ['class' => 'bg-indigo-100 text-indigo-700', 'icon' => 'bi-check2-all', 'name' => 'Finalizado'],
        ];

        $result = [];
        foreach ($buys as $b) {
            $client = $b->getClient();
            $tot = $b->getTotal();
            $totalFinal = $tot + ($tot * ($iva / 100));

            $st = (int)$b->status_id;
            $statusInfo = $statusBadges[$st] ?? ['class' => 'bg-secondary text-white', 'icon' => 'bi-info-circle', 'name' => 'Desconocido'];

            $result[] = [
                'id' => $b->id,
                'code' => $b->code,
                'client_name' => $client ? $client->getFullname() : 'Cliente Anónimo',
                'client_email' => $client ? $client->email : '',
                'total_formatted' => $coin . ' ' . number_format($totalFinal, 2),
                'status_id' => $st,
                'status_name' => $statusInfo['name'],
                'status_class' => $statusInfo['class'],
                'status_icon' => $statusInfo['icon'],
                'created_at' => date('d/m/Y H:i', strtotime($b->created_at)),
            ];
        }

        return $result;
    }

    /**
     * Obtiene los clientes más recientemente registrados
     */
    private function getLatestClients(int $limit): array {
        $stmt = $this->pdo->prepare("SELECT * FROM client ORDER BY created_at DESC, id DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, \ClientData::class);

        $avatarColors = ['#6366f1', '#06b6d4', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#3b82f6'];

        $result = [];
        foreach ($clients as $index => $c) {
            $name = trim($c->name . ' ' . $c->lastname);
            $initials = mb_strtoupper(mb_substr($c->name, 0, 1) . mb_substr($c->lastname, 0, 1));
            if (empty($initials)) $initials = 'CL';

            $result[] = [
                'id' => $c->id,
                'fullname' => !empty($name) ? $name : 'Cliente #' . $c->id,
                'email' => $c->email,
                'phone' => $c->phone,
                'is_active' => (bool)$c->is_active,
                'initials' => $initials,
                'color' => $avatarColors[$index % count($avatarColors)],
                'created_at' => date('d/m/Y', strtotime($c->created_at)),
            ];
        }

        return $result;
    }
}
