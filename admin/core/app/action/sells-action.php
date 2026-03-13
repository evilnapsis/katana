<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}

if(isset($_GET["opt"]) && $_GET["opt"]=="status"){
	$buy =  BuyData::getById($_GET["id"]);
	$buy->status_id = $_GET["status"];
	$buy->change_status();
	Core::redir("./?view=sells&opt=all");
}
?>
