<?php

$cat = CategoryData::getById($_GET["category_id"]);
$cat->del();

Core::redir("index.php?view=categories");
?>