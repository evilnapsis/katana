<?php

if(!empty($_POST)){
$client =  ClientData::getById($_POST["id"]);
$client->name = $_POST["name"];
$client->lastname = $_POST["lastname"];
$client->email = $_POST["email"];
$client->address = $_POST["address"];
$client->phone = $_POST["phone"];
$client->update();

if($_POST["password"]!=""){
@$client->password = crypt($_POST["password"]);
$client->update_passwd();

}


Core::redir("./?view=clients");
}

?>