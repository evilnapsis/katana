<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          Tablas
        </h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="table-responsive">
        <?php
        $data = array(
          "header"=>array("","Nombre","Apellidos","Telefono",""),
          "body"=> array(
            array("","Agustin","Ramos","+5219141183199","<a href='./?view=item&id=1' class='btn btn-sm btn-primary'>Ver</a>"),
            array("","Agustin","Ramos","+5219141183199","<a href='./?view=item&id=1' class='btn btn-sm btn-primary'>Ver</a>"),
            array("","Agustin","Ramos","+5219141183199","<a href='./?view=item&id=1' class='btn btn-sm btn-primary'>Ver</a>")
            )
          );
        echo Table::render($data);
        ?>
      </div>
    </div>
  </div>
</div>