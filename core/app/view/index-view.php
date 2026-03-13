<?php 
$coin_symbol = ConfigurationData::getByPreffix("general_coin")?ConfigurationData::getByPreffix("general_coin")->val:"$";
$img_default = ConfigurationData::getByPreffix("general_img_default")?ConfigurationData::getByPreffix("general_img_default")->val:"assets/img/default.png";
$slides = SlideData::getPublics();
$featureds = ProductData::getFeatureds();
?>
<div class="page-body">
  <div class="container-xl">
    <?php if(count($slides)>0):?>
    <div id="carousel-slides" class="carousel slide mb-4" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <?php foreach($slides as $index => $s):?>
        <button type="button" data-bs-target="#carousel-slides" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index==0?'active':''; ?>"></button>
        <?php endforeach; ?>
      </div>
      <div class="carousel-inner shadow-sm rounded">
        <?php foreach($slides as $index => $s):
        $url = "admin/storage/slides/".$s->image;
        ?>
        <div class="carousel-item <?php echo $index==0?'active':''; ?>">
          <img src="<?php echo $url; ?>" class="d-block w-100" style="max-height: 400px; object-fit: cover;" alt="<?php echo htmlspecialchars($s->title); ?>">
          <div class="carousel-caption d-none d-md-block">
            <h2 class="bg-dark bg-opacity-50 d-inline-block px-3 py-1 rounded"><?php echo htmlspecialchars($s->title); ?></h2>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carousel-slides" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carousel-slides" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <?php endif; ?>

    <div class="row g-4">
      <div class="col-md-12">
        <div class="d-flex align-items-center mb-3">
          <h2 class="h1 mb-0"><i class="bi bi-star-fill text-warning"></i> Productos Destacados</h2>
          <div class="ms-auto">
            <a href="./?view=products&opt=all" class="btn btn-outline-primary btn-sm">Ver todos</a>
          </div>
        </div>

        <?php if(count($featureds)>0):?>
        <div class="row row-cards">
          <?php foreach($featureds as $p):
          $img = "admin/storage/products/".$p->image;
          if($p->image=="" || !file_exists($img)){ $img=$img_default; }
          $in_cart=false;
          if(isset($_SESSION["cart"])){
            foreach ($_SESSION["cart"] as $pc) {
              if($pc["product_id"]==$p->id){ $in_cart=true;  }
            }
          }
          ?>
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card card-stacked shadow-sm h-100">
              <div class="card-body p-3 text-center">
                <a href="./?view=products&opt=open&id=<?php echo $p->id; ?>">
                  <img src="<?php echo $img; ?>" class="img-fluid rounded mb-3" style="height: 150px; object-fit: contain;">
                </a>
                <h3 class="card-title mb-1"><?php echo htmlspecialchars($p->name); ?></h3>
                <div class="text-primary h2 font-weight-bold mb-3"><?php echo $coin_symbol." ".number_format($p->price,2,".",","); ?></div>
                
                <div class="d-grid gap-2">
                  <?php if(!$p->in_existence):?>
                    <button class="btn btn-warning disabled"><i class="bi bi-dash-circle"></i> No Disponible</button>
                  <?php elseif(!$in_cart):?>
                    <a href="./?action=cart&opt=add&product_id=<?php echo $p->id; ?>&href=home" class="btn btn-primary"><i class="bi bi-cart-plus"></i> Comprar</a>
                  <?php else:?>
                    <button class="btn btn-success disabled"><i class="bi bi-check-circle"></i> Agregado</button>
                  <?php endif; ?>
                  <a href="./?view=products&opt=open&id=<?php echo $p->id; ?>" class="btn btn-link btn-sm text-muted">Detalles</a>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else:?>
        <div class="card card-md">
          <div class="card-body text-center py-5">
            <div class="mb-3">
              <i class="bi bi-search" style="font-size: 3rem; color: #ccc;"></i>
            </div>
            <h3>No hay productos destacados</h3>
            <p class="text-muted">En la pagina principal solo se muestran productos marcados como destacados.</p>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>