<?php
if(isset($_SESSION["user_id"])){
  Core::redir("./?view=home");
}
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
    <div class="card card-md mb-3">
      <div class="card-stamp card-stamp-lg">
        <div class="card-stamp-icon bg-primary">
          <i class="bi bi-star" style="font-size: 3rem;"></i>
        </div>
      </div>
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-10">
            <h3 class="h1">Hola, Legobox</h3>
            <div class="markdown text-muted">Legobox es un microframework para el desarrollo rapido y ligero de proyectos en PHP.</div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row row-cards">
      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-primary text-white avatar">
                  <i class="bi bi-eye"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">Vistas</div>
                <div class="text-muted">Las vistas sirven para mostrar contenido al usuario.</div>
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
                  <i class="bi bi-bookmark"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">Acciones</div>
                <div class="text-muted">Las acciones sirven para procesar peticiones y ajax.</div>
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
                <span class="bg-twitter text-white avatar">
                  <i class="bi bi-table"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">Modelos</div>
                <div class="text-muted">Agilizar la manipulacion de datos bd.</div>
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
                <span class="bg-facebook text-white avatar">
                  <i class="bi bi-plus"></i>
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">Mucho mas</div>
                <div class="text-muted">Legobox es totalmente adaptable y flexible.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>