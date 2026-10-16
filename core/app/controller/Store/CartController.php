<?php
namespace App\Controller\Store;

use App\Service\Store\CartService;
use App\Service\Store\CatalogService;
use ViewEngine;
use Request;

class CartController {
    private $cartService;
    private $baseFolder;

    public function __construct() {
        $this->cartService = new CartService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    private function back(): string {
        return $_SERVER['HTTP_REFERER'] ?? ($this->baseFolder . '/');
    }

    public function show() {
        $catalogService = new CatalogService();
        ViewEngine::render('store/cart.html.twig', array_merge(
            ['items' => $this->cartService->getItems()],
            $this->cartService->getTotals(),
            [
                'nav_categories' => $catalogService->getNavCategories(),
                'paymethods' => \PaymethodData::getActives(),
            ]
        ));
    }

    public function add($vars) {
        $this->cartService->add((int)$vars['id']);
        header('Location: ' . $this->back());
    }

    public function updateQuantity($vars) {
        $this->cartService->updateQuantity((int)$vars['id'], (int)Request::post('q', 1));
        header('Location: ' . $this->baseFolder . '/cart');
    }

    public function remove($vars) {
        $this->cartService->remove((int)$vars['id']);
        header('Location: ' . $this->baseFolder . '/cart');
    }

    public function clear() {
        $this->cartService->clear();
        header('Location: ' . $this->baseFolder . '/cart');
    }
}
