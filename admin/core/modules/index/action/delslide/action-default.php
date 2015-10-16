<?php
$s = SlideData::getById($_GET["slide_id"]);
$s->del();

Core::redir("index.php?view=slider");

?>