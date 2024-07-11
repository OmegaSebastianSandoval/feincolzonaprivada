<?php 
/**
* clase que genera la insercion y edicion  de Archivo de estado de cuenta en la base de datos
*/
class Administracion_Model_DbTable_Archivoestadocuenta extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'estadocuenta_archivos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'estadocuenta_archivo_id';

	/**
	 * insert recibe la informacion de un Archivo de estado de cuenta y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$estadocuenta_archivo_nombre = $data['estadocuenta_archivo_nombre'];
		$estadocuenta_archivo_fecha = $data['estadocuenta_archivo_fecha'];
		$estadocuenta_archivo_documento = $data['estadocuenta_archivo_documento'];
		$query = "INSERT INTO estadocuenta_archivos( estadocuenta_archivo_nombre, estadocuenta_archivo_fecha, estadocuenta_archivo_documento) VALUES ( '$estadocuenta_archivo_nombre', '$estadocuenta_archivo_fecha', '$estadocuenta_archivo_documento')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Archivo de estado de cuenta  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$estadocuenta_archivo_nombre = $data['estadocuenta_archivo_nombre'];
		$estadocuenta_archivo_fecha = $data['estadocuenta_archivo_fecha'];
		$estadocuenta_archivo_documento = $data['estadocuenta_archivo_documento'];
		$query = "UPDATE estadocuenta_archivos SET  estadocuenta_archivo_nombre = '$estadocuenta_archivo_nombre', estadocuenta_archivo_fecha = '$estadocuenta_archivo_fecha', estadocuenta_archivo_documento = '$estadocuenta_archivo_documento' WHERE estadocuenta_archivo_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}