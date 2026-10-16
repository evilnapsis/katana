<?php
namespace App\Controller\Admin;

use App\Service\ClientService;
use ViewEngine;
use Request;
use Session;

class ClientController {
    private $clientService;
    private $baseFolder;

    public function __construct() {
        $this->clientService = new ClientService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    public function index() {
        ViewEngine::render('admin/clients/index.html.twig', [
            'clients' => $this->clientService->getAll(),
        ]);
    }

    public function new() {
        ViewEngine::render('admin/clients/new.html.twig');
    }

    public function create() {
        $this->clientService->create(Request::post());
        Session::flash('success', 'Cliente agregado.');
        header('Location: ' . $this->baseFolder . '/clients');
    }

    public function edit($vars) {
        $client = $this->clientService->getById((int)$vars['id']);
        if (!$client) { http_response_code(404); ViewEngine::render('404.html.twig'); return; }
        ViewEngine::render('admin/clients/edit.html.twig', ['client' => $client]);
    }

    public function update($vars) {
        $this->clientService->update((int)$vars['id'], Request::post());
        Session::flash('success', 'Cliente actualizado.');
        header('Location: ' . $this->baseFolder . '/clients');
    }

    public function delete($vars) {
        $result = $this->clientService->delete((int)$vars['id']);
        if ($result === true) {
            Session::flash('info', 'Cliente eliminado.');
        } else {
            Session::flash('error', is_string($result) ? $result : 'No se pudo eliminar el cliente.');
        }
        header('Location: ' . $this->baseFolder . '/clients');
    }
}
