<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
if($user==null){ Core::redir("./");}
?>
<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<?php $settings = ConfigurationData::getAll(); ?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Ajustes Generales</h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="./?view=settings&opt=payment" class="btn btn-default">Metodos de Pago</a>
          <a href="./?view=settings&opt=password" class="btn btn-default">Cambiar Contraseña</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-primary"></div>
      <form method="post" action="./?action=settings&opt=update">
        <div class="table-responsive">
          <table class="table card-table table-vcenter">
            <thead>
              <tr>
                <th>Parametro</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody>
            <?php if(count($settings)>0):?>
            <?php foreach($settings as $cat):?>
              <?php if(substr($cat->name, 0,8)=="general_"):?>
              <tr>
                <td class="w-50"><?php echo $cat->label; ?></td>
                <td>
                  <input type="text" name="<?php echo $cat->name; ?>" class="form-control" value="<?php echo htmlspecialchars($cat->val);?>">
                </td>
              </tr>
              <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-end">
          <button type="submit" class="btn btn-success">Actualizar Ajustes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="payment"):?>
<?php 
$paymethods = PaymethodData::getAll(); 
$settings = ConfigurationData::getAll();
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Metodos de Pago</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card mb-3">
      <div class="card-status-top bg-primary"></div>
      <div class="card-header">
        <h3 class="card-title">Metodos de Pago</h3>
      </div>
      <div class="table-responsive">
        <table class="table card-table table-vcenter">
          <tbody>
          <?php foreach($paymethods as $pay):?>
            <tr>
              <td><?php echo $pay->name;?></td>
              <td class="text-end">
                <a href="./?action=settings&opt=switchpm&id=<?php echo $pay->id; ?>" class="btn btn-sm <?php echo $pay->is_active?'btn-warning':'btn-primary'; ?>">
                  <?php echo $pay->is_active?'Desactivar':'Activar'; ?>
                </a>
              </td>
            </tr>
          <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>

    <?php if(PaymethodData::getByName("bank") && PaymethodData::getByName("bank")->is_active):?>
    <div class="card">
      <div class="card-status-top bg-info"></div>
      <div class="card-header">
        <h3 class="card-title">Deposito Bancario</h3>
      </div>
      <form method="post" action="./?action=settings&opt=updatepm">
        <div class="table-responsive">
          <table class="table card-table table-vcenter">
            <tbody>
            <?php foreach($settings as $cat):?>
              <?php if(substr($cat->name, 0,5)=="bank_"):?>
              <tr>
                <td class="w-50"><?php echo $cat->label; ?></td>
                <td>
                  <input type="text" name="<?php echo $cat->name; ?>" class="form-control" value="<?php echo htmlspecialchars($cat->val);?>">
                </td>
              </tr>
              <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-end">
          <button type="submit" class="btn btn-success">Actualizar Datos</button>
        </div>
      </form>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="password"):?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Cambiar Contraseña</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-info"></div>
      <div class="card-body">
        <form method="post" action="./?action=settings&opt=changepass">
          <div class="mb-3">
            <label class="form-label">Contraseña Actual</label>
            <input type="password" name="password" class="form-control" required placeholder="Contraseña Actual">
          </div>
          <div class="mb-3">
            <label class="form-label">Nueva Contraseña</label>
            <input type="password" name="newpassword" class="form-control" required placeholder="Nueva Contraseña">
          </div>
          <div class="mb-3">
            <label class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" name="confirmnewpassword" class="form-control" required placeholder="Confirmar Nueva Contraseña">
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-success w-100">Cambiar Contraseña</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>