<?php
use App\Controller\Admin\AuthController as AdminAuthController;
use App\Controller\Admin\DashboardController as AdminDashboardController;
use App\Controller\Admin\CategoryController as AdminCategoryController;
use App\Controller\Admin\ProductController as AdminProductController;
use App\Controller\Admin\SellController as AdminSellController;
use App\Controller\Admin\ClientController as AdminClientController;
use App\Controller\Admin\SlideController as AdminSlideController;
use App\Controller\Admin\SettingController as AdminSettingController;
use App\Controller\Admin\UserController as AdminUserController;

return function(FastRoute\RouteCollector $r) {
    // Helper para registrar una ruta tanto con su path directo como con prefijo opcional /admin
    $add = function($method, $path, $handler) use ($r) {
        $r->addRoute($method, $path, $handler);
        $adminPath = '/admin' . ($path === '/' ? '' : $path);
        if ($adminPath !== $path) {
            $r->addRoute($method, $adminPath, $handler);
        }
    };

    // Autenticacion y Dashboard
    $add('GET', '/login', [AdminAuthController::class, 'showLogin']);
    $add('POST', '/login', [AdminAuthController::class, 'login']);
    $add('GET', '/logout', [AdminAuthController::class, 'logout']);
    $add('GET', '/', [AdminDashboardController::class, 'index']);

    // Categorias
    $add('GET', '/categories', [AdminCategoryController::class, 'index']);
    $add('POST', '/category/create', [AdminCategoryController::class, 'create']);
    $add('POST', '/category/{id:\d+}/update', [AdminCategoryController::class, 'update']);
    $add('POST', '/category/{id:\d+}/delete', [AdminCategoryController::class, 'delete']);

    // Productos
    $add('GET', '/products', [AdminProductController::class, 'index']);
    $add('GET', '/product/new', [AdminProductController::class, 'new']);
    $add('POST', '/product/create', [AdminProductController::class, 'create']);
    $add('GET', '/product/{id:\d+}/edit', [AdminProductController::class, 'edit']);
    $add('POST', '/product/{id:\d+}/update', [AdminProductController::class, 'update']);
    $add('POST', '/product/{id:\d+}/delete', [AdminProductController::class, 'delete']);

    // Pedidos (ventas)
    $add('GET', '/sells', [AdminSellController::class, 'index']);
    $add('GET', '/sell/{id:\d+}', [AdminSellController::class, 'show']);
    $add('GET', '/sell/{id:\d+}/history', [AdminSellController::class, 'history']);
    $add('POST', '/sell/{id:\d+}/status/{status:\d+}', [AdminSellController::class, 'changeStatus']);

    // Clientes
    $add('GET', '/clients', [AdminClientController::class, 'index']);
    $add('GET', '/client/new', [AdminClientController::class, 'new']);
    $add('POST', '/client/create', [AdminClientController::class, 'create']);
    $add('GET', '/client/{id:\d+}/edit', [AdminClientController::class, 'edit']);
    $add('POST', '/client/{id:\d+}/update', [AdminClientController::class, 'update']);
    $add('POST', '/client/{id:\d+}/delete', [AdminClientController::class, 'delete']);

    // Sliders
    $add('GET', '/slides', [AdminSlideController::class, 'index']);
    $add('GET', '/slide/new', [AdminSlideController::class, 'new']);
    $add('POST', '/slide/create', [AdminSlideController::class, 'create']);
    $add('GET', '/slide/{id:\d+}/edit', [AdminSlideController::class, 'edit']);
    $add('POST', '/slide/{id:\d+}/update', [AdminSlideController::class, 'update']);
    $add('POST', '/slide/{id:\d+}/delete', [AdminSlideController::class, 'delete']);

    // Ajustes del Sistema y Pagos
    $add('GET', '/settings', [AdminSettingController::class, 'index']);
    $add('POST', '/settings/update', [AdminSettingController::class, 'update']);
    $add('GET', '/settings/payment', [AdminSettingController::class, 'paymentSettings']);
    $add('POST', '/settings/payment/update', [AdminSettingController::class, 'updatePaymentSettings']);
    $add('POST', '/settings/paymethod/{id:\d+}/toggle', [AdminSettingController::class, 'togglePaymethod']);

    // Usuarios del staff
    $add('GET', '/users', [AdminUserController::class, 'index']);
    $add('GET', '/user/new', [AdminUserController::class, 'new']);
    $add('POST', '/user/create', [AdminUserController::class, 'create']);
    $add('GET', '/user/{id:\d+}/edit', [AdminUserController::class, 'edit']);
    $add('POST', '/user/{id:\d+}/update', [AdminUserController::class, 'update']);
};
