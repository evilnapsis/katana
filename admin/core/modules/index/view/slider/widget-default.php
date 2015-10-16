        <!-- Main Content -->

          <div class="row">
            <div class="col-md-12">
                  <a  href="index.php?view=newslide" class="pull-right btn-sm btn btn-default">Agregar Slide</a>
  <!-- Button trigger modal -->


            <h2>SLIDER</h2>
            </div>
            </div>

          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-th-list"></i> Slides
                </div>
                <div class="widget-body medium no-padding">

                  <div class="table-responsive">
<?php
$categories = SlideData::getAll();
 if(count($categories)>0):?>
                    <table class="table table-bordered">
                      <tbody>
<thead>
  <th>Nombre</th>
  <th>Visible</th>
  <th></th>
</thead>
<?php foreach($categories as $cat):?>
                        <tr>
                        <td><?php echo $cat->title; ?></td>
                        <td style="width:90px;"><center><?php if($cat->is_public):?><i class="fa fa-check"></i><?php else: ?><i class="fa fa-remove"></i><?php endif; ?></center> </td>
                        <td style="width:90px;">
                        <a href="index.php?view=editslide&slide_id=<?php echo $cat->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a> 
                        <a href="index.php?action=delslide&slide_id=<?php echo $cat->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> 
                        </td>
                        </tr>
<?php endforeach; ?>
                      </tbody>
                    </table>
                  <?php else: ?>
                    <div class="panel-body">
                    <h1>No hay slides</h1>
                    </div>
 <?php endif; ?>

                  </div>
                </div>
              </div>
            </div>

          </div>
