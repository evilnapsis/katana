<?php
namespace App\Controller\Admin;

use App\Service\SlideService;
use ViewEngine;
use Request;
use Session;

class SlideController {
    private $slideService;
    private $baseFolder;

    public function __construct() {
        $this->slideService = new SlideService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    public function index() {
        ViewEngine::render('admin/slides/index.html.twig', [
            'slides' => $this->slideService->getAll(),
        ]);
    }

    public function new() {
        ViewEngine::render('admin/slides/new.html.twig');
    }

    public function create() {
        $this->slideService->create(Request::post(), $_FILES['image'] ?? null);
        Session::flash('success', 'Slide agregado.');
        header('Location: ' . $this->baseFolder . '/slides');
    }

    public function edit($vars) {
        $slide = $this->slideService->getById((int)$vars['id']);
        if (!$slide) { http_response_code(404); ViewEngine::render('404.html.twig'); return; }
        ViewEngine::render('admin/slides/edit.html.twig', ['slide' => $slide]);
    }

    public function update($vars) {
        $id = (int)$vars['id'];
        $this->slideService->update($id, Request::post(), $_FILES['image'] ?? null);
        Session::flash('success', 'Slide actualizado.');
        header('Location: ' . $this->baseFolder . '/slide/' . $id . '/edit');
    }

    public function delete($vars) {
        $this->slideService->delete((int)$vars['id']);
        Session::flash('info', 'Slide eliminado.');
        header('Location: ' . $this->baseFolder . '/slides');
    }
}
