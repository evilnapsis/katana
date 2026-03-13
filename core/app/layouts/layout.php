<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Katana v4 - Tienda Online</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/bootstrap-icons/bootstrap-icons.css">
    <script src="assets/jquery/jquery.min.js"></script>
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
      <header class="navbar navbar-expand-md d-print-none shadow-sm">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark pe-0 pe-md-3">
            <a href="./" class="text-decoration-none d-flex align-items-center">
              <i class="bi bi-shop text-primary me-2 h1 mb-0"></i>
              <span class="h2 mb-0">KATANA <span class="text-primary">SHOP</span></span>
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item d-none d-md-flex me-3">
              <a href="./?view=cart&opt=all" class="nav-link px-0" title="Ver Carrito">
                <i class="bi bi-cart3 h2 mb-0"></i>
                <?php if(isset($_SESSION["cart"]) && count($_SESSION["cart"])>0): ?>
                <span class="badge bg-red rounded-pill badge-notification"><?php echo count($_SESSION["cart"]); ?></span>
                <?php endif; ?>
              </a>
            </div>
            
            <?php if(isset($_SESSION["client_id"])): ?>
            <?php $client = ClientData::getById($_SESSION["client_id"]); ?>
            <div class="nav-item dropdown ps-3">
              <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown">
                <span class="avatar avatar-sm bg-primary text-white rounded-circle">
                  <i class="bi bi-person"></i>
                </span>
                <div class="d-none d-xl-block ps-2 text-start">
                  <div class="small fw-bold"><?php echo htmlspecialchars($client->name); ?></div>
                  <div class="mt-1 small text-muted">Mi Cuenta</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="./?view=client&opt=all" class="dropdown-item">Mis Compras</a>
                <div class="dropdown-divider"></div>
                <a href="./?action=client&opt=logout" class="dropdown-item text-danger">Cerrar Sesión</a>
              </div>
            </div>
            <?php else: ?>
            <div class="nav-item d-none d-md-flex">
              <a href="./?view=client&opt=login" class="btn btn-outline-primary me-2">Entrar</a>
              <a href="./?view=client&opt=register" class="btn btn-primary">Registro</a>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </header>
      
      <header class="navbar-expand-md border-bottom bg-white">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar">
            <div class="container-xl">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="./">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-house"></i></span>
                    <span class="nav-link-title">Inicio</span>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#navbar-products" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-grid"></i></span>
                    <span class="nav-link-title">Productos</span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="./?view=products&opt=all">Todos los Productos</a>
                    <div class="dropdown-divider"></div>
                    <?php foreach(CategoryData::getPublics() as $cat): ?>
                    <a class="dropdown-item" href="./?view=products&opt=all&cat=<?php echo $cat->short_name; ?>"><?php echo $cat->name; ?></a>
                    <?php endforeach; ?>
                  </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./?view=products&opt=all&filter=news">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-lightning"></i></span>
                    <span class="nav-link-title">Novedades</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./?view=products&opt=all&filter=offers">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-percent"></i></span>
                    <span class="nav-link-title">Ofertas</span>
                  </a>
                </li>
              </ul>
              <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last me-md-3">
                <form action="./?view=products&opt=all" method="get" autocomplete="off" novalidate>
                  <input type="hidden" name="view" value="products">
                  <input type="hidden" name="opt" value="all">
                  <div class="input-icon">
                    <span class="input-icon-addon"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Buscar productos..." aria-label="Search">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div class="page-wrapper">
        <?php View::load("index"); ?>
        
        <footer class="footer footer-transparent d-print-none bg-dark text-white py-5 mt-5">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item text-white-50">Soporte</li>
                  <li class="list-inline-item text-white-50">Términos y Condiciones</li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item text-white-50">
                    &copy; 2026 Katana Shop. Todos los derechos reservados.
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    
    <script src="./dist/js/tabler.min.js" defer></script>
  </body>
</html>
