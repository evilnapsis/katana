<?php
print "Este es un <b>Action</b><br>";
print "Es una rutina de codigo que se puede ejecutar en cualquier momento.<br>";
print "Localicacion: <b>core/modules/index/action/page1/action-default.php</b><br>";
print "Invocacion <b>Action::execute({nombre dela accion},{parametros})</b> <br>";
print "Resultado: <b>core/modules/index/{nombre de la accion}/page1/action-default.php</b><br>";
print "Resultado de parametros ingresados.<br>";
print_r($params);
print $params->hola;

?>