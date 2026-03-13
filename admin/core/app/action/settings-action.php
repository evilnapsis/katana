<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}

if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	if(count($_POST)>0){
		foreach($_POST as $p => $v){
			ConfigurationData::updateValFromName($p,$v);
		}
		Core::redir("./?view=settings&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="updatepm"){
	if(count($_POST)>0){
		foreach($_POST as $p => $v){
			ConfigurationData::updateValFromName($p,$v);
		}
		Core::redir("./?view=settings&opt=payment");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="switchpm"){
	$pay = PaymethodData::getById($_GET["id"]);
	$pay->is_active = $pay->is_active?0:1;
	$pay->update();
	Core::redir("./?view=settings&opt=payment");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="changepass"){
	if(count($_POST)>0){
		$user = UserData::getById($_SESSION["user_id"]);
		if(sha1(md5($_POST["password"])) == $user->password){
			if($_POST["newpassword"] == $_POST["confirmnewpassword"]){
				$user->password = sha1(md5($_POST["newpassword"]));
				$user->update_passwd();
				Core::alert("Contraseña actualizada exitosamente!");
			}else{
				Core::alert("Las contraseñas no coinciden.");
			}
		}else{
			Core::alert("La contraseña actual es incorrecta.");
		}
		Core::redir("./?view=settings&opt=password");
	}
}
?>
