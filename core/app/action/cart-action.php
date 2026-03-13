<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(!isset($_SESSION["cart"])){
		$_SESSION["cart"] = array( array("product_id"=>$_GET["product_id"],"q"=>1 ));
	}else{
		$products = $_SESSION["cart"];
		$found = false;
		foreach($products as $index => $p){
			if($p["product_id"] == $_GET["product_id"]){
				$products[$index]["q"]++;
				$found = true;
				break;
			}
		}
		if(!$found){
			array_push($products, array("product_id"=>$_GET["product_id"],"q"=>1));
		}
		$_SESSION["cart"]=$products;
	}

	if($_GET["href"]=="home"){
		Core::redir("./");
	}else if($_GET["href"]=="cat"){
		$p =  ProductData::getById($_GET["product_id"]);
		$cat = CategoryData::getById($p->category_id);
		Core::redir("./?view=products&opt=all&cat=".$cat->short_name);
	}else if($_GET["href"]=="open"){
		Core::redir("./?view=products&opt=open&id=".$_GET["product_id"]);
	}else{
		Core::redir("./?view=cart&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	if(isset($_SESSION["cart"])){
		$cart = $_SESSION["cart"];
		$newcart = array();
		foreach($cart as $c){
			if($c["product_id"]!=$_GET["product_id"]){
				array_push($newcart, $c);
			}
		}
		$_SESSION["cart"] = $newcart;
	}
	Core::redir("./?view=cart&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="edit"){
	if(isset($_SESSION["cart"])){
		$cart = $_SESSION["cart"];
		foreach($cart as $index => $c){
			if($c["product_id"]==$_POST["product_id"]){
				$cart[$index]["q"] = $_POST["q"];
				break;
			}
		}
		$_SESSION["cart"] = $cart;
	}
	Core::redir("./?view=cart&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="clear"){
	unset($_SESSION["cart"]);
	Core::redir("./?view=cart&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="buy"){
	if(!empty($_POST) && isset($_SESSION["client_id"])){
		$buy = new BuyData();
		$alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
		$code = "";
		for($i=0;$i<11;$i++){
		    $code .= $alphabeth[rand(0,strlen($alphabeth)-1)];
		}
		$buy->code = $code;
		$buy->client_id = $_SESSION["client_id"];
		$buy->paymethod_id= $_POST["paymethod_id"];
		$buy->status_id= 1;
		$b = $buy->add();

		foreach ($_SESSION["cart"] as $c) {
			$p = new BuyProductData();
			$p->buy_id = $b[1];
			$p->product_id = $c["product_id"];
			$p->q = $c["q"];
			$p->add();
		}
		unset($_SESSION["cart"]);
		Core::redir("./?view=client&opt=all");
	}
}
?>
