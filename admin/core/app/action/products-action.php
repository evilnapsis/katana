<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(count($_POST)>0){
		$product =  new ProductData();
		foreach ($_POST as $k => $v) {
			$product->$k = $v;
		}
		$alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
		$code = "";
		for($i=0;$i<11;$i++){
		    $code .= $alphabeth[rand(0,strlen($alphabeth)-1)];
		}
		$product->short_name= $code;

		if(isset($_FILES["image"])){
    		$handle = new Upload($_FILES['image']);
        	if ($handle->uploaded) {
        		$url="storage/products/";
            	$handle->Process($url);
                $product->image = $handle->file_dst_name;
    		}
		}

		if(isset($_POST["is_public"])) { $product->is_public=1; }else{ $product->is_public=0; }
		if(isset($_POST["in_existence"])) { $product->in_existence=1; }else{ $product->in_existence=0; }
		if(isset($_POST["is_featured"])) { $product->is_featured=1; }else{ $product->is_featured=0; }
		if(isset($_POST["is_offert"])) { $product->is_offert=1; }else{ $product->is_offert=0; }

		$product->add();
		Core::redir("./?view=products&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
	if(count($_POST)>0){
		$product = ProductData::getById($_POST["id"]);
		foreach ($_POST as $k => $v) {
			$product->$k = $v;
		}

		if(isset($_FILES["image"])){
			$handle = new Upload($_FILES['image']);
			if ($handle->uploaded) {
				$url="storage/products/";
				$handle->Process($url);
			    $product->image = $handle->file_dst_name;
			    $product->update_image();
			}
		}

		if(isset($_POST["is_public"])) { $product->is_public=1; }else{ $product->is_public=0; }
		if(isset($_POST["in_existence"])) { $product->in_existence=1; }else{ $product->in_existence=0; }
		if(isset($_POST["is_featured"])) { $product->is_featured=1; }else{ $product->is_featured=0; }
		if(isset($_POST["is_offert"])) { $product->is_offert=1; }else{ $product->is_offert=0; }

		$product->update();
		$_SESSION["product_updated"]= 1;
		Core::redir("./?view=products&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$product = ProductData::getById($_GET["id"]);
	$product->del();
	Core::redir("./?view=products&opt=all");
}
?>
