<?php 
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
if($user==null){ Core::redir("./");}

$num_spends = count(SpendData::getAll());
$num_categories = count(CategoryData::getAll());
$num_persons = count(PersonData::getAll());
$num_users = count(UserData::getAll());

$total_amount = 0;
foreach(SpendData::getAll() as $s){ $total_amount += $s->amount; }
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
    <div class="row row-deck row-cards">
      
      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-primary text-white avatar">
                  <i class="bi bi-wallet"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">
                  $ <?php echo number_format($total_amount,2); ?>
                </div>
                <div class="text-secondary">
                  Total Gastos
                </div>
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
                <div class="font-weight-medium">
                  <?php echo $num_categories; ?> Categorías
                </div>
                <div class="text-secondary">
                  Registradas
                </div>
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
                <div class="font-weight-medium">
                  <?php echo $num_persons; ?> Contactos
                </div>
                <div class="text-secondary">
                  En el sistema
                </div>
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
                <div class="font-weight-medium">
                  <?php echo $num_users; ?> Usuarios
                </div>
                <div class="text-secondary">
                   Administradores
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="row mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Bienvenido, <?php echo htmlspecialchars($user->name); ?></h3>
          </div>
          <div class="card-body">
             <p class="text-secondary">Has iniciado sesión correctamente en el panel administrativo de <strong>TABLER XADMIN</strong>. Utiliza los contadores superiores para tener una visión rápida de los recursos actuales.</p>
          </div>
        </div>
      </div>
    </div>


    <div class="row mt-4">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">Resumen de Gastos (Últimos 30 días)</h3>
            <div id="chart-spends" class="position-relative chart-lg"></div>
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
$spends_chart = SpendData::getByRange($start_date, $end_date);

$data_points = [];
// Inicializar los 30 días con 0
for($i=30; $i>=0; $i--){
    $d = date("Y-m-d", strtotime("-$i days"));
    $data_points[$d] = 0;
}

// Llenar con datos reales
foreach($spends_chart as $s){
    if(isset($data_points[$s->date_at])){
        $data_points[$s->date_at] += $s->amount;
    }
}

$labels = array_keys($data_points);
$values = array_values($data_points);
?>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    window.ApexCharts &&
      new ApexCharts(document.getElementById("chart-spends"), {
        chart: {
          type: "area",
          fontFamily: "inherit",
          height: 240,
          parentHeightOffset: 0,
          toolbar: {
            show: false,
          },
          animations: {
            enabled: true,
          },
        },
        fill: {
          opacity: .16,
          type: 'solid'
        },
        stroke: {
          width: 2,
          lineCap: "round",
          curve: "smooth",
        },
        series: [{
          name: "Gastos",
          data: <?php echo json_encode($values); ?>
        }],
        tooltip: {
          theme: 'dark'
        },
        grid: {
          padding: {
            top: -20,
            right: 0,
            left: -4,
            bottom: -4,
          },
          strokeDashArray: 4,
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