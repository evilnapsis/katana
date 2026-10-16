<?php
namespace App\Controller\Admin;

use App\Service\DashboardService;
use ViewEngine;

/**
 * Controlador principal del Dashboard de Katana Pro Admin.
 * Proporciona métricas, gráficas de ventas, productos top y actividad reciente.
 */
class DashboardController {
    private DashboardService $dashboardService;

    public function __construct() {
        $this->dashboardService = new DashboardService();
    }

    public function index() {
        $user = isset($_SESSION['user_id']) ? \UserData::find($_SESSION['user_id']) : null;
        $dashboardData = $this->dashboardService->getDashboardData();

        ViewEngine::render('admin/dashboard.html.twig', array_merge([
            'user' => $user,
        ], $dashboardData));
    }
}
