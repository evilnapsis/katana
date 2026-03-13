<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(count($_POST)>0){
		$product =  new SlideData();
		foreach ($_POST as $k => $v) {
			$product->$k = $v;
		}

		if(isset($_FILES["image"])){
    		$handle = new Upload($_FILES['image']);
        	if ($handle->uploaded) {
        		$url="storage/slides/";
            	$handle->Process($url);
                $product->image = $handle->file_dst_name;
    		}
		}

		if(isset($_POST["is_public"])) { $product->is_public=1; }else{ $product->is_public=0; }

		$product->add();
		Core::redir("./?view=slider&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
	if(count($_POST)>0){
		$product = SlideData::getById($_POST["id"]);
		foreach ($_POST as $k => $v) {
			$product->$k = $v;
		}

		if(isset($_FILES["image"])){
			$handle = new Upload($_FILES['image']);
			if ($handle->uploaded) {
				$url="storage/slides/";
				$handle->Process($url);
			    $product->image = $handle->file_dst_name;
			    $product->update_image();
			}
		}

		if(isset($_POST["is_public"])) { $product->is_public=1; }else{ $product->is_public=0; }

		$product->update();
		$_SESSION["product_updated"]= 1;
		Core::redir("./?view=slider&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$product = SlideData::getById($_GET["id"]);
	$product->del();
	Core::redir("./?view=slider&opt=all");
}
?>
