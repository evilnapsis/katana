<?php
namespace App\Controller\Store;

use App\Service\Store\ClientAccountService;
use App\Service\Store\ClientAuthService;
use App\Service\Store\CatalogService;
use ViewEngine;
use Session;

class ClientAccountController {
    private $accountService;
    private $baseFolder;

    public function __construct() {
        $this->accountService = new ClientAccountService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    private function requireLogin(): bool {
        if (!ClientAuthService::check()) {
            header('Location: ' . $this->baseFolder . '/login');
            return false;
        }
        return true;
    }

    public function index() {
        if (!$this->requireLogin()) return;
        $data = $this->accountService->getDashboard((int)$_SESSION['client_id']);
        $data['nav_categories'] = (new CatalogService())->getNavCategories();
        ViewEngine::render('store/account.html.twig', $data);
    }

    public function show($vars) {
        if (!$this->requireLogin()) return;
        $data = $this->accountService->getOrderDetail($vars['code'], (int)$_SESSION['client_id']);
        if (!$data) { http_response_code(404); ViewEngine::render('404.html.twig'); return; }
        $data['nav_categories'] = (new CatalogService())->getNavCategories();
        ViewEngine::render('store/account_order.html.twig', $data);
    }

    public function cancel($vars) {
        if (!$this->requireLogin()) return;
        $ok = $this->accountService->cancelOrder((int)$vars['id'], (int)$_SESSION['client_id']);
        Session::flash($ok ? 'success' : 'error', $ok ? 'Compra cancelada.' : 'No se pudo cancelar la compra.');
        header('Location: ' . $this->baseFolder . '/account');
    }
}
