<?php
namespace App\Controller\Admin;

use App\Service\SellService;
use ViewEngine;
use Session;

class SellController {
    private $sellService;
    private $baseFolder;

    public function __construct() {
        $this->sellService = new SellService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    public function index() {
        ViewEngine::render('admin/sells/index.html.twig', $this->sellService->getDashboard());
    }

    public function show($vars) {
        $id = (int)$vars['id'];
        $detail = $this->sellService->getDetail($id);
        if (!$detail) { http_response_code(404); ViewEngine::render('404.html.twig'); return; }
        ViewEngine::render('admin/sells/show.html.twig', $detail);
    }

    public function history($vars) {
        $id = (int)$vars['id'];
        ViewEngine::render('admin/sells/history.html.twig', [
            'buy_id' => $id,
            'history' => $this->sellService->getHistory($id),
        ]);
    }

    public function changeStatus($vars) {
        $this->sellService->changeStatus((int)$vars['id'], (int)$vars['status']);
        Session::flash('success', 'Estado del pedido actualizado.');
        header('Location: ' . $this->baseFolder . '/sells');
    }
}
