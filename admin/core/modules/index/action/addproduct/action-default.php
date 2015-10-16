<?php
// print_r($_POST);
$product =  new ProductData();
foreach ($_POST as $k => $v) {
	$product->$k = $v;
	# code...
}
$alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
$code = "";
for($i=0;$i<11;$i++){
    $code .= $alphabeth[rand(0,strlen($alphabeth)-1)];
}
        $product->short_name= $code;


    		$handle = new Upload($_FILES['image']);
        	if ($handle->uploaded) {
        		$url="storage/products/";
            	$handle->Process($url);

                $product->image = $handle->file_dst_name;
    		}
if(isset($_POST["is_public"])) { $product->is_public=1; }else{ $product->is_public=0; }
if(isset($_POST["in_existence"])) { $product->in_existence=1; }else{ $product->in_existence=0; }
if(isset($_POST["is_featured"])) { $product->is_featured=1; }else{ $product->is_featured=0; }

// $product->name = $_POST["name"];

$product->add();

Core::redir("index.php?view=products");

?>