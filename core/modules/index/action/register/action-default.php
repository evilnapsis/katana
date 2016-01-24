<?php

if(isset($_POST["accept"])){
$c= ClientData::getByEmail($_POST["email"]);
if($c==null){
$client =  new ClientData();
$client->name = $_POST["name"];
$client->lastname = $_POST["lastname"];
$client->email = $_POST["email"];
$client->address = $_POST["address"];
$client->password = crypt($_POST["password"]);
$client->phone = $_POST["phone"];
$client->add();


						function clean_input_4email($value, $check_all_patterns = true)
						{
						 $patterns[0] = '/content-type:/';
						 $patterns[1] = '/to:/';
						 $patterns[2] = '/cc:/';
						 $patterns[3] = '/bcc:/';
						 if ($check_all_patterns)
						 {
						  $patterns[4] = '/\r/';
						  $patterns[5] = '/\n/';
						  $patterns[6] = '/%0a/';
						  $patterns[7] = '/%0d/';
						 }
						 //NOTE: can use str_ireplace as this is case insensitive but only available on PHP version 5.0.
						 return preg_replace($patterns, "", strtolower($value));
						}

						$name = clean_input_4email($_POST["name"]);
						$lastname = clean_input_4email($_POST["lastname"]);
						$email = clean_input_4email($_POST["email"]);
						$address = clean_input_4email($_POST["address"]);
						$phone = clean_input_4email($_POST["phone"]);
//						$message = clean_input_4email($_POST["message"], false);
$adminemail = ConfigurationData::getByPreffix("general_main_email");
$replyemail = $adminemail;
$success_sent_msg='
<body style="background:#2b2b2b; text-align:center; margin-top:40px">
Registro exitoso.
</body>

';

$replymessage = '
<meta content="es-mx" http-equiv="Content-Language" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<body>

<p><span class="style3"><strong>Estimado '. $name .'</strong></span></p>
<p>Gracias por contactarnos.</p>
</body>';



$themessage = '
<html>
<meta content="es-mx" http-equiv="Content-Language" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<body>
<table align="center" cellspacing="4" class="style2" style="width: 700">
	<tr>
		<td class="style5" style="width: 204px; height: 10;" valign="top"><strong>
		Nombre del Cliente:</strong></td>
		<td class="style5" style="width: 4px; height: 10;" valign="top">&nbsp;</td>
		<td class="style3" style="width: 550;" valign="top">'. $name." ".$lastname .'</td>
	</tr>
	<tr>
		<td class="style5" style="height: 1;" valign="top" colspan="3">
		<hr class="style28" style="height: 1; width: 98%" /></td>
	</tr>
	<tr>
		<td class="style5" style="width: 204px; height: 10;" valign="top"><strong>
		Correo Electronico:</strong></td>
		<td class="style5" style="width: 4px; height: 10;" valign="top">&nbsp;</td>
		<td class="style3" style="width: 550;" valign="top">'. $email .'</td>
	</tr>
	<tr>
		<td class="style5" style="height: 1;" valign="top" colspan="3">
		<hr class="style28" style="height: 1; width: 98%" /></td>
	</tr>
	<tr>
		<td class="style5" style="width: 204px; height: 10;" valign="top"><strong>
		Direccion:</strong></td>
		<td class="style5" style="width: 4px; height: 10;" valign="top">&nbsp;</td>
		<td class="style3" style="width: 550;" valign="top">'. $address .'</td>
	</tr>
	<tr>
		<td class="style5" style="height: 1;" valign="top" colspan="3">
		<hr class="style28" style="height: 1; width: 98%" /></td>
	</tr>
	<tr>
		<td class="style5" style="width: 204px; height: 10;" valign="top"><strong>
		Telefono:</strong></td>
		<td class="style5" style="width: 4px; height: 10;" valign="top">&nbsp;</td>
		<td class="style3" style="width: 550;" valign="top">'. $phone .'</td>
	</tr>
	
</table>

</body> 
</html>  ';

mail("$replyemail",
     "Katana - Nuevo registro",
     "$themessage",
	 "From: $replyemail\nReply-To: $replyemail\nContent-Type: text/html; charset=ISO-8859-1");

mail("$email",
     "Katana - Nuevo Registro",
     "$replymessage",
	 "From: $replyemail\nReply-To: $replyemail\nContent-Type: text/html; charset=ISO-8859-1");
echo $success_sent_msg;



Core::redir("index.php?view=clientaccess");
}else{
Core::alert("Ya existe un usuario registrado con esta direccion email.");
Core::redir("./?view=register");

}
}
?>