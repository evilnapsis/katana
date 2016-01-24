<?php



/// en caso de que el parametro action este definido evitamos que se muestre
/// el layout por defecto y ejecutamos el action sin mostrar nada de vista
/// print_r($_GET);

if(!isset($_GET["action"])){
//	Bootload::load("default");
	Module::loadLayout();
}else{
///	echo "d:";
	// $params = $_REQUEST;
	Action::load($_GET["action"],new Request());
}

?>