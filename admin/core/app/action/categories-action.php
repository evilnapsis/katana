<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){
	$cat = new CategoryData();
	$cat->name = $_POST["name"];
	$cat->short_name = $_POST["short_name"];
	$cat->is_active = isset($_POST["is_active"])?1:0;
	$cat->add();
	Core::alert("Categoria agregada!");
	Core::redir("./?view=categories&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="upd"){
if(count($_POST)>0){
	$cat = CategoryData::getById($_POST["id"]);
	$cat->name = $_POST["name"];
	$cat->short_name = $_POST["short_name"];
	$cat->is_active = isset($_POST["is_active"])?1:0;
	$cat->update();
	Core::alert("Categoria actualizada!");
	Core::redir("./?view=categories&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$cat = CategoryData::getById($_GET["id"]);
	$cat->del();
	Core::alert("Categoria eliminada!");
	Core::redir("./?view=categories&opt=all");
}
?>
