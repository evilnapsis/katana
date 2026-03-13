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
        <h2 class="page-title">Productos</h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="./?view=products&opt=new" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nuevo Producto
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
        <h3 class="card-title">Productos</h3>
      </div>
      <div class="card-body">
    <?php
    $products = ProductData::getAll();
    if(count($products)>0):?>
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Visible</th>
              <th>Destacado</th>
              <th>Existencia</th>
              <th>Oferta</th>
              <th class="w-1"></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($products as $cat):?>
            <tr>
              <td><?php echo $cat->name; ?></td>
              <td>
                <?php if($cat->is_public):?><i class="bi bi-check-lg text-success"></i><?php else: ?><i class="bi bi-x-lg text-danger"></i><?php endif; ?>
              </td>
              <td>
                <?php if($cat->is_featured):?><i class="bi bi-check-lg text-success"></i><?php else: ?><i class="bi bi-x-lg text-danger"></i><?php endif; ?>
              </td>
              <td>
                <?php if($cat->in_existence):?><i class="bi bi-check-lg text-success"></i><?php else: ?><i class="bi bi-x-lg text-danger"></i><?php endif; ?>
              </td>
              <td>
                <?php if($cat->is_offert):?><i class="bi bi-check-lg text-success"></i><?php else: ?><i class="bi bi-x-lg text-danger"></i><?php endif; ?>
              </td>
              <td>
                <div class="btn-list flex-nowrap">
                  <a href="../index.php?view=products&opt=open&id=<?php echo $cat->id; ?>" target="_blank" class="btn btn-default btn-sm"><i class="bi bi-link-45deg"></i></a> 
                  <a href="./?view=products&opt=edit&id=<?php echo $cat->id; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a> 
                  <a href="./?action=products&opt=del&id=<?php echo $cat->id; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a> 
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        </div>
    <?php else:?>
        <p class="alert alert-warning mb-0">No hay productos, puedes empezar agregando tu lista de productos.</p>
    <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<?php $coin = ConfigurationData::getByPreffix("general_coin")->val; ?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Nuevo Producto</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-success"></div>
      <div class="card-header">
        <h3 class="card-title">Nuevo Producto</h3>
      </div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data" action="./?action=products&opt=add">
          <div class="row row-cards">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Codigo</label>
                <input type="text" class="form-control" name="code" placeholder="Codigo">
              </div>
            </div>
            <div class="col-md-8">
              <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="name" required placeholder="Nombre del producto">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Descripcion</label>
            <textarea class="form-control" placeholder="Descripcion" rows="4" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Precio</label>
            <div class="input-group">
              <span class="input-group-text"><?php echo $coin; ?></span>
              <input type="text" class="form-control" placeholder="Precio" required name="price">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" class="form-control" name="image">
          </div>
          <div class="mb-3">
            <div class="form-label">Opciones</div>
            <div class="d-flex gap-3">
              <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="is_public">
                <span class="form-check-label">Es Visible</span>
              </label>
              <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="in_existence">
                <span class="form-check-label">En Existencia</span>
              </label>
              <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="is_featured">
                <span class="form-check-label">Producto Destacado</span>
              </label>
              <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="is_offert">
                <span class="form-check-label">Producto en Oferta</span>
              </label>
            </div>
          </div>
          <div class="row row-cards">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Unidad</label>
                <?php $units = UnitData::getAll(); ?>
                <select name="unit_id" class="form-select" required>
                  <option value="">-- SELECCIONE UNIDAD --</option>
                  <?php foreach($units as $cat):?>
                  <option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Categoria</label>
                <?php $categories = CategoryData::getAll(); ?>
                <select name="category_id" class="form-select" required>
                  <option value="">-- SELECCIONE CATEGORIA --</option>
                  <?php foreach($categories as $cat):?>
                  <option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Agregar Producto</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<?php 
$product = ProductData::getById($_GET["id"]);
$url = "storage/products/$product->image";
$coin = ConfigurationData::getByPreffix("general_coin")->val; 
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Editar Producto: <?php echo $product->name; ?></h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-status-top bg-info"></div>
      <div class="card-header">
        <h3 class="card-title">Editar Producto</h3>
      </div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data" action="./?action=products&opt=upd">
          <input type="hidden" name="id" value="<?php echo $product->id;?>">
          <div class="row row-cards">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Codigo</label>
                <input type="text" class="form-control" name="code" value="<?php echo $product->code; ?>" placeholder="Codigo">
              </div>
            </div>
            <div class="col-md-8">
              <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="name" value="<?php echo $product->name; ?>" required placeholder="Nombre del producto">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Descripcion</label>
            <textarea class="form-control" placeholder="Descripcion" rows="4" name="description"><?php echo $product->description; ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Precio</label>
            <div class="input-group">
              <span class="input-group-text"><?php echo $coin; ?></span>
              <input type="text" class="form-control" placeholder="Precio" value="<?php echo $product->price; ?>" required name="price">
            </div>
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
            <div class="form-label">Opciones</div>
            <div class="d-flex gap-3">
              <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="is_public" <?php if($product->is_public){ echo "checked";} ?>>
                <span class="form-check-label">Es Visible</span>
              </label>
              <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="in_existence" <?php if($product->in_existence){ echo "checked";} ?>>
                <span class="form-check-label">En Existencia</span>
              </label>
              <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="is_featured" <?php if($product->is_featured){ echo "checked";} ?>>
                <span class="form-check-label">Producto Destacado</span>
              </label>
              <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="is_offert" <?php if($product->is_offert){ echo "checked";} ?>>
                <span class="form-check-label">Producto en Oferta</span>
              </label>
            </div>
          </div>
          <div class="row row-cards">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Unidad</label>
                <?php $units = UnitData::getAll(); ?>
                <select name="unit_id" class="form-select" required>
                  <option value="">-- SELECCIONE UNIDAD --</option>
                  <?php foreach($units as $cat):?>
                  <option value="<?php echo $cat->id; ?>" <?php if($product->unit_id==$cat->id){ echo "selected";} ?>><?php echo $cat->name; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Categoria</label>
                <?php $categories = CategoryData::getAll(); ?>
                <select name="category_id" class="form-select" required>
                  <option value="">-- SELECCIONE CATEGORIA --</option>
                  <?php foreach($categories as $cat):?>
                  <option value="<?php echo $cat->id; ?>" <?php if($product->category_id==$cat->id){ echo "selected";} ?>><?php echo $cat->name; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-success w-100">Actualizar Producto</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
