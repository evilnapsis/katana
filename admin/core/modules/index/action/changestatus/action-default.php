<?php

$buy =  BuyData::getById($_POST["buy_id"]);
$buy->status_id = $_POST["status_id"];
$buy->change_status();

Core::redir("index.php?view=openbuy&buy_id=".$_POST["buy_id"]);
?>