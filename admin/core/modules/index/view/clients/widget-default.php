        <!-- Main Content -->

          <div class="row">
            <div class="col-md-12">
  <!-- Button trigger modal -->


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

                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>
<?php
$categories = ClientData::getAll();
 if(count($categories)>0):?>
<thead>
  <th>Nombre</th>
  <th>Email</th>

  <th></th>
</thead>
<?php foreach($categories as $cat):?>
                        <tr>
                        <td><?php echo $cat->name; ?></td>
                        <td><?php echo $cat->email; ?></td>
                        <td style="width:90px;">
                        <a href="index.php?view=editproduct&product_id=<?php echo $cat->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a> 
                        <a href="index.php?action=delclient&client_id=<?php echo $cat->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> 
                        </td>
                        </tr>
<?php endforeach; ?>
 <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
