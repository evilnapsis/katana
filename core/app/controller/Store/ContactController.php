<?php
namespace App\Controller\Store;

use App\Service\Store\ContactService;
use App\Service\Store\CatalogService;
use ViewEngine;
use Request;
use Session;

class ContactController {
    private $contactService;
    private $baseFolder;

    public function __construct() {
        $this->contactService = new ContactService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    public function show() {
        ViewEngine::render('store/contact.html.twig', [
            'nav_categories' => (new CatalogService())->getNavCategories(),
        ]);
    }

    public function send() {
        $this->contactService->send(Request::post());
        Session::flash('success', 'Gracias por contactarnos.');
        header('Location: ' . $this->baseFolder . '/contact');
    }
}
