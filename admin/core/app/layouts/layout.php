<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>.: KATANA V4 ADMIN - Evilnapsis :.</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/bootstrap-icons/bootstrap-icons.css">
    <script src="assets/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css">
    <script src="assets/datatables/datatables.min.js"></script>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
        font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body>
    <div class="page">
      <!-- Navbar -->
      <header class="navbar  navbar-expand-md d-print-none" data-bs-theme="dark">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="./" class="text-decoration-none d-flex align-items-center">
              <i class="bi bi-shield-lock text-primary me-2 h1 mb-0"></i>
              <span>KATANA <span class="text-primary">ADMIN</span></span>
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <?php if(isset($_SESSION["user_id"])): ?>
            <div class="nav-item dropdown d-none d-md-flex me-3">
              <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show app menu" data-bs-auto-close="outside" aria-expanded="false">
                <i class="bi bi-grid-3x3-gap" style="font-size: 1.25rem;"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">My Apps</h3>
                  </div>
                  <div class="card-body scroll-y p-2" style="max-height: 50vh; width: 300px;">
                    <div class="row g-0">
                      <div class="col-6">
                        <a href="./?view=products&opt=all" class="d-flex flex-column flex-center text-center text-secondary py-3 px-2 link-hoverable">
                          <i class="bi bi-box-seam text-primary mb-2" style="font-size: 2rem;"></i>
                          <span class="h5">Productos</span>
                        </a>
                      </div>
                      <div class="col-6">
                        <a href="./?view=sells&opt=all" class="d-flex flex-column flex-center text-center text-secondary py-3 px-2 link-hoverable">
                          <i class="bi bi-cart-check text-success mb-2" style="font-size: 2rem;"></i>
                          <span class="h5">Ventas</span>
                        </a>
                      </div>
                      <div class="col-6">
                        <a href="./?view=sellreport" class="d-flex flex-column flex-center text-center text-secondary py-3 px-2 link-hoverable">
                          <i class="bi bi-graph-up text-indigo mb-2" style="font-size: 2rem;"></i>
                          <span class="h5">Reportes</span>
                        </a>
                      </div>
                      <div class="col-6">
                        <a href="./?view=categories&opt=all" class="d-flex flex-column flex-center text-center text-secondary py-3 px-2 link-hoverable">
                          <i class="bi bi-tags text-warning mb-2" style="font-size: 2rem;"></i>
                          <span class="h5">Categorías</span>
                        </a>
                      </div>
                      <div class="col-6">
                        <a href="./?view=settings&opt=payment" class="d-flex flex-column flex-center text-center text-secondary py-3 px-2 link-hoverable">
                          <i class="bi bi-credit-card text-info mb-2" style="font-size: 2rem;"></i>
                          <span class="h5">Pagos</span>
                        </a>
                      </div>
                      <div class="col-6">
                        <a href="./?view=slider&opt=all" class="d-flex flex-column flex-center text-center text-secondary py-3 px-2 link-hoverable">
                          <i class="bi bi-images text-danger mb-2" style="font-size: 2rem;"></i>
                          <span class="h5">Slider</span>
                        </a>
                      </div>
                      <div class="col-6">
                        <a href="./?view=users&opt=all" class="d-flex flex-column flex-center text-center text-secondary py-3 px-2 link-hoverable">
                          <i class="bi bi-person-badge text-light mb-2" style="font-size: 2rem;"></i>
                          <span class="h5">Usuarios</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php $u = UserData::getById($_SESSION["user_id"]); ?>
            <div class="nav-item dropdown ps-3">
              <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown">
                <span class="avatar avatar-sm bg-primary text-white"><i class="bi bi-person"></i></span>
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo htmlspecialchars($u->name." ".$u->lastname); ?></div>
                  <div class="mt-1 small text-muted">Administrador</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="./?view=settings&opt=all" class="dropdown-item">Configuración</a>
                <div class="dropdown-divider"></div>
                <a href="./?action=access&opt=logout" class="dropdown-item text-danger">Salir</a>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </header>
      <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar">
            <div class="container-xl">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="./" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-house"></i></span>
                    <span class="nav-link-title">Inicio</span>
                  </a>
                </li>
                <?php if(isset($_SESSION["user_id"])):?>
                <li class="nav-item">
                  <a class="nav-link" href="./?view=sells&opt=all" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-cart-check"></i></span>
                    <span class="nav-link-title">Ventas</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./?view=sellreport" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-graph-up"></i></span>
                    <span class="nav-link-title">Reportes</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./?view=products&opt=all" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-box-seam"></i></span>
                    <span class="nav-link-title">Productos</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./?view=categories&opt=all" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-tags"></i></span>
                    <span class="nav-link-title">Categorías</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./?view=clients&opt=all" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-people"></i></span>
                    <span class="nav-link-title">Clientes</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./?view=slider&opt=all" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-images"></i></span>
                    <span class="nav-link-title">Slider</span>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#navbar-more" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-gear"></i></span>
                    <span class="nav-link-title">Sistema</span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="./?view=users&opt=all">Usuarios</a>
                    <a class="dropdown-item" href="./?view=settings&opt=all">Ajustes</a>
                    <a class="dropdown-item" href="./?view=settings&opt=payment">Metodos de Pago</a>
                  </div>
                </li>
                <?php else: ?>
                  <li class="nav-item">
                    <a class="nav-link" href="./?view=login" >
                      <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-box-arrow-in-right"></i></span>
                      <span class="nav-link-title">Iniciar Sesión</span>
                    </a>
                  </li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
      </header>
      
      <div class="page-wrapper">
        <?php View::load("index"); ?>
        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Powered by <a href="http://evilnapsis.com/" target="_blank" class="link-secondary">Evilnapsis</a> &copy; 2026
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    
    <script src="./dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
    <script src="./dist/js/tabler.min.js" defer></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".datatable").DataTable();
      });
    </script>
  </body>
</html>
