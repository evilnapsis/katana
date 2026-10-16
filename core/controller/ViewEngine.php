<?php

/**
 * Clase ViewEngine
 * 
 * Helper / Wrapper para inicializar el motor de plantillas Twig y renderizar vistas HTML
 * con variables globales (base_url, session, flashes) inyectadas automaticamente.
 */
class ViewEngine {
    /** @var \Twig\Environment|null Instancia singleton de Twig */
    private static ?\Twig\Environment $twig = null;

    /**
     * Inicializa el entorno de Twig con el cargador de archivos desde la carpeta 'public'
     * @return \Twig\Environment
     */
    public static function init(): \Twig\Environment {
        if (self::$twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../public');
            self::$twig = new \Twig\Environment($loader, [
                'cache' => false, // Para produccion cambiar a __DIR__ . '/../../storage/cache'
                'debug' => true,
            ]);
            
            // Calculo de la URL base del proyecto para soportar subcarpetas dinamicamente
            $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
            self::$twig->addGlobal('base_url', $baseUrl);

            // URL del panel admin legacy (admin/), usada por los modulos del sidebar aun no migrados a LegoBox v5
            self::$twig->addGlobal('legacy_admin_url', rtrim(dirname($baseUrl), '/\\') . '/admin');

            // URL de la tienda publica legacy (katana7/), usada por las funciones aun no migradas (carrito, checkout, cuenta de cliente, preguntas/calificaciones)
            self::$twig->addGlobal('legacy_public_url', rtrim(dirname($baseUrl), '/\\'));
            
            // Registro de globales y helpers para seguridad CSRF
            self::$twig->addGlobal('csrf_token', Session::csrfToken());
            self::$twig->addFunction(new \Twig\TwigFunction('csrf_field', function() {
                return '<input type="hidden" name="csrf_token" value="' . Session::csrfToken() . '">';
            }, ['is_safe' => ['html']]));

            self::$twig->addFilter(new \Twig\TwigFilter('nl2br', function($text) {
                return nl2br(htmlspecialchars($text ?? ''));
            }, ['is_safe' => ['html']]));
        }
        return self::$twig;
    }

    /**
     * Renderiza una plantilla Twig y la imprime en la salida HTTP
     * @param string $template Nombre del archivo relativo a 'public/' (ej. 'persons/index.html.twig')
     * @param array $data Arreglo de variables a pasar a la vista
     */
    public static function render(string $template, array $data = []): void {
        $twig = self::init();
        $twig->addGlobal('session', $_SESSION ?? []);
        $twig->addGlobal('flashes', Session::getFlashes());
        echo $twig->render($template, $data);
    }
}