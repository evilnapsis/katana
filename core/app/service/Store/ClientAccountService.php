<?php
namespace App\Service\Store;

/**
 * Capa de servicio para la cuenta del cliente logueado (Katana Lite): historial de compras
 * ("Mis Compras") y el detalle de una orden puntual.
 */
class ClientAccountService {
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

    public function getDashboard(int $clientId): array {
        $client = \ClientData::find($clientId);
        $buys = \BuyData::getAllByClientId($clientId);
        $iva = $this->iva();

        $totalSpent = 0;
        $activeOrders = 0;
        $rows = [];

        foreach ($buys as $b) {
            $totalFinal = $b->getTotal() + ($b->getTotal() * ($iva / 100));

            if ((int)$b->status_id !== 3) {
                $totalSpent += $totalFinal;
                if ((int)$b->status_id === 1 || (int)$b->status_id === 4) $activeOrders++;
            }

            $rows[] = ['buy' => $b, 'discount_pct' => 0, 'total_final' => $totalFinal];
        }

        return [
            'client' => $client,
            'rows' => $rows,
            'total_orders' => count($buys),
            'total_spent' => $totalSpent,
            'active_orders' => $activeOrders,
            'coin' => $this->coin(),
        ];
    }

    public function getOrderDetail(string $code, int $clientId): ?array {
        $buy = \BuyData::getByCode($code);
        if (!$buy || (int)$buy->client_id !== $clientId) return null;

        $iva = $this->iva();
        $total = $buy->getTotal();
        $subtotalWithIva = $total + ($total * ($iva / 100));

        $products = [];
        foreach (\BuyProductData::getAllByBuyId($buy->id) as $bp) {
            $product = $bp->getProduct();
            if (!$product) continue;
            $products[] = ['product' => $product, 'q' => $bp->q, 'unit' => $product->getUnit(), 'line_total' => $product->price * $bp->q];
        }

        $bankInfo = null;
        if ((int)$buy->paymethod_id === 1 || (int)$buy->paymethod_id === 2) {
            $pm = $buy->getPaymethod();
            if ($pm && $pm->short_name === 'bank') {
                $bankInfo = [
                    'titular' => \ConfigurationData::getByPreffix('bank_titular'),
                    'name' => \ConfigurationData::getByPreffix('bank_name'),
                    'account' => \ConfigurationData::getByPreffix('bank_account'),
                    'card' => \ConfigurationData::getByPreffix('bank_card'),
                ];
            }
        }

        return [
            'buy' => $buy,
            'products' => $products,
            'coin' => $this->coin(),
            'iva' => $iva,
            'iva_txt' => $this->ivaTxt(),
            'coupon' => null,
            'discount_pct' => 0,
            'subtotal_with_iva' => $subtotalWithIva,
            'discount_amount' => 0,
            'total_final' => $subtotalWithIva,
            'bank_info' => $bankInfo,
        ];
    }

    public function cancelOrder(int $buyId, int $clientId): bool {
        $buy = \BuyData::find($buyId);
        if (!$buy || (int)$buy->client_id !== $clientId) return false;
        if ((int)$buy->status_id !== 1) return false;

        $ok = $buy->changeStatus(3); // Cancelado

        $h = new \HistoryData();
        $h->buy_id = $buy->id;
        $h->status_id = 3;
        $h->save();

        return $ok;
    }
}
