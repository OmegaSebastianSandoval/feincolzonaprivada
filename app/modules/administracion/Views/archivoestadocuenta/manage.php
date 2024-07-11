<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
	<form class="text-left" enctype="multipart/form-data" method="post" action="<?php echo $this->routeform; ?>" data-bs-toggle="validator">
		<div class="content-dashboard">
			<input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
			<input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
			<?php if ($this->content->estadocuenta_archivo_id) { ?>
				<input type="hidden" name="id" id="id" value="<?= $this->content->estadocuenta_archivo_id; ?>" />
			<?php } ?>
			<div class="row">
				<div class="col-4 form-group">
					<label for="estadocuenta_archivo_nombre" class="control-label">Nombre</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-rosado "><i class="fas fa-pencil-alt"></i></span>
						</div>
						<input type="text" value="<?= $this->content->estadocuenta_archivo_nombre; ?>" name="estadocuenta_archivo_nombre" id="estadocuenta_archivo_nombre" class="form-control" required>
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="estadocuenta_archivo_fecha" class="control-label">Fecha</label>
					<label class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text input-icono  fondo-verde "><i class="fas fa-calendar-alt"></i></span>
						</div>
						<input type="text" value="<?php if ($this->content->estadocuenta_archivo_fecha) {
														echo $this->content->estadocuenta_archivo_fecha;
													} else {
														echo date('Y-m-d');
													} ?>" name="estadocuenta_archivo_fecha" id="estadocuenta_archivo_fecha" class="form-control" required data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-language="es">
					</label>
					<div class="help-block with-errors"></div>
				</div>
				<div class="col-4 form-group">
					<label for="estadocuenta_archivo_documento">Documento</label>
					<input type="file" name="estadocuenta_archivo_documento" id="estadocuenta_archivo_documento" class="form-control file-document" data-buttonName="btn-primary" onchange="validardocumento('estadocuenta_archivo_documento');" accept="application/msword, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, text/plain, application/pdf" required>

					<div class="help-block with-errors"></div>
					<?php if ($this->content->estadocuenta_archivo_documento) { ?>
						<div id="archivo_estadocuenta_archivo_documento">
							<div><?php echo $this->content->estadocuenta_archivo_documento; ?></div>
							<div><button class="btn btn-danger btn-sm" type="button" onclick="eliminararchivo('estadocuenta_archivo_documento','<?php echo $this->route . "/deletearchivo"; ?>')"><i class="glyphicon glyphicon-remove"></i> Eliminar Archivo</button></div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="botones-acciones">
			<button class="btn btn-guardar" type="submit">Guardar</button>
			<a href="<?php echo $this->route; ?>" class="btn btn-cancelar">Cancelar</a>
		</div>
	</form>
</div>