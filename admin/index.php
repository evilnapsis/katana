<?php
/**
 * Katana Lite Admin - Front Controller & Router Principal
 * 
 * Este archivo centraliza la recepcion de todas las solicitudes HTTP del panel de administracion,
 * inicializa el enrutador FastRoute, valida la sesion administrativa y despacha a controladores Twig.
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once __DIR__ . '/core/autoload.php';

session_start();

use App\Service\AuthService;

// Carga modular de las rutas administrativas
$routes = require_once __DIR__ . '/core/app/routes.php';
$dispatcher = FastRoute\simpleDispatcher($routes);

// Captura del metodo HTTP y la URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Limpieza de parametros Query String (?page=1)
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

// Eliminacion automatica del prefijo si se encuentra en un subdirectorio (ej. /katana-legobox/admin)
$baseFolder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if (!empty($baseFolder) && strpos($uri, $baseFolder) === 0) {
    $uri = substr($uri, strlen($baseFolder));
}
if (empty($uri)) {
    $uri = '/';
}

// Despacho de la ruta mediante FastRoute
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        ViewEngine::render('404.html.twig');
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo "405 Método No Permitido";
        break;

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1]; // [ClaseController, Metodo]
        $vars = $routeInfo[2];    // Variables URL

        // Validacion CSRF para solicitudes POST
        if ($httpMethod === 'POST' && strpos($uri, '/api/') !== 0) {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            if (!Session::validateCsrf($token)) {
                http_response_code(403);
                echo "<html><head><title>403 Forbidden - CSRF Token Invalid</title><meta charset='UTF-8'></head><body style='font-family:sans-serif; text-align:center; padding-top:10%; background:#f8f9fa; color:#333;'><h1>403 Acceso Prohibido</h1><p>El token CSRF no es válido o ha expirado. Por favor, regresa, recarga el formulario e intenta de nuevo.</p></body></html>";
                exit;
            }
        }

        // Middleware de sesion: cualquier controlador del panel admin (excepto su login) requiere autenticacion
        if ($handler[0] !== App\Controller\Admin\AuthController::class && !AuthService::check()) {
            header('Location: ' . $baseFolder . '/login');
            exit;
        }

        // Ejecucion dinamica del controlador y su metodo
        list($controllerClass, $method) = $handler;
        $controller = new $controllerClass();
        $controller->$method($vars);
        break;
}
?>
