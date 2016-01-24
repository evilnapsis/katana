<?php

$cat = ProductData::getById($_GET["product_id"]);
$cat->del();

Core::redir("index.php?view=products");
?>