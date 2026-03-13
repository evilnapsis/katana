<div class="page-body">
  <div class="container-tight py-4">
    <div class="text-center mb-4">
      <h1 class="navbar-brand navbar-brand-autodark">LegoBox</h1>
    </div>
    <div class="card card-md">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">Registrarse</h2>
        <form method="post" action="./?action=users&opt=register">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" required name="name" class="form-control" placeholder="Nombre">
          </div>
          <div class="mb-3">
            <label class="form-label">Apellidos</label>
            <input type="text" required name="lastname" class="form-control" placeholder="Apellidos">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" required name="email" class="form-control" placeholder="Email">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" required name="password" class="form-control" placeholder="Password">
          </div>
          <div class="mb-3">
            <label class="form-label">Confirmar Password</label>
            <input type="password" required name="confirm_password" class="form-control" placeholder="Confirmar Password">
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>