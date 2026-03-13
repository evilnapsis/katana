<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
if($user==null){ Core::redir("./");}

$num_categories = count(CategoryData::getAll());
$num_products = count(ProductData::getAll());
$num_clients = count(ClientData::getAll());
$num_users = count(UserData::getAll());

$status = StatusData::getAll();
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          Dashboard
        </h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    
    <!-- Status Counters -->
    <div class="row row-deck row-cards mb-4">
      <?php foreach($status as $s): 
        $count = BuyData::countByStatusId($s->id)->c;
        $color = "primary";
        $icon = "bi-cart";
        if($s->id == 1) { $color = "warning"; $icon = "bi-clock"; }
        if($s->id == 2) { $color = "success"; $icon = "bi-check-circle"; }
        if($s->id == 3) { $color = "danger"; $icon = "bi-x-circle"; }
      ?>
      <div class="col-sm-6 col-lg-2">
        <div class="card card-sm shadow-sm border-0 border-start border-<?php echo $color; ?> border-3">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-<?php echo $color; ?>-lt text-<?php echo $color; ?> avatar">
                  <i class="bi <?php echo $icon; ?>"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium h2 mb-0">
                  <?php echo $count; ?>
                </div>
                <div class="text-secondary small font-weight-bold text-uppercase">
                  <?php echo $s->name; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- General Stats -->
    <div class="row row-deck row-cards">
      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-blue text-white avatar">
                  <i class="bi bi-box-seam"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium"><?php echo $num_products; ?> Productos</div>
                <div class="text-secondary small">En inventario</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-green text-white avatar">
                  <i class="bi bi-tags"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium"><?php echo $num_categories; ?> Categorías</div>
                <div class="text-secondary small">Organizadas</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-yellow text-white avatar">
                  <i class="bi bi-people"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium"><?php echo $num_clients; ?> Clientes</div>
                <div class="text-secondary small">Registrados</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-red text-white avatar">
                   <i class="bi bi-person-badge"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium"><?php echo $num_users; ?> Usuarios</div>
                <div class="text-secondary small">Administradores</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-lg-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h3 class="card-title mb-0">Resumen de Ventas (Últimos 30 días)</h3>
                <div class="ms-auto">
                    <span class="badge bg-primary-lt">Total de Pedidos</span>
                </div>
            </div>
            <div id="chart-buys" class="position-relative chart-lg"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php
// Lógica para la gráfica de los últimos 30 días
$start_date = date("Y-m-d", strtotime("-30 days"));
$end_date = date("Y-m-d");
$buys_chart = BuyData::getByRange($start_date . " 00:00:00", $end_date . " 23:59:59");

$data_points = [];
// Inicializar los 30 días con 0
for($i=30; $i>=0; $i--){
    $d = date("Y-m-d", strtotime("-$i days"));
    $data_points[$d] = 0;
}

// Llenar con datos reales (conteo de ventas por día)
foreach($buys_chart as $b){
    $day = date("Y-m-d", strtotime($b->created_at));
    if(isset($data_points[$day])){
        $data_points[$day]++;
    }
}

$labels = array_keys($data_points);
$values = array_values($data_points);
?>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    window.ApexCharts &&
      new ApexCharts(document.getElementById("chart-buys"), {
        chart: {
          type: "area",
          fontFamily: "inherit",
          height: 300,
          parentHeightOffset: 0,
          toolbar: {
            show: false,
          },
          animations: {
            enabled: true,
          },
        },
        fill: {
          opacity: .1,
          type: 'solid'
        },
        stroke: {
          width: 3,
          lineCap: "round",
          curve: "smooth",
        },
        series: [{
          name: "Ventas",
          data: <?php echo json_encode($values); ?>
        }],
        tooltip: {
          theme: 'dark',
          x: {
            format: 'dd MMM'
          }
        },
        grid: {
          strokeDashArray: 4,
          padding: {
            top: -20,
            right: 0,
            left: -4,
            bottom: -4,
          },
        },
        xaxis: {
          categories: <?php echo json_encode($labels); ?>,
          labels: {
            padding: 0,
          },
          tooltip: {
            enabled: false,
          },
          axisBorder: {
            show: false,
          },
          type: 'datetime',
        },
        yaxis: {
          labels: {
            padding: 4,
          },
        },
        colors: ["var(--tblr-primary)"],
        legend: {
          show: false,
        },
      }).render();
  });
</script>