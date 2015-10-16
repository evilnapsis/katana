        <!-- Main Content -->

          <div class="row">
            <div class="col-md-12">
  <!-- Button trigger modal -->


            <h2>AGREGAR SLIDE</h2>
            </div>
            </div>

          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <i class="fa fa-th-large"></i> Nuevo Slide
                </div>
                <div class="panel-body ">

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="index.php?action=addslide">
  <div class="form-group">
    

    <label for="inputEmail1" class="col-lg-2 control-label">Titulo</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" name="title" placeholder="Titulo del slide">
    </div>
    
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Imagen</label>
    <div class="col-lg-10">
      <input type="file" name="image">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-3">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="is_public"> Es Visible
        </label>
      </div>
    </div>
  </div>



  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-6">
      <button type="submit" class="btn btn-primary btn-block">Agregar Slide</button>
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