<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$spend = new SpendData();
	$spend->name = $_POST["name"];
	$spend->amount = $_POST["amount"];
	$spend->category_id = $_POST["category_id"];
	$spend->user_id = $_SESSION["user_id"];
	$spend->date_at = $_POST["date_at"];
	$spend->add();
	Core::alert("Gasto agregado!");
	Core::redir("./?view=spends&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$spend = SpendData::getById($_POST["spend_id"]);
	$spend->name = $_POST["name"];
	$spend->amount = $_POST["amount"];
	$spend->category_id = $_POST["category_id"];
	$spend->date_at = $_POST["date_at"];
	$spend->update();
	Core::alert("Gasto actualizado!");
	Core::redir("./?view=spends&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$spend = SpendData::getById($_GET["id"]);
	$spend->del();
	Core::alert("Gasto eliminado!");
	Core::redir("./?view=spends&opt=all");
}
?>
