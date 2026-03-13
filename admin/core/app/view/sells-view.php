<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
if($user==null){ Core::redir("./");}
$coin = ConfigurationData::getByPreffix("general_coin")->val;
?>
<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Ventas</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-primary"></div>
      <div class="card-header">
        <h3 class="card-title">Historial de Ventas</h3>
      </div>
      <div class="card-body">
    <?php
    $buys = BuyData::getAll();
    if(count($buys)>0):?>
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
          <thead>
            <tr>
              <th></th>
              <th>Operacion</th>
              <th>Cliente</th>
              <th>Total</th>
              <th>Metodo de pago</th>
              <th>Estado</th>
              <th>Fecha</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($buys as $b):
            $discount = 0;
            // $coupon handling skipped due to missing model
            ?>
            <tr>
              <td><a href="./?view=sells&opt=open&id=<?php echo $b->id; ?>" class="btn btn-sm btn-default">Detalles</a></td>
              <td>#<?php echo $b->id; ?></td>
              <td><?php echo $b->getClient()->getFullname(); ?></td>
              <td><?php echo $coin; ?> <?php echo number_format($b->getTotal()-$discount,2,".",","); ?></td>
              <td><?php echo $b->getPaymethod()->name; ?></td>
              <td><?php echo $b->getStatus()->name; ?></td>
              <td><?php echo $b->created_at; ?></td>
              <td>
                <?php if($b->status_id!=5):?>
                  <div class="btn-list flex-nowrap">
                    <a href="./?action=sells&opt=status&id=<?php echo $b->id;?>&status=2" class="btn btn-info btn-sm" title="Pagado"><i class="bi bi-currency-dollar"></i></a>
                    <a href="./?action=sells&opt=status&id=<?php echo $b->id;?>&status=4" class="btn btn-success btn-sm" title="Enviado"><i class="bi bi-truck"></i></a>
                    <a href="./?action=sells&opt=status&id=<?php echo $b->id;?>&status=5" class="btn btn-primary btn-sm" title="Finalizado"><i class="bi bi-check-lg"></i></a>
                    <a href="./?action=sells&opt=status&id=<?php echo $b->id;?>&status=3" class="btn btn-danger btn-sm" title="Cancelado"><i class="bi bi-x-lg"></i></a>
                  </div>
                <?php else:?>
                  <i class="bi bi-check-lg text-success"></i>
                <?php endif;?>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        </div>
    <?php else:?>
        <p class="alert alert-warning mb-0">No hay operaciones.</p>
    <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="open"):?>
<?php
$buy = BuyData::getById($_GET["id"]);
$products = BuyProductData::getAllByBuyId($_GET["id"]);
$client = ClientData::getById($buy->client_id);
$paymethod = $buy->getPaymethod();
$iva = ConfigurationData::getByPreffix("general_iva")->val;
$ivatxt = ConfigurationData::getByPreffix("general_iva_txt")->val;
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Venta #<?php echo $buy->id; ?> [<?php echo $buy->getStatus()->name; ?>]</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-info"></div>
      <div class="card-header">
        <h3 class="card-title">Detalles de la Venta</h3>
      </div>
      <div class="card-body">
        <p><strong>Cliente:</strong> <?php echo $client->getFullname(); ?><br>
        <strong>Metodo de pago:</strong> <?php echo $paymethod->name; ?></p>

        <?php if(count($products)>0):?>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th></th>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($products as $p):
                $px = $p->getProduct();
              ?>
              <tr>
                <td><a target="_blank" href="../index.php?view=producto&product_id=<?php echo $px->id; ?>">Ver</a></td>
                <td><?php echo $px->code; ?></td>
                <td><?php echo $px->name; ?></td>
                <td><?php echo $coin; ?> <?php echo number_format($px->price*$p->q,2,".",","); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="row mt-4">
          <div class="col-md-4 ms-auto">
            <table class="table table-sm table-bordered">
              <tr>
                <td>Subtotal</td><td><?php echo $coin; ?> <?php echo number_format($buy->getTotal()-($buy->getTotal()*($iva/100)),2,".",","); ?></td>
              </tr>
              <tr>
                <td><?php echo $ivatxt; ?></td><td><?php echo $coin; ?> <?php echo number_format($buy->getTotal()*($iva/100),2,".",","); ?></td>
              </tr>
              <tr class="fw-bold">
                <td>Total</td><td><?php echo $coin; ?> <?php echo number_format($buy->getTotal(),2,".",","); ?></td>
              </tr>
            </table>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="report"):?>
<?php
$buys = array();
if(isset($_GET["start_at"]) && isset($_GET["finish_at"]) && $_GET["start_at"]!="" && $_GET["finish_at"]!=""){
  $buys = BuyData::getByRange($_GET["start_at"],$_GET["finish_at"]);
}else{
  $buys = BuyData::getAll();
}
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Reporte de Ventas</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card mb-3">
      <div class="card-body">
        <form method="get">
          <input type="hidden" name="view" value="sells">
          <input type="hidden" name="opt" value="report">
          <div class="row g-2">
            <div class="col-md-5">
              <input type="date" name="start_at" class="form-control" value="<?php echo @$_GET["start_at"];?>">
            </div>
            <div class="col-md-5">
              <input type="date" name="finish_at" class="form-control" value="<?php echo @$_GET["finish_at"];?>">
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Generar</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-status-top bg-primary"></div>
      <div class="card-header">
        <h3 class="card-title">Resultados</h3>
      </div>
      <div class="card-body">
        <?php if(count($buys)>0):?>
        <div class="table-responsive">
          <table class="table card-table table-vcenter text-nowrap datatable">
            <thead>
              <tr>
                <th>Operacion</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Metodo de pago</th>
                <th>Estado</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($buys as $b):
              $discount = 0;
              ?>
              <tr>
                <td>#<?php echo $b->id; ?></td>
                <td><?php echo $b->getClient()->getFullname(); ?></td>
                <td><?php echo $coin; ?> <?php echo number_format($b->getTotal()-$discount,2,".",","); ?></td>
                <td><?php echo $b->getPaymethod()->name; ?></td>
                <td><?php echo $b->getStatus()->name; ?></td>
                <td><?php echo $b->created_at; ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else:?>
          <p class="alert alert-warning mb-0">No hay operaciones en este rango.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
