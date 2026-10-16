<?php

// Core database and model includes
include "controller/Database.php";
include "controller/Model.php";
include "controller/LbModel.php";
include "controller/Extra.php";

// Third-party upload utility
include "controller/class.upload.php";

// Modern LegoBox v5 core controllers
include "controller/Session.php";
include "controller/Request.php";
include "controller/Response.php";
include "controller/ViewEngine.php";
include __DIR__ . "/app/autoload.php";
?>