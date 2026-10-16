<?php
namespace App\Controller\Admin;

use App\Service\ProductService;
use App\Service\CategoryService;
use ViewEngine;
use Request;
use Session;

class ProductController {
    private $productService;
    private $categoryService;
    private $baseFolder;

    public function __construct() {
        $this->productService = new ProductService();
        $this->categoryService = new CategoryService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    public function index() {
        ViewEngine::render('admin/products/index.html.twig', [
            'products' => $this->productService->getAll(),
            'categories' => array_column($this->categoryService->getAll(), null, 'id'),
        ]);
    }

    public function new() {
        ViewEngine::render('admin/products/new.html.twig', [
            'units' => \UnitData::all(),
            'categories' => $this->categoryService->getAll(),
            'coin' => (\ConfigurationData::getByPreffix('general_coin')->val ?? '$'),
        ]);
    }

    public function create() {
        $this->productService->create(Request::post(), $_FILES['image'] ?? null);
        Session::flash('success', 'Producto agregado.');
        header('Location: ' . $this->baseFolder . '/products');
    }

    public function edit($vars) {
        $product = $this->productService->getById((int)$vars['id']);
        if (!$product) { http_response_code(404); ViewEngine::render('404.html.twig'); return; }

        ViewEngine::render('admin/products/edit.html.twig', [
            'product' => $product,
            'units' => \UnitData::all(),
            'categories' => $this->categoryService->getAll(),
            'coin' => (\ConfigurationData::getByPreffix('general_coin')->val ?? '$'),
        ]);
    }

    public function update($vars) {
        $id = (int)$vars['id'];
        $this->productService->update($id, Request::post(), $_FILES['image'] ?? null);
        Session::flash('success', 'Producto actualizado.');
        header('Location: ' . $this->baseFolder . '/product/' . $id . '/edit');
    }

    public function delete($vars) {
        $this->productService->delete((int)$vars['id']);
        Session::flash('info', 'Producto eliminado.');
        header('Location: ' . $this->baseFolder . '/products');
    }
}
