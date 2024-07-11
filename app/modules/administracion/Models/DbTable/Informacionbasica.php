<?php 
/**
* clase que genera la insercion y edicion  de informaci&oacute;n b&aacute;sica en la base de datos
*/
class Administracion_Model_DbTable_Informacionbasica extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'estadocuenta_informacionbasica';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'estadocuenta_informacionbasica_id';

	/**
	 * insert recibe la informacion de un informaci&oacute;n b&aacute;sica y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$estadocuenta_informacionbasica_nombre = $data['estadocuenta_informacionbasica_nombre'];
		$estadocuenta_informacionbasica_cedula = $data['estadocuenta_informacionbasica_cedula'];
		$estadocuenta_informacionbasica_codigo = $data['estadocuenta_informacionbasica_codigo'];
		$estadocuenta_informacionbasica_fechaafiliacion = $data['estadocuenta_informacionbasica_fechaafiliacion'];
		$estadocuenta_informacionbasica_empresa = $data['estadocuenta_informacionbasica_empresa'];
		$estadocuenta_informacionbasica_correo = $data['estadocuenta_informacionbasica_correo'];

		$estadocuenta_informacionbasica_salario = $data['estadocuenta_informacionbasica_salario'];
		$estadocuenta_informacionbasica_direccion = $data['estadocuenta_informacionbasica_direccion'];
		$estadocuenta_informacionbasica_fechaempresa = $data['estadocuenta_informacionbasica_fechaempresa'];
		$estadocuenta_informacionbasica_celular = $data['estadocuenta_informacionbasica_celular'];


		$estadocuenta_informacionbasica_clave = $data['estadocuenta_informacionbasica_clave'];
		$estadocuenta_informacionbasica_token = $data['estadocuenta_informacionbasica_token'];
		$estadocuenta_informacionbasica_tokendate = $data['estadocuenta_informacionbasica_tokendate'];
		$estadocuenta_informacionbasica_activo = $data['estadocuenta_informacionbasica_activo'];
		$query = "INSERT INTO estadocuenta_informacionbasica( estadocuenta_informacionbasica_nombre, estadocuenta_informacionbasica_cedula, estadocuenta_informacionbasica_codigo, estadocuenta_informacionbasica_fechaafiliacion, estadocuenta_informacionbasica_empresa, estadocuenta_informacionbasica_correo, 
		estadocuenta_informacionbasica_salario, estadocuenta_informacionbasica_direccion, estadocuenta_informacionbasica_fechaempresa, estadocuenta_informacionbasica_celular, estadocuenta_informacionbasica_clave, estadocuenta_informacionbasica_token, estadocuenta_informacionbasica_tokendate, estadocuenta_informacionbasica_activo) VALUES ( '$estadocuenta_informacionbasica_nombre', '$estadocuenta_informacionbasica_cedula', '$estadocuenta_informacionbasica_codigo', '$estadocuenta_informacionbasica_fechaafiliacion', '$estadocuenta_informacionbasica_empresa', '$estadocuenta_informacionbasica_correo','$estadocuenta_informacionbasica_salario','$estadocuenta_informacionbasica_direccion','$estadocuenta_informacionbasica_fechaempresa','$estadocuenta_informacionbasica_celular', '$estadocuenta_informacionbasica_clave', '$estadocuenta_informacionbasica_token', '$estadocuenta_informacionbasica_tokendate', '$estadocuenta_informacionbasica_activo')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un informaci&oacute;n b&aacute;sica  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$estadocuenta_informacionbasica_nombre = $data['estadocuenta_informacionbasica_nombre'];
		$estadocuenta_informacionbasica_cedula = $data['estadocuenta_informacionbasica_cedula'];
		$estadocuenta_informacionbasica_codigo = $data['estadocuenta_informacionbasica_codigo'];
		$estadocuenta_informacionbasica_fechaafiliacion = $data['estadocuenta_informacionbasica_fechaafiliacion'];
		$estadocuenta_informacionbasica_empresa = $data['estadocuenta_informacionbasica_empresa'];
		$estadocuenta_informacionbasica_correo = $data['estadocuenta_informacionbasica_correo'];
		
		$estadocuenta_informacionbasica_salario = $data['estadocuenta_informacionbasica_salario'];
		$estadocuenta_informacionbasica_direccion = $data['estadocuenta_informacionbasica_direccion'];
		$estadocuenta_informacionbasica_fechaempresa = $data['estadocuenta_informacionbasica_fechaempresa'];
		$estadocuenta_informacionbasica_celular = $data['estadocuenta_informacionbasica_celular'];

		$estadocuenta_informacionbasica_clave = $data['estadocuenta_informacionbasica_clave'];
		$estadocuenta_informacionbasica_token = $data['estadocuenta_informacionbasica_token'];
		$estadocuenta_informacionbasica_tokendate = $data['estadocuenta_informacionbasica_tokendate'];
		$estadocuenta_informacionbasica_activo = $data['estadocuenta_informacionbasica_activo'];
		$query = "UPDATE estadocuenta_informacionbasica SET  estadocuenta_informacionbasica_nombre = '$estadocuenta_informacionbasica_nombre', estadocuenta_informacionbasica_cedula = '$estadocuenta_informacionbasica_cedula', estadocuenta_informacionbasica_codigo = '$estadocuenta_informacionbasica_codigo', estadocuenta_informacionbasica_fechaafiliacion = '$estadocuenta_informacionbasica_fechaafiliacion', estadocuenta_informacionbasica_empresa = '$estadocuenta_informacionbasica_empresa', estadocuenta_informacionbasica_correo = '$estadocuenta_informacionbasica_correo', estadocuenta_informacionbasica_salario = '$estadocuenta_informacionbasica_salario', estadocuenta_informacionbasica_direccion = '$estadocuenta_informacionbasica_direccion', estadocuenta_informacionbasica_fechaempresa = '$estadocuenta_informacionbasica_fechaempresa', estadocuenta_informacionbasica_celular = '$estadocuenta_informacionbasica_celular', estadocuenta_informacionbasica_clave = '$estadocuenta_informacionbasica_clave', estadocuenta_informacionbasica_token = '$estadocuenta_informacionbasica_token', estadocuenta_informacionbasica_tokendate = '$estadocuenta_informacionbasica_tokendate', estadocuenta_informacionbasica_activo = '$estadocuenta_informacionbasica_activo' WHERE estadocuenta_informacionbasica_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
	public function deleteAll(){
		$query = "TRUNCATE table estadocuenta_informacionbasica ";
		$res = $this->_conn->query($query);
	}
}