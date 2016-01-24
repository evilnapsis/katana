<?php

if(isset($_SESSION["admin_id"])){

$buy =  BuyData::getById($_GET["id"]);
$buy->status_id = $_GET["status"];
$buy->change_status();



Core::redir("index.php?view=sells");
}
?>