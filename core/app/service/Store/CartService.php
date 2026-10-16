<?php
namespace App\Service\Store;

/**
 * Capa de servicio para el carrito de compras (Katana Lite, basado en sesion).
 */
class CartService {
    private $catalogService;

    public function __construct() {
        $this->catalogService = new CatalogService();
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    }

    public function count(): int {
        return count($_SESSION['cart']);
    }

    public function has(int $productId): bool {
        foreach ($_SESSION['cart'] as $c) {
            if ($c['product_id'] == $productId) return true;
        }
        return false;
    }

    public function add(int $productId): void {
        if ($this->has($productId)) return;
        $_SESSION['cart'][] = ['product_id' => $productId, 'q' => 1];
    }

    public function updateQuantity(int $productId, int $qty): void {
        foreach ($_SESSION['cart'] as &$c) {
            if ($c['product_id'] == $productId) { $c['q'] = max(1, $qty); break; }
        }
        unset($c);
    }

    public function remove(int $productId): void {
        $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], fn($c) => $c['product_id'] != $productId));
    }

    public function clear(): void {
        $_SESSION['cart'] = [];
    }

    private function iva(): float {
        $c = \ConfigurationData::getByPreffix('general_iva');
        return $c ? (float)$c->val : 0.0;
    }

    private function coin(): string {
        $c = \ConfigurationData::getByPreffix('general_coin');
        return $c ? $c->val : '$';
    }

    private function ivaTxt(): string {
        $c = \ConfigurationData::getByPreffix('general_iva_txt');
        return $c ? $c->val : 'IVA';
    }

    /** Items del carrito con producto e imagen resuelta */
    public function getItems(): array {
        $items = [];
        foreach ($_SESSION['cart'] as $c) {
            $p = \ProductData::find($c['product_id']);
            if (!$p) continue;
            $items[] = [
                'product' => $p,
                'q' => $c['q'],
                'image' => $this->catalogService->resolveProductImage($p),
                'subtotal' => $p->price * $c['q'],
            ];
        }
        return $items;
    }

    /** Subtotal, iva y total final del carrito actual */
    public function getTotals(): array {
        $total = 0;
        foreach ($this->getItems() as $item) { $total += $item['subtotal']; }

        $iva = $this->iva();
        $subtotalWithIva = $total + ($total * ($iva / 100));

        return [
            'coin' => $this->coin(),
            'iva' => $iva,
            'iva_txt' => $this->ivaTxt(),
            'subtotal' => $total,
            'iva_amount' => $total * ($iva / 100),
            'coupon' => null,
            'discount' => 0,
            'total' => $subtotalWithIva,
        ];
    }
}
