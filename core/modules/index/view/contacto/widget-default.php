<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<h2>Envianos un mensaje</h2>
<form role="form" method="post" action="./?action=contact">
  <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Tu nombre">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Correo Electronico</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Tu email" required>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Asunto</label>
    <input type="text" name="subject" class="form-control" id="exampleInputEmail1" placeholder="Asunto del mensaje">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Mensaje</label>
    <textarea name="message" rows="3" placeholder="Escribe tu mensaje" required class="form-control"></textarea>
  </div>

  <button type="submit" class="btn btn-default">Enviar mensaje</button>
</form>

</div>
</div>
</div>