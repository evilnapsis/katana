<div class="row">
<div class="col-md-12">
<h1>BIENVENIDO A KATANA</h1>
<p>Katana es un sistema de tienda en linea.</p>

<?php
$status = StatusData::getAll();
?>
<?php if(count($status)>0):?>

              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-th-list"></i> Operaciones
                </div>
                <div class="widget-body medium no-padding">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>

<thead>
  <th>Estado</th>
  <th>Cantidad</th>
</thead>
<?php foreach($status as $cat):?>
                        <tr>
                        <td><?php echo $cat->name; ?></td>
                        <td><?php $d= BuyData::countByStatusId($cat->id); echo $d->c; ?></td>
                        </tr>
<?php endforeach; ?>

                      </tbody>
                    </table>
                  </div> 

<?php endif; ?>
                </div>
              </div>





</div>
</div>


<br><br>