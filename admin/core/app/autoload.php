<?php
/**
 * LegoBox v5 - Autoloader para el Admin
 */

function admin_autoload($className) {
    if (Model::exists($className)) {
        include Model::getFullpath($className);
        return;
    }

    if (strpos($className, 'App\\') === 0) {
        $parts = explode('\\', $className);
        if (count($parts) >= 3) {
            $subfolder = strtolower($parts[1]); // 'controller' o 'service'
            $classname = end($parts);
            $fullpath = __DIR__ . "/" . $subfolder . "/" . $classname . ".php";
            if (file_exists($fullpath)) {
                include $fullpath;
                return;
            }
        }
    }
}

spl_autoload_register("admin_autoload");
?>
