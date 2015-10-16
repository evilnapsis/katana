        <!-- Main Content -->

          <div class="row">
            <div class="col-md-12">
                  <a  href="index.php?view=newproduct" class="pull-right btn-sm btn btn-default">Agregar Producto</a>
  <!-- Button trigger modal -->


            <h2>PRODUCTOS</h2>
            </div>
            </div>

          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-th-list"></i> Productos
                </div>
                <div class="widget-body medium no-padding">

                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>
<?php
$categories = ProductData::getAll();
 if(count($categories)>0):?>
<thead>
  <th>Nombre</th>
  <th>Visible</th>
  <th>Destacado</th>
  <th>Existencia</th>
  <th></th>
</thead>
<?php foreach($categories as $cat):?>
                        <tr>
                        <td><?php echo $cat->name; ?></td>
                        <td style="width:90px;"><center><?php if($cat->is_public):?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-remove"></i><?php endif; ?></center> </td>
                        <td style="width:90px;"><center><?php if($cat->is_featured):?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-remove"></i><?php endif; ?></center> </td>
                        <td style="width:90px;"><center><?php if($cat->in_existence):?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-remove"></i><?php endif; ?></center> </td>
                        <td style="width:90px;">
                        <a href="index.php?view=editproduct&product_id=<?php echo $cat->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a> 
                        <a href="index.php?action=delproduct&product_id=<?php echo $cat->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> 
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
