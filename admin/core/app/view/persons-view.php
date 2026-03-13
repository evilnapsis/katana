<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
if($user==null){ Core::redir("./");}
?>
<?php if(isset($_GET["opt"]) && $_GET['opt']=="all"):
$contacts = PersonData::getAll();
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Contactos</h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="./?view=persons&opt=new" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nuevo Contacto
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
        <h3 class="card-title">Contactos</h3>
      </div>
      <div class="card-body">
    <?php if(count($contacts)>0):?>
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nombre</th>
              <th>Direccion</th>
              <th>Telefono</th>
              <th class="w-1"></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($contacts as $con):?>
            <tr>
              <td><a href="./?view=persons&opt=open&id=<?php echo $con->id; ?>" class="text-reset">#<?php echo $con->id; ?></a></td>
              <td><?php echo $con->name." ".$con->lastname; ?></td>
              <td class="text-muted"><?php echo $con->address; ?></td>
              <td class="text-muted"><?php echo $con->phone; ?></td>
              <td>
                <div class="btn-list flex-nowrap">
                  <a href="./?view=persons&opt=edit&id=<?php echo $con->id; ?>" class="btn btn-warning btn-sm"><i class="bi-pencil"></i></a>
                  <a href="./?action=persons&opt=del&id=<?php echo $con->id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        </div>
      </div>
    <?php else:?>
      <div class="card-body">
        <p class="alert alert-warning mb-0">No hay contactos</p>
      </div>
    <?php endif; ?>
    </div>
  </div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Nuevo Contacto</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-success"></div>
      <div class="card-header">
        <h3 class="card-title">Nuevo Contacto</h3>
      </div>
      <div class="card-body">
        <form method="post" action="./?action=persons&opt=add">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" required name="name" class="form-control" placeholder="Nombre">
          </div>
          <div class="mb-3">
            <label class="form-label">Apellidos</label>
            <input type="text" required name="lastname" class="form-control" placeholder="Apellidos">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" required name="email" class="form-control" placeholder="Email">
          </div>
          <div class="mb-3">
            <label class="form-label">Telefono</label>
            <input type="text" required name="phone" class="form-control" placeholder="Telefono">
          </div>
          <div class="mb-3">
            <label class="form-label">Direccion</label>
            <input type="text" required name="address" class="form-control" placeholder="Direccion">
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
$contact = PersonData::getById($_GET["id"]);
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Editar Contacto</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-info"></div>
      <div class="card-header">
        <h3 class="card-title">Editar Contacto</h3>
      </div>
      <div class="card-body">
        <form method="post" action="./?action=persons&opt=update">
          <input type="hidden" name="_id" value="<?php echo $contact->id; ?>">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" required name="name" value="<?php echo htmlspecialchars($contact->name); ?>" class="form-control" placeholder="Nombre">
          </div>
          <div class="mb-3">
            <label class="form-label">Apellidos</label>
            <input type="text" required name="lastname" value="<?php echo htmlspecialchars($contact->lastname); ?>" class="form-control" placeholder="Apellidos">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" required name="email" value="<?php echo htmlspecialchars($contact->email); ?>" class="form-control" placeholder="Email">
          </div>
          <div class="mb-3">
            <label class="form-label">Telefono</label>
            <input type="text" required name="phone" value="<?php echo htmlspecialchars($contact->phone); ?>" class="form-control" placeholder="Telefono">
          </div>
          <div class="mb-3">
            <label class="form-label">Direccion</label>
            <input type="text" required name="address" value="<?php echo htmlspecialchars($contact->address); ?>" class="form-control" placeholder="Direccion">
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-success w-100">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
