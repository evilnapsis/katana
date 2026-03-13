<?php 
/***** VALIDATIONS AREA ******/
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
// si el id del usuario no existe.
if($user==null){ Core::redir("./");}
/**** GLOBAL VARIABLES AREA *****/
$main_title = "Personas";
$new_btn_text = "Nueva Persona";
?>
<?php if(isset($_GET["opt"]) && $_GET['opt']=="all"):
$contacts = PersonData::getAll();

TableTool::$table_header = array("Id", "Nombre", "Direccion", "Telefono", "");
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title"><?php echo $main_title; ?> (Version 2)</h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="./?view=personsmod&opt=new" class="btn btn-primary">
            <i class="bi bi-plus"></i> <?php echo $new_btn_text; ?>
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
    <?php if(count($contacts)>0):?>
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
          <?php TableTool::getHeader(); ?>
          <tbody>
          <?php foreach($contacts as $con):?>
            <tr>
              <td><a href="./?view=personsmod&opt=open&id=<?php echo $con->id; ?>" class="text-reset">#<?php echo $con->id; ?></a></td>
              <td><?php echo $con->name." ".$con->lastname; ?></td>
              <td class="text-muted"><?php echo $con->{'address'}; ?></td>
              <td class="text-muted"><?php echo $con->phone; ?></td>
              <td>
                <div class="btn-list flex-nowrap">
                  <a href="./?view=personsmod&opt=edit&id=<?php echo $con->id; ?>" class="btn btn-warning btn-sm"><i class="bi-pencil"></i></a>
                  <a href="./?action=personsmod&opt=del&id=<?php echo $con->id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
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
        <form method="post" action="./?action=personsmod&opt=add">
          <?php
          FormTool::addInput("text","name","Nombre","required");
          FormTool::addInput("text","lastname","Apellidos","required");
          FormTool::addInput("text","email","Email","required");
          FormTool::addInput("text","phone","Telefono","required");
          FormTool::addInput("text","address","Direccion","required");
          ?>
          <div class="form-footer mt-4">
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
        <form method="post" action="./?action=personsmod&opt=update">
          <input type="hidden" name="_id" value="<?php echo $contact->id; ?>">
          <?php
          FormTool::addInputVal("text","name",$contact->name,"Nombre","required");
          FormTool::addInputVal("text","lastname",$contact->lastname,"Apellidos","required");
          FormTool::addInputVal("text","email",$contact->email, "Email","required");
          FormTool::addInputVal("text","phone",$contact->phone,"Telefono","required");
          FormTool::addInputVal("text","address",$contact->address,"Direccion","required");
          ?>
          <div class="form-footer mt-4">
            <button type="submit" class="btn btn-success w-100">Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
