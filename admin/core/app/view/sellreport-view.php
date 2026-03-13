<?php
if(!isset($_SESSION["user_id"])){ Core::redir("./");}

$buys = array();
if(isset($_GET["start_at"]) && isset($_GET["finish_at"]) && $_GET["start_at"]!="" && $_GET["finish_at"]!=""){
    $buys = BuyData::getByRange($_GET["start_at"]." 00:00:00", $_GET["finish_at"]." 23:59:59");
} else {
    $buys = BuyData::getAll();
}
$coin = ConfigurationData::getByPreffix("general_coin")->val;
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Reporte de Ventas</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card mb-3">
      <div class="card-body">
        <form method="get">
          <input type="hidden" name="view" value="sellreport">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Desde</label>
              <input type="date" name="start_at" class="form-control" value="<?php echo isset($_GET["start_at"])?$_GET["start_at"]:""; ?>">
            </div>
            <div class="col-md-4">
              <label class="form-label">Hasta</label>
              <input type="date" name="finish_at" class="form-control" value="<?php echo isset($_GET["finish_at"])?$_GET["finish_at"]:""; ?>">
            </div>
            <div class="col-md-4 d-flex align-items-end">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel me-1"></i> Generar Reporte
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <?php if(isset($_GET["start_at"]) && isset($_GET["finish_at"]) && $_GET["start_at"]!="" && $_GET["finish_at"]!=""): 
        $start_at = strtotime($_GET["start_at"]);
        $finish_at = strtotime($_GET["finish_at"]);
        $labels = [];
        $values = [];
        for($i=$start_at; $i<=$finish_at; $i+=(60*60*24)){
            $date = date("Y-m-d", $i);
            $labels[] = $date;
            $operations = BuyData::getAllByDate($date);
            $total_day = 0;
            foreach ($operations as $buy) {
                $total_day += $buy->getTotal();
            }
            $values[] = $total_day;
        }
    ?>
    <div class="card mb-3">
      <div class="card-body">
        <h3 class="card-title">Tendencia de Ventas (<?php echo $coin; ?>)</h3>
        <div id="chart-report" class="position-relative chart-lg"></div>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("chart-report"), {
            chart: {
              type: "area",
              fontFamily: "inherit",
              height: 300,
              parentHeightOffset: 0,
              toolbar: { show: false },
              animations: { enabled: true },
            },
            fill: { opacity: .1, type: 'solid' },
            stroke: { width: 3, lineCap: "round", curve: "smooth" },
            series: [{
              name: "Ventas",
              data: <?php echo json_encode($values); ?>
            }],
            tooltip: { theme: 'dark', x: { format: 'dd MMM' } },
            grid: { strokeDashArray: 4, padding: { top: -20, right: 0, left: -4, bottom: -4 } },
            xaxis: {
              categories: <?php echo json_encode($labels); ?>,
              type: 'datetime',
            },
            colors: ["var(--tblr-primary)"],
          }).render();
      });
    </script>
    <?php endif; ?>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Resultados</h3>
      </div>
      <div class="card-body">
      <div class="table-responsive">
        <?php if(count($buys)>0): ?>
        <table class="table table-vcenter table-mobile-md card-table datatable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Cliente</th>
              <th>SubTotal</th>
              <th>Descuento</th>
              <th>Total</th>
              <th>Método</th>
              <th>Estado</th>
              <th>Fecha</th>
              <th class="w-1"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($buys as $b): 
                $client = $b->getClient();
                $paymethod = $b->getPaymethod();
                $status = $b->getStatus();
                $discount = 0;
                if($b->coupon_id != null){
                    //$coupon = CouponData::getById($b->coupon_id);
                    $discount =0; // $coupon->val;
                }
                $total = $b->getTotal();
            ?>
            <tr>
              <td data-label="ID">#<?php echo $b->id; ?></td>
              <td data-label="Cliente"><?php echo htmlspecialchars($client->getFullname()); ?></td>
              <td data-label="SubTotal"><?php echo $coin; ?> <?php echo number_format($total, 2); ?></td>
              <td data-label="Descuento"><?php echo $coin; ?> <?php echo number_format($discount, 2); ?></td>
              <td data-label="Total" class="fw-bold"><?php echo $coin; ?> <?php echo number_format($total - $discount, 2); ?></td>
              <td data-label="Método"><?php echo $paymethod->name; ?></td>
              <td data-label="Estado">
                <?php 
                  $badge = "secondary";
                  if($b->status_id == 1) $badge = "warning";
                  if($b->status_id == 2) $badge = "success";
                  if($b->status_id == 3) $badge = "danger";
                ?>
                <span class="badge bg-<?php echo $badge; ?>-lt"><?php echo $status->name; ?></span>
              </td>
              <td data-label="Fecha"><?php echo $b->created_at; ?></td>
              <td>
                <a href="./?view=sells&opt=open&id=<?php echo $b->id; ?>" class="btn btn-sm btn-ghost-primary">Detalles</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div class="empty py-5">
          <div class="empty-icon"><i class="bi bi-search h1"></i></div>
          <p class="empty-title">No hay operaciones</p>
          <p class="empty-subtitle text-muted">Intenta cambiar el rango de fechas para encontrar resultados.</p>
        </div>
        <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</div>
