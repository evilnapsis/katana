<?php

$client = ClientData::getById($_GET["client_id"]);
$client->del();

Core::redir("index.php?view=clients");
?>