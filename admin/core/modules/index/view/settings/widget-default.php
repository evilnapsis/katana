<?php
$settings = ConfigurationData::getAll();
$countries = CountryData::getAll();
//$coins = CoinData::getAll();

?>
        <!-- Main Content -->
          <div class="row">
            <div class="col-md-12">

            <h1>Ajustes Generales</h1>
            <a href="./?view=settings" class="btn btn-default">General</a>
            <a href="./?view=payment_settings" class="btn btn-default">Metodos de Pago</a>
            </div>
            </div>
<br>
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-wrench"></i> Ajustes Generales
                </div>
<form method="post" action="./?action=updatesettings">
                    <table class="table table-bordered">
                      <tbody>
<?php
 if(count($settings)>0):?>
<?php foreach($settings as $cat):?>
  <?php 
  if(substr($cat->name, 0,8)=="general_"):?>
                        <tr>
                        <td><?php echo $cat->label; ?>
                        </td>
                        <td>

                        <input type="text" name="<?php echo $cat->name; ?>" class="form-control" value="<?php echo $cat->val;?>">
                        </td>
                        </tr>
 <?php endif; ?>
<?php endforeach; ?>
 <?php endif; ?>

                        <tr>
                        <td>
                        </td>
                        <td>
                        <input type="submit"  class="btn btn-success" value="Actualizar Ajustes">
                        </td>
                        </tr>
                      </tbody>
                    </table>
                    </form>
              </div>
            </div>

          </div>
