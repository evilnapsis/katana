<?php
namespace App\Controller\Store;

use App\Service\Store\ClientAuthService;
use App\Service\Store\CatalogService;
use ViewEngine;
use Request;
use Session;

class AuthController {
    private $authService;
    private $baseFolder;

    public function __construct() {
        $this->authService = new ClientAuthService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    private function navCategories(): array {
        return (new CatalogService())->getNavCategories();
    }

    public function showLogin() {
        ViewEngine::render('store/login.html.twig', ['nav_categories' => $this->navCategories()]);
    }

    public function login() {
        $email = Request::post('email', '');
        $password = Request::post('password', '');

        if ($this->authService->login($email, $password)) {
            header('Location: ' . $this->baseFolder . '/');
        } else {
            ViewEngine::render('store/login.html.twig', [
                'error' => 'Datos incorrectos!',
                'nav_categories' => $this->navCategories(),
            ]);
        }
    }

    public function showRegister() {
        ViewEngine::render('store/register.html.twig', ['nav_categories' => $this->navCategories()]);
    }

    public function register() {
        $error = $this->authService->register(Request::post());
        if ($error) {
            ViewEngine::render('store/register.html.twig', [
                'error' => $error,
                'nav_categories' => $this->navCategories(),
            ]);
            return;
        }
        Session::flash('success', 'Registro exitoso. Ya puedes iniciar sesión.');
        header('Location: ' . $this->baseFolder . '/login');
    }

    public function logout() {
        $this->authService->logout();
        header('Location: ' . $this->baseFolder . '/');
    }
}
