<?php
// print_r($_POST);
if(isset($_SESSION["admin_id"]) && !empty($_POST)){
foreach ($_POST as $p => $k) {
	ConfigurationData::updateValFromName($p,$k);
}
Core::redir("./?view=settings");
}else{
Core::redir("./");

}

?>
