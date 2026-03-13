<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          Ejemplos de Formularios
        </h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Formulario 1</h3>
          </div>
          <div class="card-body">
            <form>
              <div class="mb-3">
                <label class="form-label">Email address</label>
                <?php echo Form::input("email","","","Email");?>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <?php echo Form::input("text","","","Password");?>
              </div>
              <div class="mb-3">
                <label class="form-label">File input</label>
                <?php echo Form::input2("file");?>
                <small class="form-hint">Example block-level help text here.</small>
              </div>
              <div class="mb-3">
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" checked="">
                  <span class="form-check-label">Check me out</span>
                </label>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Formulario 2</h3>
          </div>
          <div class="card-body">
            <form class="form-horizontal">
              <div class="mb-3 row">
                <label class="col-3 col-form-label required">Email</label>
                <div class="col">
                  <?php echo Form::input("email","","","Email");?>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-3 col-form-label required">Password</label>
                <div class="col">
                  <?php echo Form::input("text","","","Password");?>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-3 col-form-label"></label>
                <div class="col">
                  <label class="form-check">
                    <input class="form-check-input" type="checkbox">
                    <span class="form-check-label">Recuerdame</span>
                  </label>
                </div>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Select</h3>
          </div>
          <div class="card-body">
            <?php
            $data =  array(
              array("value"=>"","name"=>"-- SELECCIONE --"),
              array("value"=>"mxn","name"=>"Peso Mexicano"),
              array("value"=>"usd","name"=>"Dolar estadounidense"),
              array("value"=>"jpy","name"=>"Yen Japones")
              );
            echo Form::select("myselect",$data,"","required");
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>