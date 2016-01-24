<?php
if(isset($_SESSION["admin_id"]) ){
	$pm = PaymethodData::getById($_GET["id"]);
	//print_r($pm);
	if(!$pm->is_active){
		$pm->is_active = 1;
		$pm->update_active();
	}else{
		$pm->is_active = 0;
		$pm->update_active();

	}
	Core::redir("./?view=payment_settings");
}
?>