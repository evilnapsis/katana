<?php
namespace App\Controller\Store;

use App\Service\Store\CartService;
use App\Service\Store\CheckoutService;
use App\Service\Store\ClientAuthService;
use App\Service\Store\CatalogService;
use ViewEngine;
use Request;
use Session;

class CheckoutController {
    private $cartService;
    private $checkoutService;
    private $baseFolder;

    public function __construct() {
        $this->cartService = new CartService();
        $this->checkoutService = new CheckoutService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    public function show() {
        if (!ClientAuthService::check() || $this->cartService->count() === 0) {
            header('Location: ' . $this->baseFolder . '/cart');
            return;
        }

        $paymethodId = (int)Request::post('paymethod_id', 0);
        $paymethod = \PaymethodData::find($paymethodId);
        if (!$paymethod) {
            header('Location: ' . $this->baseFolder . '/cart');
            return;
        }

        ViewEngine::render('store/checkout.html.twig', array_merge(
            ['items' => $this->cartService->getItems(), 'paymethod' => $paymethod],
            $this->cartService->getTotals(),
            ['nav_categories' => (new CatalogService())->getNavCategories()]
        ));
    }

    public function confirm() {
        if (!ClientAuthService::check()) {
            header('Location: ' . $this->baseFolder . '/login');
            return;
        }

        $buy = $this->checkoutService->placeOrder((int)$_SESSION['client_id'], (int)Request::post('paymethod_id', 0));
        if (!$buy) {
            header('Location: ' . $this->baseFolder . '/cart');
            return;
        }

        Session::flash('success', 'Tu pedido #' . $buy->id . ' fue registrado. Te avisaremos por correo cuando cambie de estado.');
        header('Location: ' . $this->baseFolder . '/checkout/success/' . $buy->id);
    }

    public function success($vars) {
        $buy = \BuyData::find((int)$vars['id']);
        if (!$buy || (int)$buy->client_id !== (int)($_SESSION['client_id'] ?? 0)) {
            header('Location: ' . $this->baseFolder . '/');
            return;
        }
        ViewEngine::render('store/checkout_success.html.twig', [
            'buy' => $buy,
            'nav_categories' => (new CatalogService())->getNavCategories(),
        ]);
    }
}
