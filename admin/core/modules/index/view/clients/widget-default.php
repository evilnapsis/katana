        <!-- Main Content -->

          <div class="row">
            <div class="col-md-12">
  <!-- Button trigger modal -->

<a href="./?view=newclient" class="btn btn-default pull-right">Nuevo Cliente</a>
            <h2>CLIENTES</h2>
            </div>
            </div>

          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-th-list"></i> Clientes
                </div>
                <div class="widget-body medium no-padding">
<?php
$categories = ClientData::getAll();
 if(count($categories)>0):?>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>

<thead>
  <th>Nombre</th>
  <th>Email</th>

  <th></th>
</thead>
<?php foreach($categories as $cat):?>
                        <tr>
                        <td><?php echo $cat->getFullname(); ?></td>
                        <td><?php echo $cat->email; ?></td>
                        <td style="width:90px;">
                        <a href="index.php?view=editclient&client_id=<?php echo $cat->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a> 
                        <a href="index.php?action=delclient&client_id=<?php echo $cat->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> 
                        </td>
                        </tr>
<?php endforeach; ?>

                      </tbody>
                    </table>
                  </div> 

<?php else:?>
  <div class="panel-body">
  <p class="alert alert-warning">No hay clientes por mostrar, agregar uno o espera a que se registren.</p>
  </div>
<?php endif; ?>
                </div>
              </div>
            </div>

          </div>
