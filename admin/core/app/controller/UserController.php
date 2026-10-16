<?php
namespace App\Controller\Admin;

use App\Service\UserService;
use ViewEngine;
use Request;
use Session;

class UserController {
    private $userService;
    private $baseFolder;

    public function __construct() {
        $this->userService = new UserService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    public function index() {
        ViewEngine::render('admin/users/index.html.twig', [
            'users' => $this->userService->getAll(),
        ]);
    }

    public function new() {
        ViewEngine::render('admin/users/new.html.twig');
    }

    public function create() {
        $this->userService->create(Request::post());
        Session::flash('success', 'Usuario agregado.');
        header('Location: ' . $this->baseFolder . '/users');
    }

    public function edit($vars) {
        $user = $this->userService->getById((int)$vars['id']);
        if (!$user) { http_response_code(404); ViewEngine::render('404.html.twig'); return; }
        ViewEngine::render('admin/users/edit.html.twig', ['editUser' => $user]);
    }

    public function update($vars) {
        $this->userService->update((int)$vars['id'], Request::post());
        Session::flash('success', 'Usuario actualizado.');
        header('Location: ' . $this->baseFolder . '/users');
    }
}
