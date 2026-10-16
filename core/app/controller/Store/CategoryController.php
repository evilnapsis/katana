<?php
namespace App\Controller\Store;

use App\Service\Store\CatalogService;
use ViewEngine;

class CategoryController {
    private $catalogService;

    public function __construct() {
        $this->catalogService = new CatalogService();
    }

    public function show($vars) {
        $data = $this->catalogService->getCategoryPage($vars['shortName']);
        if (!$data) { http_response_code(404); ViewEngine::render('404.html.twig'); return; }
        $data['nav_categories'] = $this->catalogService->getNavCategories();
        ViewEngine::render('store/category.html.twig', $data);
    }
}
