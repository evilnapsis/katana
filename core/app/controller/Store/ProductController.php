<?php
namespace App\Controller\Store;

use App\Service\Store\CatalogService;
use ViewEngine;
use Request;

class ProductController {
    private $catalogService;

    public function __construct() {
        $this->catalogService = new CatalogService();
    }

    public function index() {
        $data = $this->catalogService->getProductsPage(Request::get());
        $data['nav_categories'] = $this->catalogService->getNavCategories();
        ViewEngine::render('store/products.html.twig', $data);
    }

    public function show($vars) {
        $data = $this->catalogService->getProductDetail((int)$vars['id']);
        if (!$data) { http_response_code(404); ViewEngine::render('404.html.twig'); return; }
        $data['nav_categories'] = $this->catalogService->getNavCategories();
        ViewEngine::render('store/product.html.twig', $data);
    }
}
