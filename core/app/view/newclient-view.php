<section class="content">
<div class="row">
	<div class="col-md-12">
	<h1>Nueva Dependencia</h1>
	<br>
<div class="box box-primary"><br>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=addclient" role="form">


  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre de dependencia</label>
    <div class="col-md-6">
      <input type="text" name="name" class="form-control" required id="name" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label"></label>
    <div class="col-md-6">
      <input type="hidden" name="lastname" required class="form-control" id="lastname" placeholder="Apellido">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label"></label>
    <div class="col-md-6">
      <input type="hidden" name="no" class="form-control" id="no" placeholder="RFC/RUT">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Direccion</label>
    <div class="col-md-6">
      <input type="text" name="address1" class="form-control" id="address1" placeholder="Direccion">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Email</label>
    <div class="col-md-6">
      <input type="text" name="email1" class="form-control" id="email1" placeholder="Email">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Telefono</label>
    <div class="col-md-6">
      <input type="text" name="phone1" class="form-control" id="phone1" placeholder="Telefono">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label" ></label>
    <div class="col-md-6">
<div class="checkbox">
    <label>
      <input type="hidden" name="has_credit">
    </label>
  </div>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label"></label>
    <div class="col-md-6">
      <input type="hidden" name="credit_limit" class="form-control" id="" placeholder="Limite de credito">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label" ></label>
    <div class="col-md-6">
<div class="checkbox">
    <label>
      <input type="hidden" name="is_active_access">
    </label>
  </div>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label"></label>
    <div class="col-md-6">
      <input type="hidden" name="password" class="form-control" id="phone1" placeholder="Password">
<p class="text-muted"></p>
    </div>
    </div>

  <p class="alert alert-info">* Campos obligatorios</p>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Cliente</button>
    </div>
  </div>
</form>
</div>
	</div>
</div>
</section>