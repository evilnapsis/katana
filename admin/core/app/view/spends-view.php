<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
if($user==null){ Core::redir("./");}

if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Lista de Gastos</h2>
      </div>
      <div class="">
        <div class="btn-list">
          <a href="./?view=spends&opt=new" class="btn btn-primary">
            <i class='bi bi-plus'></i> Nuevo Gasto
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
        <h3 class="card-title"><i class="bi bi-wallet"></i> Gastos</h3>
      </div>
      <div class="card-body">
    <?php
    $spends = SpendData::getAll();
    if(count($spends)>0){
    ?>
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
          <thead>
            <tr>
              <th>Concepto</th>
              <th>Monto</th>
              <th>Categoria</th>
              <th>Usuario</th>
              <th>Fecha</th>
              <th class="w-1"></th>
            </tr>
          </thead>
          <tbody>
          <?php
          foreach($spends as $spend):
            $cat = $spend->getCategory();
            $user_s = $spend->getUser();
          ?>
            <tr>
              <td><?php echo htmlspecialchars($spend->name); ?></td>
              <td>$ <?php echo number_format($spend->amount,2,".",","); ?></td>
              <td><?php echo htmlspecialchars($cat!=null ? $cat->name : "---"); ?></td>
              <td><?php echo htmlspecialchars($user_s!=null ? $user_s->name." ".$user_s->lastname : "---"); ?></td>
              <td><?php echo $spend->date_at; ?></td>
              <td>
                <div class="btn-list flex-nowrap">
                  <a href="./?view=spends&opt=edit&id=<?php echo $spend->id;?>" class="btn btn-warning btn-sm"><i class="bi-pencil"></i></a>
                  <a href="./?action=spends&opt=del&id=<?php echo $spend->id;?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
          </div>
    <?php }else{ ?>
        <p class="alert alert-warning mb-0">No hay gastos.</p>
    <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Agregar Gasto</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-success"></div>
      <div class="card-header">
        <h3 class="card-title">Nuevo Gasto</h3>
      </div>
      <div class="card-body">
        <form method="post" action="./?action=spends&opt=add">
          <div class="mb-3">
            <label class="form-label">Concepto*</label>
            <input type="text" name="name" class="form-control" required placeholder="Concepto del gasto">
          </div>
          <div class="mb-3">
            <label class="form-label">Monto*</label>
            <input type="number" step="any" name="amount" class="form-control" required placeholder="Monto">
          </div>
          <div class="mb-3">
            <label class="form-label">Categoria*</label>
            <select name="category_id" class="form-control" required>
              <option value="">-- SELECCIONE CATEGORIA --</option>
              <?php foreach(CategoryData::getAll() as $c):?>
              <option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Fecha*</label>
            <input type="date" name="date_at" class="form-control" required>
          </div>
          <div class="form-footer mt-4">
            <button type="submit" class="btn btn-primary w-100">Agregar Gasto</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<?php $spend = SpendData::getById($_GET["id"]);?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Editar Gasto</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-info"></div>
      <div class="card-header">
        <h3 class="card-title">Editar Gasto</h3>
      </div>
      <div class="card-body">
        <form method="post" action="./?action=spends&opt=upd">
          <div class="mb-3">
            <label class="form-label">Concepto*</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($spend->name);?>" class="form-control" required placeholder="Concepto del gasto">
          </div>
          <div class="mb-3">
            <label class="form-label">Monto*</label>
            <input type="number" step="any" name="amount" value="<?php echo htmlspecialchars($spend->amount);?>" class="form-control" required placeholder="Monto">
          </div>
          <div class="mb-3">
            <label class="form-label">Categoria*</label>
            <select name="category_id" class="form-control" required>
              <option value="">-- SELECCIONE CATEGORIA --</option>
              <?php foreach(CategoryData::getAll() as $c):?>
              <option value="<?php echo $c->id; ?>" <?php if($spend->category_id==$c->id){ echo "selected";}?>><?php echo $c->name; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Fecha*</label>
            <input type="date" name="date_at" value="<?php echo htmlspecialchars($spend->date_at);?>" class="form-control" required>
          </div>
          <div class="form-footer mt-4">
            <input type="hidden" name="spend_id" value="<?php echo $spend->id;?>">
            <button type="submit" class="btn btn-success w-100">Actualizar Gasto</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
