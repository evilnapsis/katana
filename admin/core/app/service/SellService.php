<?php
namespace App\Service;

/**
 * Capa de servicio para el control de pedidos/ventas (Katana Lite).
 */
class SellService {
    private function coin(): string {
        $c = \ConfigurationData::getByPreffix('general_coin');
        return $c ? $c->val : '$';
    }

    private function iva(): float {
        $c = \ConfigurationData::getByPreffix('general_iva');
        return $c ? (float)$c->val : 0.0;
    }

    private function ivaTxt(): string {
        $c = \ConfigurationData::getByPreffix('general_iva_txt');
        return $c ? $c->val : 'IVA';
    }

    public function getDashboard(): array {
        $buys = \BuyData::getAll();
        $iva = $this->iva();

        $counts = ['all' => 0, 'pending' => 0, 'paid' => 0, 'canceled' => 0, 'shipped' => 0, 'finished' => 0];
        $sumTotal = 0;
        $rows = [];

        foreach ($buys as $b) {
            $counts['all']++;
            switch ((int)$b->status_id) {
                case 1: $counts['pending']++; break;
                case 2: $counts['paid']++; break;
                case 3: $counts['canceled']++; break;
                case 4: $counts['shipped']++; break;
                case 5: $counts['finished']++; break;
            }

            $total = $b->getTotal();
            $totalFinal = $total + ($total * ($iva / 100));

            if ((int)$b->status_id !== 3) {
                $sumTotal += $totalFinal;
            }

            $rows[] = [
                'buy' => $b,
                'discount_pct' => 0,
                'total_final' => $totalFinal,
            ];
        }

        return [
            'rows' => $rows,
            'counts' => $counts,
            'sum_total' => $sumTotal,
            'coin' => $this->coin(),
        ];
    }

    public function getDetail(int $id): ?array {
        $buy = \BuyData::find($id);
        if (!$buy) return null;

        $iva = $this->iva();
        $total = $buy->getTotal();
        $subtotalWithIva = $total + ($total * ($iva / 100));

        $products = [];
        foreach (\BuyProductData::getAllByBuyId($id) as $bp) {
            $product = $bp->getProduct();
            if (!$product) continue;
            $products[] = ['product' => $product, 'q' => $bp->q, 'line_total' => $product->price * $bp->q];
        }

        return [
            'buy' => $buy,
            'client' => $buy->getClient(),
            'paymethod' => $buy->getPaymethod(),
            'products' => $products,
            'coin' => $this->coin(),
            'iva' => $iva,
            'iva_txt' => $this->ivaTxt(),
            'subtotal_display' => $total - ($total * ($iva / 100)),
            'iva_amount' => $total * ($iva / 100),
            'coupon' => null,
            'discount_pct' => 0,
            'subtotal_with_iva' => $subtotalWithIva,
            'discount_amount' => 0,
            'total_final' => $subtotalWithIva,
        ];
    }

    public function getHistory(int $buyId): array {
        return \HistoryData::getAllByBuyId($buyId);
    }

    public function changeStatus(int $id, int $statusId): bool {
        $buy = \BuyData::find($id);
        if (!$buy) return false;

        $ok = $buy->changeStatus($statusId);

        $h = new \HistoryData();
        $h->buy_id = $id;
        $h->status_id = $statusId;
        $h->save();

        $this->notifyClient($buy, $statusId);

        return $ok;
    }

    private function notifyClient(\BuyData $buy, int $statusId): void {
        $client = $buy->getClient();
        $status = \StatusData::find($statusId);
        if (!$client || !$status || empty($client->email)) return;

        $adminEmail = (\ConfigurationData::getByPreffix('general_main_email')->val ?? '');
        $body = '<html><body>'
            . '<h2>Tienda en Linea</h2><h3>Notificacion de Estado de Compra</h3>'
            . '<p><strong>Estimado ' . htmlspecialchars($client->getFullname()) . ':</strong></p>'
            . '<p>Se te notifica que tu compra con folio <b>#' . $buy->id . '</b> cambio de estado a ' . htmlspecialchars($status->name) . '.</p>'
            . '<p>Muchas gracias.</p><hr>'
            . '<p>Powered By Katana Lite</p></body></html>';

        @mail($client->email, "Compra #{$buy->id} - Notificacion", $body,
            "From: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=ISO-8859-1");
    }
}
