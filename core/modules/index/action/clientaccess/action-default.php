<?php


// print_r($_POST);
$users = ClientData::getByEmail($_POST["email"]);
$found = false;
// print_r($user);

foreach ($users as $user) {
	if(sha1(md5($_POST["password"]))==$user->password){
		$_SESSION["client_id"]=$user->id;
		$found=true;
	}
}

if($found){
	Core::redir("index.php?view=client");
}else{
	Core::redir("index.php?view=clientaccess");
}

?>

