<?php

print_r($_POST);
print_r($_SESSION["cart"]);

$cart = $_SESSION["cart"];
$cnt=0;
$_SESSION["cart"]==array();

foreach ($cart as $c) {
	if($c["product_id"]==$_POST["p_id"]){
		$c["q"] = $_POST["q"];
	}
	$_SESSION["cart"][$cnt]=$c;
	$cnt++;
}


?>