<?php



if(count($_SESSION["cart"])==1){
	unset($_SESSION["cart"]);
}else{
	
	$products = $_SESSION["cart"];
	$news = array();
	foreach ($products as $product) {
		if($product["product_id"]!=$_GET["product_id"]){
			array_push($news, $product);
		}
	}
	$_SESSION["cart"]=$news;
}



//print_r($products);

if($_GET["href"]=="cart"){
Core::redir("index.php?view=mycart");
}else if($_GET["href"]=="product"){
	$p =  ProductData::getById($_GET["product_id"]);
	$cat = CategoryData::getById($p->category_id);
	Core::redir("index.php?view=productos&cat=".$cat->short_name);
}




?>