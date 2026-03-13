<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="login"){
	$user = ClientData::getByMail($_POST["email"]);
	if($user && (sha1(md5($_POST["password"])) == $user->password)){
		$_SESSION["client_id"] = $user->id;
		Core::redir("./?view=client&opt=all");
	}else{
		Core::alert("Datos incorrectos.");
		Core::redir("./?view=client&opt=login");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$check = ClientData::getByMail($_POST["email"]);
	if(!$check){
		$client = new ClientData();
		$client->name = $_POST["name"];
		$client->lastname = $_POST["lastname"];
		$client->email = $_POST["email"];
		$client->password = sha1(md5($_POST["password"]));
		$client->add();
		Core::alert("Registro exitoso, ahora puedes iniciar sesión.");
		Core::redir("./?view=client&opt=login");
	}else{
		Core::alert("El correo ya está registrado.");
		Core::redir("./?view=client&opt=register");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="logout"){
	unset($_SESSION["client_id"]);
	Core::redir("./");
}
?>
