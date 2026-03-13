<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
if($user==null){ Core::redir("./");}
?>
<?php if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Clientes</h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="./?view=clients&opt=new" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nuevo Cliente
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-primary"></div>
      <div class="card-header">
        <h3 class="card-title">Clientes</h3>
      </div>
      <div class="card-body">
    <?php
    $clients = ClientData::getAll();
    if(count($clients)>0):?>
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Email</th>
              <th class="w-1"></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($clients as $cat):?>
            <tr>
              <td><?php echo $cat->getFullname(); ?></td>
              <td><?php echo $cat->email; ?></td>
              <td>
                <div class="btn-list flex-nowrap">
                  <a href="./?view=clients&opt=edit&id=<?php echo $cat->id; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a> 
                  <a href="./?action=clients&opt=del&id=<?php echo $cat->id; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a> 
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        </div>
    <?php else:?>
        <p class="alert alert-warning mb-0">No hay clientes por mostrar, agregar uno o espera a que se registren.</p>
    <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Nuevo Cliente</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-success"></div>
      <div class="card-body">
        <form method="post" action="./?action=clients&opt=add">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" class="form-control" name="name" required placeholder="Nombre">
            </div>
            <div class="col-md-6">
              <label class="form-label">Apellido</label>
              <input type="text" class="form-control" name="lastname" required placeholder="Apellido">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Direccion</label>
            <input type="text" class="form-control" name="address" placeholder="Direccion">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required placeholder="Email">
          </div>
          <div class="mb-3">
            <label class="form-label">Telefono</label>
            <input type="text" class="form-control" name="phone" placeholder="Telefono">
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password" required placeholder="Contraseña">
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Agregar Cliente</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<?php 
$cat = ClientData::getById($_GET["id"]);
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Editar Cliente: <?php echo $cat->getFullname(); ?></h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-info"></div>
      <div class="card-body">
        <form method="post" action="./?action=clients&opt=upd">
          <input type="hidden" name="id" value="<?php echo $cat->id;?>">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" class="form-control" name="name" value="<?php echo $cat->name; ?>" required placeholder="Nombre">
            </div>
            <div class="col-md-6">
              <label class="form-label">Apellido</label>
              <input type="text" class="form-control" name="lastname" value="<?php echo $cat->lastname; ?>" required placeholder="Apellido">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Direccion</label>
            <input type="text" class="form-control" name="address" value="<?php echo $cat->address; ?>" placeholder="Direccion">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $cat->email; ?>" required placeholder="Email">
          </div>
          <div class="mb-3">
            <label class="form-label">Telefono</label>
            <input type="text" class="form-control" name="phone" value="<?php echo $cat->phone; ?>" placeholder="Telefono">
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-success w-100">Actualizar Cliente</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
