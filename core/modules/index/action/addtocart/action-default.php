<?php



if(!isset($_SESSION["cart"])){
	$_SESSION["cart"] = array( array("product_id"=>$_GET["product_id"],"q"=>1 ));
}else{
	
	$products = $_SESSION["cart"];
	$news = array();
	$newp = array("product_id"=>$_GET["product_id"],"q"=>1);
		if(!in_array($newp, $products)){
			array_push($products, $newp);
		}
		$_SESSION["cart"]=$products;
}
//print_r($products);

if($_GET["href"]=="product"){
Core::redir("index.php?view=producto&product_id=".$_GET["product_id"]);
}else if($_GET["href"]=="cat"){
	$p =  ProductData::getById($_GET["product_id"]);
	$cat = CategoryData::getById($p->category_id);
	Core::redir("index.php?view=productos&cat=".$cat->short_name);
}




?>