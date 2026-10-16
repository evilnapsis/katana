<?php
namespace App\Controller\Store;

use App\Service\Store\CatalogService;
use ViewEngine;

class HomeController {
    private $catalogService;

    public function __construct() {
        $this->catalogService = new CatalogService();
    }

    public function index() {
        $data = $this->catalogService->getHomeData();
        $data['nav_categories'] = $this->catalogService->getNavCategories();
        ViewEngine::render('store/home.html.twig', $data);
    }
}
