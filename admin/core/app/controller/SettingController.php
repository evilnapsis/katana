<?php
namespace App\Controller\Admin;

use App\Service\SettingService;
use ViewEngine;
use Request;
use Session;

class SettingController {
    private $settingService;
    private $baseFolder;

    public function __construct() {
        $this->settingService = new SettingService();
        $this->baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    public function index() {
        ViewEngine::render('admin/settings/index.html.twig', [
            'settings' => $this->settingService->getGeneral(),
        ]);
    }

    public function update() {
        $this->settingService->update(Request::post());
        Session::flash('success', 'Ajustes actualizados.');
        header('Location: ' . $this->baseFolder . '/settings');
    }

    public function paymentSettings() {
        $paymethods = $this->settingService->getPaymethods();
        ViewEngine::render('admin/settings/payment.html.twig', [
            'paymethods' => $paymethods,
            'bank_active' => $this->settingService->isPaymethodActiveByShortName($paymethods, 'bank'),
            'bank_settings' => $this->settingService->getByPrefix('bank_'),
        ]);
    }

    public function updatePaymentSettings() {
        $this->settingService->update(Request::post());
        Session::flash('success', 'Datos de pago actualizados.');
        header('Location: ' . $this->baseFolder . '/settings/payment');
    }

    public function togglePaymethod($vars) {
        $this->settingService->togglePaymethod((int)$vars['id']);
        header('Location: ' . $this->baseFolder . '/settings/payment');
    }
}
