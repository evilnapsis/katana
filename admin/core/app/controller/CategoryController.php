<?php
namespace App\Controller\Admin;

use App\Service\CategoryService;
use ViewEngine;
use Request;
use Session;

class CategoryController {
    private $categoryService;
    private $baseFolder;

    public function __construct() {
        $this->categoryService = new CategoryService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    public function index() {
        ViewEngine::render('admin/categories/index.html.twig', [
            'categories' => $this->categoryService->getAll(),
        ]);
    }

    public function create() {
        $this->categoryService->create(Request::post());
        Session::flash('success', 'Categoria agregada.');
        header('Location: ' . $this->baseFolder . '/categories');
    }

    public function update($vars) {
        $data = Request::post();
        $this->categoryService->update((int)$vars['id'], $data);
        Session::flash('success', 'Categoria actualizada.');
        header('Location: ' . $this->baseFolder . '/categories');
    }

    public function delete($vars) {
        $this->categoryService->delete((int)$vars['id']);
        Session::flash('info', 'Categoria eliminada.');
        header('Location: ' . $this->baseFolder . '/categories');
    }
}
