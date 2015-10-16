<?php

$cat =  new CategoryData();
$cat->name = $_POST["name"];
$cat->short_name = $_POST["short_name"];
if(isset($_POST["is_public"])){ $cat->is_public=1;}else{$cat->is_public=0;}
$cat->add();

 Core::redir("index.php?view=categories");

?>