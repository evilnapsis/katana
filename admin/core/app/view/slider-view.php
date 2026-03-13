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
        <h2 class="page-title">Slider</h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="./?view=slider&opt=new" class="btn btn-primary">
            <i class="bi bi-plus"></i> Agregar Slide
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
        <h3 class="card-title">Slides</h3>
      </div>
      <div class="card-body">
    <?php
    $slides = SlideData::getAll();
    if(count($slides)>0):?>
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Visible</th>
              <th class="w-1"></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($slides as $cat):?>
            <tr>
              <td><?php echo $cat->title; ?></td>
              <td>
                <?php if($cat->is_public):?><i class="bi bi-check-lg text-success"></i><?php else: ?><i class="bi bi-x-lg text-danger"></i><?php endif; ?>
              </td>
              <td>
                <div class="btn-list flex-nowrap">
                  <a href="./?view=slider&opt=edit&id=<?php echo $cat->id; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a> 
                  <a href="./?action=slider&opt=del&id=<?php echo $cat->id; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a> 
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        </div>
    <?php else:?>
        <p class="alert alert-warning mb-0">No hay slides, puedes empezar agregando uno.</p>
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
        <h2 class="page-title">Agregar Slide</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-success"></div>
      <div class="card-header">
        <h3 class="card-title">Nuevo Slide</h3>
      </div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data" action="./?action=slider&opt=add">
          <div class="mb-3">
            <label class="form-label">Titulo</label>
            <input type="text" class="form-control" name="title" required placeholder="Titulo del slide">
          </div>
          <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" class="form-control" name="image" required>
          </div>
          <div class="mb-3">
            <label class="form-check">
              <input class="form-check-input" type="checkbox" name="is_public">
              <span class="form-check-label">Es Visible</span>
            </label>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Agregar Slide</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<?php 
$product = SlideData::getById($_GET["id"]);
$url = "storage/slides/$product->image";
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Editar Slide: <?php echo $product->title; ?></h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-info"></div>
      <div class="card-header">
        <h3 class="card-title">Editar Slide</h3>
      </div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data" action="./?action=slider&opt=upd">
          <input type="hidden" name="id" value="<?php echo $product->id;?>">
          <div class="mb-3">
            <label class="form-label">Titulo</label>
            <input type="text" class="form-control" name="title" value="<?php echo $product->title; ?>" required placeholder="Titulo">
          </div>
          <?php if( $product->image!="" && file_exists($url)):?>
          <div class="mb-3">
            <img src="<?php echo $url; ?>" class="img-fluid rounded border" style="max-height: 200px;">
          </div>
          <?php endif; ?>
          <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" class="form-control" name="image">
          </div>
          <div class="mb-3">
            <label class="form-check">
              <input class="form-check-input" type="checkbox" name="is_public" <?php if($product->is_public){ echo "checked";} ?>>
              <span class="form-check-label">Es Visible</span>
            </label>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-success w-100">Actualizar Slide</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
