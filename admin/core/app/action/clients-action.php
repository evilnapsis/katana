<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(count($_POST)>0){
		$client = new ClientData();
		$client->name = $_POST["name"];
		$client->lastname = $_POST["lastname"];
		$client->address = $_POST["address"];
		$client->phone = $_POST["phone"];
		$client->email = $_POST["email"];
		$client->password = sha1(md5($_POST["password"]));
		$client->add();
		Core::redir("./?view=clients&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
	if(count($_POST)>0){
		$client = ClientData::getById($_POST["id"]);
		$client->name = $_POST["name"];
		$client->lastname = $_POST["lastname"];
		$client->address = $_POST["address"];
		$client->phone = $_POST["phone"];
		$client->email = $_POST["email"];
		$client->update();
		Core::redir("./?view=clients&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$client = ClientData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=clients&opt=all");
}
?>
