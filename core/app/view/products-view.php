<?php 
$coin_symbol = ConfigurationData::getByPreffix("general_coin")?ConfigurationData::getByPreffix("general_coin")->val:"$";
$img_default = ConfigurationData::getByPreffix("general_img_default")?ConfigurationData::getByPreffix("general_img_default")->val:"assets/img/default.png";

if(isset($_GET["opt"]) && $_GET["opt"]=="all"):
  $products = [];
  $title = "Productos";
  if(isset($_GET["cat"])){
    $cat = CategoryData::getByPreffix($_GET["cat"]);
    if($cat){
      $products = ProductData::getPublicsByCategoryId($cat->id);
      $title = "Categoría: ".$cat->name;
    }
  }else if(isset($_GET["q"])){
    $products = ProductData::getLike($_GET["q"]);
    $title = "Búsqueda: ".$_GET["q"];
  }else if(isset($_GET["filter"])){
    if($_GET["filter"]=="news") { $products = ProductData::getNews(); $title = "Novedades"; }
    else if($_GET["filter"]=="offers") { $products = ProductData::getOffers(); $title = "Ofertas"; }
  }else{
    $products = ProductData::getAll(); // O getPublics si existe
  }
?>
<div class="page-body">
  <div class="container-xl">
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card shadow-sm mb-3">
          <div class="card-header"><h3 class="card-title">Categorías</h3></div>
          <div class="list-group list-group-flush">
            <?php foreach(CategoryData::getPublics() as $cat): ?>
            <a href="./?view=products&opt=all&cat=<?php echo $cat->short_name; ?>" class="list-group-item list-group-item-action d-flex align-items-center">
              <i class="bi bi-chevron-right me-2 small"></i> <?php echo htmlspecialchars($cat->name); ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <h2 class="h1 mb-3"><?php echo $title; ?></h2>
        <?php if(count($products)>0):?>
        <div class="row row-cards">
          <?php foreach($products as $p):
          $img = "admin/storage/products/".$p->image;
          if($p->image=="" || !file_exists($img)){ $img=$img_default; }
          $in_cart=false;
          if(isset($_SESSION["cart"])){
            foreach ($_SESSION["cart"] as $pc) {
              if($pc["product_id"]==$p->id){ $in_cart=true;  }
            }
          }
          ?>
          <div class="col-sm-6 col-lg-4">
            <div class="card card-stacked shadow-sm h-100">
              <div class="card-body p-3 text-center">
                <a href="./?view=products&opt=open&id=<?php echo $p->id; ?>">
                  <img src="<?php echo $img; ?>" class="img-fluid rounded mb-3" style="height: 150px; object-fit: contain;">
                </a>
                <h3 class="card-title mb-1"><?php echo htmlspecialchars($p->name); ?></h3>
                <div class="text-primary h2 font-weight-bold mb-3"><?php echo $coin_symbol." ".number_format($p->price,2,".",","); ?></div>
                <div class="d-grid gap-2">
                  <?php if(!$p->in_existence):?>
                    <button class="btn btn-warning disabled">No Disponible</button>
                  <?php elseif(!$in_cart):?>
                    <a href="./?action=cart&opt=add&product_id=<?php echo $p->id; ?>&href=cat" class="btn btn-primary">Comprar</a>
                  <?php else:?>
                    <button class="btn btn-success disabled">En el carrito</button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else:?>
        <div class="card shadow-sm"><div class="card-body text-center py-5"><h3>No se encontraron productos</h3></div></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="open"):
$p = ProductData::getById($_GET["id"]);
// Viewer::addView($p->id,"product_id","product_view"); // Asumiendo que Viewer existe si no, comentar
?>
<div class="page-body">
  <div class="container-xl">
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card shadow-sm mb-3">
          <div class="card-header"><h3 class="card-title">Categorías</h3></div>
          <div class="list-group list-group-flush">
            <?php foreach(CategoryData::getPublics() as $cat): ?>
            <a href="./?view=products&opt=all&cat=<?php echo $cat->short_name; ?>" class="list-group-item list-group-item-action">
              <i class="bi bi-chevron-right me-2 small"></i> <?php echo htmlspecialchars($cat->name); ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <?php if($p):
        $img = "admin/storage/products/".$p->image;
        if($p->image=="" || !file_exists($img)){ $img=$img_default; }
        $in_cart=false;
        if(isset($_SESSION["cart"])){
          foreach ($_SESSION["cart"] as $pc) {
            if($pc["product_id"]==$p->id){ $in_cart=true;  }
          }
        }
        ?>
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-md-6 text-center">
                <img src="<?php echo $img; ?>" class="img-fluid rounded" style="max-height: 350px;">
              </div>
              <div class="col-md-6">
                <h1 class="mb-2"><?php echo htmlspecialchars($p->name); ?></h1>
                <div class="text-primary h1 font-weight-bold mb-4"><?php echo $coin_symbol." ".number_format($p->price,2,".",","); ?></div>
                
                <div class="mb-4">
                  <?php if($p->in_existence):?>
                    <span class="badge bg-success-lt p-2"><i class="bi bi-check-circle"></i> En Existencia</span>
                  <?php else:?>
                    <span class="badge bg-warning-lt p-2"><i class="bi bi-dash-circle"></i> Agotado</span>
                  <?php endif; ?>
                </div>

                <div class="d-grid gap-2">
                  <?php if(!$p->in_existence):?>
                    <button class="btn btn-warning btn-pill disabled">No Disponible</button>
                  <?php elseif(!$in_cart):?>
                    <a href="./?action=cart&opt=add&product_id=<?php echo $p->id; ?>&href=open&id=<?php echo $p->id;?>" class="btn btn-primary btn-pill btn-lg">Añadir al carrito</a>
                  <?php else:?>
                    <button class="btn btn-success btn-pill btn-lg disabled">Ya está en el carrito</button>
                  <?php endif; ?>
                </div>
                <div class="mt-3 text-muted small">Código: <?php echo $p->code; ?></div>
              </div>
            </div>
            <hr>
            <div class="mt-4">
              <h3>Descripción</h3>
              <div class="markdown text-muted">
                <?php echo nl2br(htmlspecialchars($p->description)); ?>
              </div>
            </div>
          </div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger">Producto no encontrado.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
