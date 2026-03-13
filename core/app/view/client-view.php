<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="login"):
?>
<div class="page-body">
  <div class="container-tight py-4">
    <div class="card card-md shadow-lg border-0">
      <div class="card-body">
        <h2 class="h1 text-center mb-4">Iniciar Sesión</h2>
        <form method="post" action="./?action=client&opt=login">
          <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" required name="email" class="form-control form-control-lg" placeholder="tu@email.com">
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" required name="password" class="form-control form-control-lg" placeholder="••••••••">
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100 btn-lg">Acceder <i class="bi bi-box-arrow-in-right ms-2"></i></button>
          </div>
        </form>
      </div>
      <div class="card-footer bg-light text-center py-3">
        ¿No tienes cuenta? <a href="./?view=client&opt=register" class="fw-bold">Regístrate aquí</a>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="register"):?>
<div class="page-body">
  <div class="container-tight py-4">
    <div class="card card-md shadow-lg border-0">
      <div class="card-body">
        <h2 class="h1 text-center mb-4">Crear Cuenta</h2>
        <form method="post" action="./?action=client&opt=add">
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label">Nombre</label>
              <input type="text" required name="name" class="form-control" placeholder="Nombre">
            </div>
            <div class="col-6">
              <label class="form-label">Apellidos</label>
              <input type="text" required name="lastname" class="form-control" placeholder="Apellidos">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" required name="email" class="form-control" placeholder="tu@email.com">
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" required name="password" class="form-control" placeholder="••••••••">
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100 btn-lg">Registrarse</button>
          </div>
        </form>
      </div>
      <div class="card-footer bg-light text-center py-3">
        ¿Ya tienes cuenta? <a href="./?view=client&opt=login" class="fw-bold">Inicia sesión</a>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="all"):
if(!isset($_SESSION["client_id"])){ Core::redir("./?view=client&opt=login"); }
$client = ClientData::getById($_SESSION["client_id"]);
$buys = BuyData::getAllByClientid($_SESSION["client_id"]);
$coin_symbol = ConfigurationData::getByPreffix("general_coin")?ConfigurationData::getByPreffix("general_coin")->val:"$";
?>
<div class="page-body">
  <div class="container-xl">
    <div class="row g-4">
      <div class="col-md-12">
        <div class="card shadow-sm mb-4 border-0">
          <div class="card-body bg-primary text-white rounded">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-xl bg-white text-primary rounded-circle me-3">
                <i class="bi bi-person h1 mb-0"></i>
              </div>
              <div>
                <h2 class="mb-0 h1 border-0">Bienvenido, <?php echo htmlspecialchars($client->name." ".$client->lastname); ?></h2>
                <p class="mb-0 opacity-75"><?php echo $client->email; ?></p>
              </div>
              <div class="ms-auto">
                <a href="./?action=client&opt=logout" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-left"></i> Cerrar Sesión</a>
              </div>
            </div>
          </div>
        </div>

        <h3 class="h2 mb-3"><i class="bi bi-bag-check me-2 text-success"></i> Mis Compras</h3>
        <?php if(count($buys)>0):?>
        <div class="card shadow-sm overflow-hidden">
          <div class="table-responsive">
            <table class="table table-vcenter card-table table-hover">
              <thead>
                <tr>
                  <th>Cod.</th>
                  <th>Total</th>
                  <th>Estado</th>
                  <th>Pago</th>
                  <th>Fecha</th>
                  <th class="w-1"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($buys as $buy):
                $status = $buy->getStatus();
                ?>
                <tr>
                  <td class="font-weight-bold text-muted">#<?php echo $buy->id; ?></td>
                  <td class="font-weight-bold h4"><?php echo $coin_symbol." ".number_format($buy->getTotal(),2); ?></td>
                  <td>
                    <span class="badge <?php echo $buy->status_id==1?'bg-warning-lt':'bg-success-lt'; ?>">
                      <?php echo $status->name; ?>
                    </span>
                  </td>
                  <td><?php echo $buy->getPaymethod()->name; ?></td>
                  <td class="text-muted"><?php echo $buy->created_at; ?></td>
                  <td>
                    <a href="./?view=cart&opt=details&id=<?php echo $buy->id; ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">Detalles</a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php else:?>
        <div class="card card-md border-dashed">
          <div class="card-body text-center py-5">
            <div class="mb-3 text-muted opacity-25">
              <i class="bi bi-clock-history" style="font-size: 3rem;"></i>
            </div>
            <h3>Aún no tienes compras</h3>
            <p class="text-muted">Cuando realices tu primera compra, aparecerá aquí.</p>
            <a href="./?view=products&opt=all" class="btn btn-primary mt-2">Ir a la Tienda</a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
