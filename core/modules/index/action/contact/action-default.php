<?php
if(!empty($_POST)){
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
						$email = clean_input_4email($_POST["email"]);
						$subject = clean_input_4email($_POST["subject"], false);
						$message = clean_input_4email($_POST["message"], false);
$replyemail = "evilnapsis@gmail.com";
$success_sent_msg='
<body style="background:#2b2b2b; text-align:center; margin-top:40px">
Gracias por contactarnos.
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
<meta content="es-mx" http-equiv="Content-Language" />
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<body>
<table align="center" cellspacing="4" class="style2" style="width: 700">
	<tr>
		<td class="style5" style="width: 204px; height: 10;" valign="top"><strong>
		Nombre del Cliente:</strong></td>
		<td class="style5" style="width: 4px; height: 10;" valign="top">&nbsp;</td>
		<td class="style3" style="width: 550;" valign="top">'. $name .'</td>
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
		<td class="style5" style="width: 100%; height: 1;" valign="top" colspan="3">
		<hr class="style28" style="height: 1; width: 98%" /></td>
	</tr>
	<tr>
		<td class="style5" style="width: 204px; height: 20;" valign="top"><strong>
		Asunto:</strong></td>
		<td class="style5" style="width: 4px; height: 20;" valign="top">&nbsp;</td>
		<td class="style3" style="width: 550;" valign="top">'. $subject .'</td>
	</tr>
	<tr>
		<td class="style5" style="width: 100%; height: 1;" valign="top" colspan="3">
		<hr class="style28" style="height: 1; width: 98%" /></td>
	</tr>
	<tr>
		<td class="style5" style="width: 204px; height: 20;" valign="top"><strong>
		Contenido del Mensaje:</strong></td>
		<td class="style5" style="width: 4px; height: 20;" valign="top">&nbsp;</td>
		<td class="style3" style="width: 550;" valign="top">'. $message .'</td>
	</tr>
</table>

</body>   ';

mail("$replyemail",
     "Contacto desde www.tecnotronika.com.mx",
     "$themessage",
	 "From: $replyemail\nReply-To: $replyemail\nContent-Type: text/html; charset=ISO-8859-1");

mail("$email",
     "Tecnotronika",
     "$replymessage",
	 "From: $replyemail\nReply-To: $replyemail\nContent-Type: text/html; charset=ISO-8859-1");
echo $success_sent_msg;
Core::redir("index.php?view=contacto");
}
?>