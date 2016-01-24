<?php

if(!empty($_POST)){
$client =  new ClientData();
$client->name = $_POST["name"];
$client->lastname = $_POST["lastname"];
$client->email = $_POST["email"];
$client->address = $_POST["address"];
@$client->password = crypt($_POST["password"]);
$client->phone = $_POST["phone"];
$client->add();
Core::redir("./?view=clients");
}

?>