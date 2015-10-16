<?php
// print_r($_SESSION);

$buy = new BuyData();

$alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-";
$code = "";
for($i=0;$i<11;$i++){
    $code .= $alphabeth[rand(0,strlen($alphabeth)-1)];
}


$buy->code = $code;
$buy->client_id = $_SESSION["client_id"];
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
Core::redir("index.php?view=client");

?>