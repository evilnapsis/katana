<?php
$settings = ConfigurationData::getAll();
$paymethods = PaymethodData::getAll();

?>
        <!-- Main Content -->
          <div class="row">
            <div class="col-md-12">

            <h1>Metodos de Pago</h1>
            <a href="./?view=settings" class="btn btn-default">General</a>
            <a href="./?view=payment_settings" class="btn btn-default">Metodos de Pago</a>
            </div>
            </div>
<br>
          <div class="row">
            <div class="col-md-12">

              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-usd"></i> Metodos de Pago
                </div>
                    <table class="table table-bordered">
                      <tbody>
                      <?php foreach($paymethods as $pay):?>
                        <tr>
                        <td><?php echo $pay->name;?>
                        </td>
                        <td style="width:60px;">
                        <?php if($pay->is_active):?>
                          <a href="./?action=switchpm&id=<?php echo $pay->id; ?>" class="btn btn-xs btn-warning">Desactivar</a>
                        <?php else:?>
                          <a href="./?action=switchpm&id=<?php echo $pay->id; ?>" class="btn btn-xs btn-primary">Activar</a>
                        <?php endif;?>
                        </td>
                        </tr>
                      <?php endforeach;?>
                        </tbody>
                        </table>
                        </div>
<?php if(PaymethodData::getByName("paypal")->is_active):?>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-paypal"></i> Paypal
                </div>
<form method="post" action="./?action=updatepmsettings">
                    <table class="table table-bordered">
                      <tbody>
                        <?php
 if(count($settings)>0):?>
<?php foreach($settings as $cat):?>
  <?php 
  if(substr($cat->name, 0,7)=="paypal_"):?>
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
                        <input type="submit"  class="btn btn-success" value="Actualizar Datos PayPal">
                        </td>
                        </tr>
                      </tbody>
                    </table>
                    </form>
              </div>
            <?php endif; ?>
<?php if(PaymethodData::getByName("bank")->is_active):?>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-bank"></i> Deposito Bancario
                </div>
<form method="post" action="./?action=updatepmsettings">
                    <table class="table table-bordered">
                      <tbody>
                      <?php
 if(count($settings)>0):?>
<?php foreach($settings as $cat):?>
  <?php 
  if(substr($cat->name, 0,5)=="bank_"):?>
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
                        <input type="submit"  class="btn btn-success" value="Actualizar Datos PayPal">
                        </td>
                        </tr>
                      </tbody>
                    </table>
                    </form>
              </div>
            <?php endif; ?>

            </div>

          </div>
