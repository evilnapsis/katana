<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
// si el id del usuario no existe.
if($user==null){ Core::redir("./");}

if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Lista de Usuarios</h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="./?view=users&opt=new" class="btn btn-primary">
            <i class='bi bi-person-plus'></i> Nuevo
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
        <h3 class="card-title">Usuarios</h3>
      </div>
      <div class="card-body">
    <?php
    $users = UserData::getAll();
    if(count($users)>0){
    ?>
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
          <thead>
            <tr>
              <th>Nombre completo</th>
              <th>Email</th>
              <th>Tipo</th>
              <th class="w-1"></th>
            </tr>
          </thead>
          <tbody>
          <?php
          foreach($users as $user):
          ?>
            <tr>
              <td><?php echo $user->name." ".$user->lastname; ?></td>
              <td class="text-muted"><?php echo $user->email; ?></td>
              <td class="text-muted">
                <?php 
                if($user->kind==1){ echo "Administrador"; }
                else if($user->kind==2){ echo "Usuario normal"; }
                ?>
              </td>
              <td>
                <div class="btn-list flex-nowrap">
                  <a href="./?view=users&opt=edit&id=<?php echo $user->id;?>" class="btn btn-warning btn-sm"><i class="bi-pencil"></i></a>
                  <a href="./?action=users&opt=del&id=<?php echo $user->id;?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
          </div>
      </div>
    <?php }else{ ?>
      <div class="card-body">
        <p class="alert alert-warning mb-0">No hay usuarios.</p>
      </div>
    <?php } ?>
    </div>
  </div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Agregar Usuario</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-success"></div>
      <div class="card-header">
        <h3 class="card-title">Agregar Usuario</h3>
      </div>
      <div class="card-body">
        <form method="post" action="./?action=users&opt=add">
          <div class="mb-3">
            <label class="form-label">Nombre*</label>
            <input type="text" name="name" class="form-control" required placeholder="Nombre">
          </div>
          <div class="mb-3">
            <label class="form-label">Apellido*</label>
            <input type="text" name="lastname" required class="form-control" placeholder="Apellido">
          </div>
          <div class="mb-3">
            <label class="form-label">Email*</label>
            <input type="email" name="email" required class="form-control" placeholder="Email">
          </div>
          <div class="mb-3">
            <label class="form-label">Nombre de Usuario*</label>
            <input type="text" name="username" required class="form-control" placeholder="Nombre de Usuario">
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" placeholder="Contraseña">
          </div>
          <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="kind" class="form-control" required>
              <option value="2">Usuario normal</option>
              <option value="1">Administrador</option>
            </select>
          </div>
          <div class="form-footer mt-4">
            <button type="submit" class="btn btn-primary w-100">Agregar Usuario</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<?php $user = UserData::getById($_GET["id"]);?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Editar Usuario</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-info"></div>
      <div class="card-header">
        <h3 class="card-title">Editar Usuario</h3>
      </div>
      <div class="card-body">
        <form method="post" action="./?action=users&opt=upd">
          <div class="mb-3">
            <label class="form-label">Nombre*</label>
            <input type="text" name="name" value="<?php echo $user->name;?>" class="form-control" required placeholder="Nombre">
          </div>
          <div class="mb-3">
            <label class="form-label">Apellido*</label>
            <input type="text" name="lastname" value="<?php echo $user->lastname;?>" required class="form-control" placeholder="Apellido">
          </div>
          <div class="mb-3">
            <label class="form-label">Email*</label>
            <input type="email" name="email" value="<?php echo $user->email;?>" required class="form-control" placeholder="Email">
          </div>
          <div class="mb-3">
            <label class="form-label">Nombre de Usuario*</label>
            <input type="text" name="username" value="<?php echo $user->username;?>" required class="form-control" placeholder="Nombre de Usuario">
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" placeholder="Contraseña">
            <small class="form-hint">La contraseña solo se modificara si escribes algo, en caso contrario no se modifica.</small>
          </div>
          <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="kind" class="form-control" required>
              <option value="2" <?php if($user->kind==2){ echo "selected"; } ?>>Usuario normal</option>
              <option value="1" <?php if($user->kind==1){ echo "selected"; } ?>>Administrador</option>
            </select>
          </div>
          <div class="form-footer mt-4">
            <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
            <button type="submit" class="btn btn-success w-100">Actualizar Usuario</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>