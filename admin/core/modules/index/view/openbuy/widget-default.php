
<?php

$buy = BuyData::getById($_GET["buy_id"]);
$products = BuyProductData::getAllByBuyId($_GET["buy_id"]);
$client = ClientData::getById($buy->client_id);
$paymethod = $buy->getPaymethod();
$iva = ConfigurationData::getByPreffix("general_iva")->val;
$coin = ConfigurationData::getByPreffix("general_coin")->val;
$ivatxt = ConfigurationData::getByPreffix("general_iva_txt")->val;
?>
<div class="row">
	<div class="col-md-12">
	<h2> Compra #<?php echo $buy->id; ?> [<?php echo $buy->getStatus()->name; ?>]</h2>
	<h4>Cliente: <?php echo $client->getFullname(); ?></h4>
	<h4>Metodo de pago : <?php echo $paymethod->name; ?></h4>
<?php if(count($products)>0):?>
<table class="table table-bordered">
	<thead>
		<th></th>
		<th>Codigo</th>
		<th>Total</th>
		<th>Estado</th>
	</thead>
	<?php foreach($products as $p):
$px = $p->getProduct();
	?>
	<tr>
		<td><a target="_blank" href="../index.php?view=producto&product_id=<?php echo $px->id; ?>">Detalles</a></td>
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
</div>
</div>
<div class="row">
<div class="col-md-12">
<!--
<form class="form-horizontal" role="form" method="post" action="index.php?action=changestatus">
  <div class="form-group">
    <label for="inputEmail1" class="col-md-3 control-label">Estado</label>
    <div class="col-md-6">
<select name="status_id" class="form-control">
<?php foreach(StatusData::getAll() as $s):?>
<option value="<?php echo $s->id; ?>" <?php if($s->id==$buy->status_id){ echo "selected"; }?>><?php echo $s->name; ?></option>
<?php endforeach; ?>
</select>
    </div>

    <div class="col-md-3">
      <input type="hidden" name="buy_id" value="<?php echo $buy->id; ?>">
      <button type="submit" class="btn btn-default">Cambiar Estado</button>

    </div>

  </div>
</form>
-->

</div>
</div>


<?php endif; ?>
	</div>
</div>





