<?php
namespace App\Service\Store;

/**
 * Capa de servicio para la confirmacion de pedidos (checkout Katana Lite).
 */
class CheckoutService {
    private $cartService;

    public function __construct() {
        $this->cartService = new CartService();
    }

    private function randomCode(int $len = 11): string {
        $alphabeth = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
        $code = "";
        for ($i = 0; $i < $len; $i++) $code .= $alphabeth[random_int(0, strlen($alphabeth) - 1)];
        return $code;
    }

    public function placeOrder(int $clientId, int $paymethodId): ?\BuyData {
        if ($this->cartService->count() === 0) return null;

        $buy = new \BuyData();
        $buy->k = $this->randomCode();
        $buy->code = $this->randomCode();
        $buy->client_id = $clientId;
        $buy->paymethod_id = $paymethodId;
        $buy->status_id = 1;
        $buy->save();

        foreach ($_SESSION['cart'] as $c) {
            $bp = new \BuyProductData();
            $bp->buy_id = $buy->id;
            $bp->product_id = $c['product_id'];
            $bp->q = $c['q'];
            $bp->save();
        }

        $h = new \HistoryData();
        $h->buy_id = $buy->id;
        $h->status_id = 1;
        $h->save();

        $this->cartService->clear();

        return $buy;
    }
}
