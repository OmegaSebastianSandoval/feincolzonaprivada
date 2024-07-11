<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform;?>"  data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->estadocuenta_informacionbasica_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->estadocuenta_informacionbasica_id; ?>" />
			<?php }?>
			<div class="row">
				<div class="col-12 form-group">
					<label for="estadocuenta_informacionbasica_nombre"  class="control-label">estadocuenta_informacionbasica_nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->estadocuenta_informacionbasica_nombre; ?>" name="estadocuenta_informacionbasica_nombre" id="estadocuenta_informacionbasica_nombre" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="estadocuenta_informacionbasica_cedula"  class="control-label">estadocuenta_informacionbasica_cedula</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-cafe " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->estadocuenta_informacionbasica_cedula; ?>" name="estadocuenta_informacionbasica_cedula" id="estadocuenta_informacionbasica_cedula" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="estadocuenta_informacionbasica_codigo"  class="control-label">estadocuenta_informacionbasica_codigo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde-claro " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->estadocuenta_informacionbasica_codigo; ?>" name="estadocuenta_informacionbasica_codigo" id="estadocuenta_informacionbasica_codigo" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="estadocuenta_informacionbasica_fechaafiliacion"  class="control-label">estadocuenta_informacionbasica_fechaafiliacion</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-morado " ><i class="fas fa-calendar-alt"></i></span>
						</div>
					<input type="text" value="<?php if($this->content->estadocuenta_informacionbasica_fechaafiliacion){ echo $this->content->estadocuenta_informacionbasica_fechaafiliacion; } else { echo date('Y-m-d'); } ?>" name="estadocuenta_informacionbasica_fechaafiliacion" id="estadocuenta_informacionbasica_fechaafiliacion" class="form-control"   data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-language="es"  >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="estadocuenta_informacionbasica_empresa"  class="control-label">estadocuenta_informacionbasica_empresa</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rosado " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->estadocuenta_informacionbasica_empresa; ?>" name="estadocuenta_informacionbasica_empresa" id="estadocuenta_informacionbasica_empresa" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="estadocuenta_informacionbasica_correo"  class="control-label">estadocuenta_informacionbasica_correo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->estadocuenta_informacionbasica_correo; ?>" name="estadocuenta_informacionbasica_correo" id="estadocuenta_informacionbasica_correo" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="estadocuenta_informacionbasica_clave"  class="control-label">estadocuenta_informacionbasica_clave</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rojo-claro " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->estadocuenta_informacionbasica_clave; ?>" name="estadocuenta_informacionbasica_clave" id="estadocuenta_informacionbasica_clave" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="estadocuenta_informacionbasica_token"  class="control-label">estadocuenta_informacionbasica_token</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->estadocuenta_informacionbasica_token; ?>" name="estadocuenta_informacionbasica_token" id="estadocuenta_informacionbasica_token" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="estadocuenta_informacionbasica_tokendate"  class="control-label">estadocuenta_informacionbasica_tokendate</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->estadocuenta_informacionbasica_tokendate; ?>" name="estadocuenta_informacionbasica_tokendate" id="estadocuenta_informacionbasica_tokendate" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-12 form-group">
					<label for="estadocuenta_informacionbasica_activo"  class="control-label">estadocuenta_informacionbasica_activo</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-azul-claro " ><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->estadocuenta_informacionbasica_activo; ?>" name="estadocuenta_informacionbasica_activo" id="estadocuenta_informacionbasica_activo" class="form-control"   >
					</label>
					<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>