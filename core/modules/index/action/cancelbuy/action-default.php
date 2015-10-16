<?php
 print_r($_POST);
$buy = BuyData::getById($_POST["buy_id"]);
$buy->cancel();

Core::redir("index.php?view=client");

?>