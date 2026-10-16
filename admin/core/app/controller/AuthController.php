<?php
namespace App\Controller\Admin;

use App\Service\AuthService;
use ViewEngine;
use Request;
use Session;

/**
 * Controlador de autenticacion del panel de administracion de Katana Pro.
 * Valida contra la tabla `user` (staff/admin), separada de `client` (clientes de la tienda).
 */
class AuthController {
    private $authService;
    private $baseFolder;

    public function __construct() {
        $this->authService = new AuthService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    public function showLogin() {
        if (AuthService::check()) {
            header('Location: ' . $this->baseFolder . '/');
            exit;
        }
        ViewEngine::render('admin/login.html.twig');
    }

    public function login() {
        $username = Request::post('username');
        $password = Request::post('password');

        if ($this->authService->login($username, $password)) {
            Session::flash('success', 'Bienvenido de nuevo.');
            header('Location: ' . $this->baseFolder . '/');
        } else {
            ViewEngine::render('admin/login.html.twig', ['error' => 'Usuario o contraseña incorrectos.']);
        }
    }

    public function logout() {
        $this->authService->logout();
        header('Location: ' . $this->baseFolder . '/login');
    }
}
