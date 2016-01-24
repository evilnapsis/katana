<?php 
$coin = ConfigurationData::getByPreffix("general_coin")->val;
?>
        <!-- Main Content -->

          <div class="row">
            <div class="col-md-12">
  <!-- Button trigger modal -->


            <h2>NUEVO PRODUCTO</h2>
            </div>
            </div>

          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-star"></i> Nuevo Producto
                </div>
                <div class="panel-body ">

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="index.php?action=addproduct">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Codigo</label>
    <div class="col-lg-2">
      <input type="text" class="form-control" name="code" placeholder="Codigo">
    </div>

    <label for="inputEmail1" class="col-lg-2 control-label">Nombre</label>
    <div class="col-lg-6">
      <input type="text" class="form-control" name="name" placeholder="Nombre del producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword1" class="col-lg-2 control-label">Descripcion</label>
    <div class="col-lg-10">
      <textarea class="form-control" id="inputPassword1" placeholder="Descripcion" rows="6" name="description"></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Precio</label>
    <div class="col-lg-10">
      <div class="input-group">
  <span class="input-group-addon"><?php echo $coin; ?></span>
  <input type="text" class="form-control" placeholder="Precio" required name="price">
</div>    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Imagen</label>
    <div class="col-lg-10">
      <input type="file" name="image">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-2">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="is_public"> Es Visible
        </label>
      </div>
    </div>
    <div class="col-lg-2">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="in_existence"> En Existencia
        </label>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="is_featured"> Producto Destacado
        </label>
      </div>
    </div>

  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Unidad</label>
    <div class="col-lg-10">
<?php
$categories = UnitData::getAll();
 if(count($categories)>0):?>
<select name="unit_id" class="form-control" required>
<option value="">-- SELECCIONE UNIDAD --</option>

<?php foreach($categories as $cat):?>
<option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
<?php endforeach; ?>
</select>
 <?php endif; ?>

    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Categoria</label>
    <div class="col-lg-10">
<?php
$categories = CategoryData::getAll();
 if(count($categories)>0):?>
<select name="category_id" class="form-control" required>
<option value="">-- SELECCIONE CATEGORIA --</option>

<?php foreach($categories as $cat):?>
<option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
<?php endforeach; ?>
</select>
 <?php endif; ?>

    </div>
  </div>



  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-6">
      <button type="submit" class="btn btn-primary btn-block">Agregar Producto</button>
    </div>
    <div class="col-lg-4">
      <button type="reset" class="btn btn-default btn-block">Limpiar Campos</button>
    </div>
  </div>
</form>
                  
                </div>
              </div>
            </div>

          </div>

<br><br>