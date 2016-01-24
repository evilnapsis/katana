<?php if(isset($_SESSION["client_id"])):
$client = ClientData::getById($_SESSION["client_id"]);
$iva = ConfigurationData::getByPreffix("general_iva")->val;
$coin = ConfigurationData::getByPreffix("general_coin")->val;
$ivatxt = ConfigurationData::getByPreffix("general_iva_txt")->val;

?>

<?php

$buy = BuyData::getByCode($_GET["code"]);
$products = BuyProductData::getAllByBuyId($buy->id);

?>
<div class="container">
<div class="row">

<div class="col-md-12">
<h3>Bienvenido, <?php echo $client->name." ".$client->lastname; ?></h3>
	<a href="./index.php?view=client" class="btn btn-default"><i class="fa fa-chevron-left"></i> Regresar</a>
	<a href="./invoice.php?code=<?php echo $buy->code;?>" class="btn btn-default"><i class="fa fa-file-o"></i> Imprimir</a>
<br></div>


</div>
</div>
<div class="container">
<div class="row">
	<div class="col-md-12">
<?php if($buy->status_id==1):?>
<p class="alert alert-warning">Operacion Pendiente</p>
<?php elseif($buy->status_id >= 2 && $buy->status_id <=4 ):?>
<p class="alert alert-info"><?php echo StatusData::getById($buy->status_id)->name; ?></p>
<?php elseif($buy->status_id==5):?>
<p class="alert alert-danger">Operacion Cancelada</p>
<?php endif; ?>
	<h2> Compra #<?php echo $buy->id; ?></h2>
<?php if(count($products)>0):?>
<table class="table table-bordered">
	<thead>
		<th></th>
		<th>Cantidad</th>
		<th>Unidad</th>
		<th>Codigo</th>
		<th>Total</th>
		<th>Estado</th>
	</thead>
	<?php foreach($products as $p):
$px = $p->getProduct();
	?>
	<tr>
		<td><a href="index.php?view=producto&product_id=<?php echo $px->id; ?>">Detalles</a></td>
		<td><?php echo $p->q; ?></td>
		<td><?php echo $px->getUnit()->name; ?></td>
		<td><?php echo $px->code; ?></td>
		<td><?php echo $px->name; ?></td>
		<td><?php echo $coin; ?> <?php echo number_format($px->price*$p->q,2,".",","); ?></td>
	</tr>

	<?php endforeach; ?>
</table>


<div class="row">
<div class="col-md-5 col-md-offset-7">
	<table class="table table-bordered">
		<tr>
			<td>Subtotal</td><td><?php echo $coin; ?> <?php echo number_format($buy->getTotal()-($buy->getTotal()*($iva/100)),2,".",","); ?></td>
		</tr>
		<tr>
			<td><?php echo $ivatxt; ?></td><td><?php echo $coin; ?> <?php echo number_format($buy->getTotal()*($iva/100),2,".",","); ?></td>
		</tr>
		<tr>
			<td>Total</td><td><?php echo $coin; ?> <?php echo number_format($buy->getTotal(),2,".",","); ?></td>
		</tr>
	</table>
<br>

<?php if($buy->status_id==1):?>
<form method="post" action="index.php?action=cancelbuy">
<input type="submit" class="btn btn-danger btn-block" value="Cancelar Compra">
<input type="hidden" name="buy_id" value="<?php echo $buy->id; ?>">
</form>
<?php endif; ?>
</div>
</div>

<?php endif; ?>
	</div>
</div>
</div>



<?php endif; ?>
