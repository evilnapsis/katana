<div class="container">
	<div class="row">
		<div class="col-md-6">
    <h3>Registrate para poder participar y comprar!</h3>  
    <p>Si gustas participar en preguntas o deseas comprar, es requerimiento obligatorio registrarse utilizando el formulario de la derecha y ofrecer datos fidedignos.</p>
    </div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
        <div class="lead">REGISTRO DE CLIENTES</div>
<form class="form-horizontal" role="form" method="post" action="index.php?action=register">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-12 control-label">*Nombre</label>
    <div class="col-lg-12">
      <input type="text" required name="name" class="form-control" id="inputEmail1" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-12 control-label">*Apellido</label>
    <div class="col-lg-12">
      <input type="text" required name="lastname" class="form-control" id="inputEmail1" placeholder="Apellido">
    </div>
  </div>
  <!--
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-12 control-label">Telefono</label>
    <div class="col-lg-12">
      <input type="text" name="phone" class="form-control" id="inputEmail1" placeholder="Telefono">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-12 control-label">Direccion</label>
    <div class="col-lg-12">
      <input type="text" name="address" class="form-control" id="inputEmail1" placeholder="Direccion">
    </div>
  </div>
-->
<input type="hidden" name="phone">
<input type="hidden" name="address">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-12 control-label">*Correo Electronico</label>
    <div class="col-lg-12">
      <input type="email" name="email" required class="form-control" id="inputEmail1" placeholder="Correo Electronico">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword1" class="col-lg-12 control-label">*Contrase&ntilde;a</label>
    <div class="col-lg-12">
      <input type="password" required name="password" class="form-control" id="inputPassword1" placeholder="Contrase&ntilde;a">
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-12">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="accept" required> Acepto terminos y condiciones de uso
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-12">
      <button type="submit" class="btn btn-block btn-secondary">Registrarme</button>
    </div>
  </div>
</form>
      <p class="text-muted">* Campos obligatorios</p>
				</div>
			</div>
		</div>
	</div>
</div>