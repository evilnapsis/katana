<?php
// autoload.php - Tienda Publica Katana Pro
// Carga modelos desde admin/core/app/model y controladores/servicios de tienda

function my_autoload($className){
	if(Model::exists($className)){
		include Model::getFullpath($className);
		return;
	} 

	// Fallback autoloader for App\Controller\ and App\Service\
	if(strpos($className, 'App\\') === 0){
		$parts = explode('\\', $className);
		if(count($parts) >= 3){
			$subfolder = strtolower($parts[1]); // 'controller' o 'service'
			$remainder = array_slice($parts, 2);
			$fullpath = __DIR__ . "/" . $subfolder . "/" . implode('/', $remainder) . ".php";
			if(file_exists($fullpath)){
				include $fullpath;
			}
		}
	}
}

spl_autoload_register("my_autoload");
?>