<div class="page-body">
  <div class="container-tight py-4">
    <div class="text-center mb-4">
      <h1 class="navbar-brand navbar-brand-autodark">LegoBox</h1>
    </div>
    <div class="card card-md">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">Iniciar sesion</h2>
        <form method="post" action="./?action=access&opt=login">
          <div class="mb-3">
            <label class="form-label">Correo Electronico</label>
            <input type="text" required name="email" class="form-control" placeholder="your@email.com" autocomplete="off">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group input-group-flat">
              <input type="password" required name="password" class="form-control" placeholder="Password" autocomplete="off">
            </div>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Acceder</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>