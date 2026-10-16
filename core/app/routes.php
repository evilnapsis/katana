<?php
use App\Controller\Store\HomeController as StoreHomeController;
use App\Controller\Store\CategoryController as StoreCategoryController;
use App\Controller\Store\ProductController as StoreProductController;
use App\Controller\Store\CartController as StoreCartController;
use App\Controller\Store\AuthController as StoreAuthController;
use App\Controller\Store\CheckoutController as StoreCheckoutController;
use App\Controller\Store\ClientAccountController as StoreClientAccountController;
use App\Controller\Store\ContactController as StoreContactController;

return function(FastRoute\RouteCollector $r) {
    // Tienda publica (Katana Lite Shop)
    $r->addRoute('GET', '/', [StoreHomeController::class, 'index']);
    $r->addRoute('GET', '/category/{shortName:[a-zA-Z0-9_-]+}', [StoreCategoryController::class, 'show']);
    $r->addRoute('GET', '/products', [StoreProductController::class, 'index']);
    $r->addRoute('GET', '/product/{id:\d+}', [StoreProductController::class, 'show']);

    // Contacto
    $r->addRoute('GET', '/contact', [StoreContactController::class, 'show']);
    $r->addRoute('POST', '/contact', [StoreContactController::class, 'send']);

    // Carrito de compras (basado en sesion)
    $r->addRoute('GET', '/cart', [StoreCartController::class, 'show']);
    $r->addRoute('GET', '/cart/add/{id:\d+}', [StoreCartController::class, 'add']);
    $r->addRoute('POST', '/cart/item/{id:\d+}/update', [StoreCartController::class, 'updateQuantity']);
    $r->addRoute('GET', '/cart/item/{id:\d+}/remove', [StoreCartController::class, 'remove']);
    $r->addRoute('GET', '/cart/clear', [StoreCartController::class, 'clear']);

    // Checkout
    $r->addRoute('POST', '/checkout', [StoreCheckoutController::class, 'show']);
    $r->addRoute('POST', '/checkout/confirm', [StoreCheckoutController::class, 'confirm']);
    $r->addRoute('GET', '/checkout/success/{id:\d+}', [StoreCheckoutController::class, 'success']);

    // Acceso de clientes (login/registro)
    $r->addRoute('GET', '/login', [StoreAuthController::class, 'showLogin']);
    $r->addRoute('POST', '/login', [StoreAuthController::class, 'login']);
    $r->addRoute('GET', '/logout', [StoreAuthController::class, 'logout']);
    $r->addRoute('GET', '/register', [StoreAuthController::class, 'showRegister']);
    $r->addRoute('POST', '/register', [StoreAuthController::class, 'register']);

    // Cuenta de cliente (Mis Compras)
    $r->addRoute('GET', '/account', [StoreClientAccountController::class, 'index']);
    $r->addRoute('GET', '/account/order/{code:[a-zA-Z0-9_-]+}', [StoreClientAccountController::class, 'show']);
    $r->addRoute('POST', '/account/order/{id:\d+}/cancel', [StoreClientAccountController::class, 'cancel']);
};
