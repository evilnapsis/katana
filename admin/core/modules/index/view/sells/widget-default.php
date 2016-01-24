<?php

$buys =  BuyData::getAll();
$coin = ConfigurationData::getByPreffix("general_coin")->val;

?>
        <!-- Main Content -->

          <div class="row">
          <div class="col-md-12">
          <h1>Ventas</h1>
          </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-tasks"></i> Ventas
                </div>
                <div class="widget-body medium no-padding">

                  <div class="table-responsive">
<?php if(count($buys)>0):?>
                    <table class="table table-bordered">
                    <thead>
                      <th></th>
                      <th>Operacion</th>
                      <th>Cliente</th>
                      <th>SubTotal</th>
                      <th>Descuento</th>
                      <th>Total</th>
                      <th>Metodo de pago</th>
                      <th>Estado</th>
                      <th>Fecha</th>
                      <th></th>
                    </thead>
<?php foreach($buys as $b):
$discount=0;
?>
                        <tr>
                        <td><a href="index.php?view=openbuy&buy_id=<?php echo $b->id; ?>" class="btn btn-xs btn-default">Detalles</a></td>
                        <td>#<?php echo $b->id; ?></td>
                        <td><?php echo $b->getClient()->getFullname(); ?></td>
    <td><?php echo $coin; ?> <?php echo number_format($b->getTotal(),2,".",","); ?></td>
    <td><?php echo $coin; ?>
      <?php if($b->coupon_id!=null){
        $coupon = CouponData::getById($b->coupon_id);
        $discount = $coupon->val;
        echo number_format($discount,2,".",",");
        }else{
        echo number_format($discount,2,".",",");

        }
      ?>
    </td>
    <td><?php echo $coin; ?> <?php echo number_format($b->getTotal()-$discount,2,".",","); ?></td>
                        <td><?php echo $b->getPaymethod()->name; ?></td>
                        <td><?php echo $b->getStatus()->name; ?></td>
                        <td><?php echo $b->created_at; ?></td>
                        <th>
                          <?php if($b->status_id!=5):?>
                            <a href="./?action=changestatus&id=<?php echo $b->id;?>&status=2" class="btn btn-info btn-xs"><i class="fa fa-usd"></i></a>
                            <a href="./?action=changestatus&id=<?php echo $b->id;?>&status=4" class="btn btn-success btn-xs"><i class="fa fa-truck"></i></a>
                            <a href="./?action=changestatus&id=<?php echo $b->id;?>&status=5" class="btn btn-primary btn-xs"><i class="fa fa-check"></i></a>
                            <a href="./?action=changestatus&id=<?php echo $b->id;?>&status=3" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>
                          <?php else:?>
                            <i class="fa fa-check"></i>
                          <?php endif;?>
                        </th>
                        </tr>
<?php endforeach; ?>
                    </table>
<?php else:?>
  <div class="panel-body">
  <h1>No hay operaciones</h1>
  </div>
<?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

          </div>
