<?php

/**
 * Controlador de Archivoestadocuenta que permite la  creacion, edicion  y eliminacion de los Archivo de estado de cuenta del Sistema
 */

/**
 * Controlador de Archivoestadocuenta que permite la  creacion, edicion  y eliminacion de los Archivo de estado de cuenta del Sistema
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Administracion_archivoestadocuentaController extends Administracion_mainController
{

	public $botonpanel = 5;


	/**
	 * $mainModel  instancia del modelo de  base de datos Archivo de estado de cuenta
	 * @var modeloContenidos
	 */
	public $mainModel;

	/**
	 * $route  url del controlador base
	 * @var string
	 */
	protected $route;

	/**
	 * $pages cantidad de registros a mostrar por pagina]
	 * @var integer
	 */
	protected $pages;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_archivoestadocuenta";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
	 * Inicializa las variables principales del controlador archivoestadocuenta .
	 *
	 * @return void.
	 */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Archivoestadocuenta();
		$this->namefilter = "parametersfilterarchivoestadocuenta";
		$this->route = "/administracion/archivoestadocuenta";
		$this->namepages = "pages_archivoestadocuenta";
		$this->namepageactual = "page_actual_archivoestadocuenta";
		$this->_view->route = $this->route;
		if (Session::getInstance()->get($this->namepages)) {
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
	 * Recibe la informacion y  muestra un listado de  Archivo de estado de cuenta con sus respectivos filtros.
	 *
	 * @return void.
	 */
	public function indexAction()
	{
		$title = "Aministración de Archivo de estado de cuenta";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters = (object)Session::getInstance()->get($this->namefilter);
		$this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
		$list = $this->mainModel->getList($filters, $order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
			$page = Session::getInstance()->get($this->namepageactual);
			$start = ($page - 1) * $amount;
		} else if (!$page) {
			$start = 0;
			$page = 1;
			Session::getInstance()->set($this->namepageactual, $page);
		} else {
			Session::getInstance()->set($this->namepageactual, $page);
			$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list) / $amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPages($filters, $order, $start, $amount);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->meses = $this->listMeses();
		$informacionModel = new Administracion_Model_DbTable_Informacion();
		$informacion = $informacionModel->getById(1);
		$this->_view->mes_estado_cuenta = $informacion->info_pagina_mes;
	}

	/**
	 * Genera la Informacion necesaria para editar o crear un  Archivo de estado de cuenta  y muestra su formulario
	 *
	 * @return void.
	 */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_archivoestadocuenta_" . date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if ($content->estadocuenta_archivo_id) {
				$title = "Actualizar Archivo de estado de cuenta";
				if ($id === '1') {
					$title = "Actualizar información básica";
				}
				if ($id === '2') {
					$title = "Actualizar ahorros y aportes";
				}
				if ($id === '3') {
					$title = "Actualizar cartera";
				}
				$this->_view->content = $content;
				$this->_view->routeform = $this->route . "/update";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			} else {
				$this->_view->routeform = $this->route . "/insert";
				$title = "Crear Archivo de estado de cuenta";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route . "/insert";
			$title = "Crear Archivo de estado de cuenta";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
	 * Inserta la informacion de un Archivo de estado de cuenta  y redirecciona al listado de Archivo de estado de cuenta.
	 *
	 * @return void.
	 */
	public function insertAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$data = $this->getData();
			$uploadDocument =  new Core_Model_Upload_Document();
			if ($_FILES['estadocuenta_archivo_documento']['name'] != '') {
				$data['estadocuenta_archivo_documento'] = $uploadDocument->upload("estadocuenta_archivo_documento");
			}
			$id = $this->mainModel->insert($data);

			$data['estadocuenta_archivo_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'CREAR ARCHIVO DE ESTADO DE CUENTA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: ' . $this->route . '' . '');
	}

	/**
	 * Recibe un identificador  y Actualiza la informacion de un Archivo de estado de cuenta  y redirecciona al listado de Archivo de estado de cuenta.
	 *
	 * @return void.
	 */
	public function updateAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->estadocuenta_archivo_id) {
				$data = $this->getData();
				$uploadDocument =  new Core_Model_Upload_Document();
				if ($_FILES['estadocuenta_archivo_documento']['name'] != '') {
					if ($content->estadocuenta_archivo_documento) {
						$uploadDocument->delete($content->estadocuenta_archivo_documento);
					}
					$data['estadocuenta_archivo_documento'] = $uploadDocument->upload("estadocuenta_archivo_documento");
				} else {
					$data['estadocuenta_archivo_documento'] = $content->estadocuenta_archivo_documento;
				}
				$this->mainModel->update($data, $id);
			}
			$data['estadocuenta_archivo_id'] = $id;
			$data['log_log'] = print_r($data, true);
			$data['log_tipo'] = 'EDITAR ARCHIVO DE ESTADO DE CUENTA';
			if ($id === '1') {
				$data['log_tipo'] = 'EDITAR ARCHIVO DE ESTADO DE CUENTA INFORMACION BASICA';
			}
			if ($id === '2') {
				$data['log_tipo'] = 'EDITAR ARCHIVO DE ESTADO DE CUENTA DE AHORROS Y APORTES';
			}
			if ($id === '3') {
				$data['log_tipo'] = 'EDITAR ARCHIVO DE ESTADO DE CUENTA DE CARTERA';
			}

			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		// header('Location: '.$this->route.''.'');
		if ($id === '1') {
			header('Location: ' . $this->route . '/cargarinfobasica' . '');
		} else if ($id === '2') {
			header('Location: ' . $this->route . '/cargarahorrosyaportes' . '');
		} else if ($id === '3') {
			header('Location: ' . $this->route . '/cargarcartera' . '');
		} else {
			header('Location: ' . $this->route . '' . '');
		}
	}

	/**
	 * Recibe un identificador  y elimina un Archivo de estado de cuenta  y redirecciona al listado de Archivo de estado de cuenta.
	 *
	 * @return void.
	 */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$uploadDocument =  new Core_Model_Upload_Document();
					if (isset($content->estadocuenta_archivo_documento) && $content->estadocuenta_archivo_documento != '') {
						$uploadDocument->delete($content->estadocuenta_archivo_documento);
					}
					$this->mainModel->deleteRegister($id);
					$data = (array)$content;
					$data['log_log'] = print_r($data, true);
					$data['log_tipo'] = 'BORRAR ARCHIVO DE ESTADO DE CUENTA';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data);
				}
			}
		}
		header('Location: ' . $this->route . '' . '');
	}


	public function updatemesAction()
	{

		$this->setLayout('blanco');

		$mes = $this->_getSanitizedParam("mes");

		$infobasicaModel = new Administracion_Model_DbTable_Informacion();
		$infobasicaModel->editField(1, "info_pagina_mes", $mes);
	}
	public function cargarinfobasicaAction()
	{
		ini_set("memory_limit", "-1");
		ini_set('max_execution_time', 30000);

		$this->setLayout('blanco');
		$informacionBasicaModel = new Administracion_Model_DbTable_Informacionbasica();
		$archivo = $this->mainModel->getById(1);
		$inputFileName = FILE_PATH . $archivo->estadocuenta_archivo_documento;
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);


		// $informacionBasicaModel->deleteAll();

		$infoexel = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		echo count($infoexel);
		for ($i = 2; $i < count($infoexel); $i++) {

			$fila = $infoexel[$i];
			
		
			if ($fila["A"] !== '' || (int)$fila["A"] >1) {

				//echo "cedula: ". $i ."-" . $fila["A"] . "<br>";

				$usuario = $informacionBasicaModel->getList('estadocuenta_informacionbasica_cedula = ' . $fila["A"] . ' ', "")[0];
				if (!$usuario) {

					$data['estadocuenta_informacionbasica_nombre'] = $fila['C'];
					$data['estadocuenta_informacionbasica_cedula'] = $fila['A'];
					$data['estadocuenta_informacionbasica_codigo'] = $fila['B'];
					$data['estadocuenta_informacionbasica_fechaafiliacion'] = $fila['D'];
					$data['estadocuenta_informacionbasica_empresa'] = $fila['E'];

					$data['estadocuenta_informacionbasica_salario'] = $fila['F'];
					$data['estadocuenta_informacionbasica_direccion'] = $fila['G'];
					$data['estadocuenta_informacionbasica_fechaempresa'] = $fila['H'];
					$data['estadocuenta_informacionbasica_celular'] = $fila['I'];

					$data['estadocuenta_informacionbasica_correo'] = $fila['J'];

					if ($data['estadocuenta_informacionbasica_nombre'] != '' && $data['estadocuenta_informacionbasica_cedula'] != '' && ($data['estadocuenta_informacionbasica_codigo'] != '')) {
						$insert_id = $informacionBasicaModel->insert($data);
					}
				} else {

					if ($usuario->estadocuenta_informacionbasica_nombre != $fila['C']) {
						$informacionBasicaModel->editField($usuario->estadocuenta_informacionbasica_id, "estadocuenta_informacionbasica_nombre", $fila['C']);
					}
					if ($usuario->estadocuenta_informacionbasica_codigo != $fila['B']) {
						$informacionBasicaModel->editField($usuario->estadocuenta_informacionbasica_id, "estadocuenta_informacionbasica_codigo", $fila['B']);
					}
					if ($usuario->estadocuenta_informacionbasica_fechaafiliacion != $fila['D']) {
						$informacionBasicaModel->editField($usuario->estadocuenta_informacionbasica_id, "estadocuenta_informacionbasica_fechaafiliacion", $fila['D']);
					}
					if ($usuario->estadocuenta_informacionbasica_empresa != $fila['E']) {
						$informacionBasicaModel->editField($usuario->estadocuenta_informacionbasica_id, "estadocuenta_informacionbasica_empresa", $fila['E']);
					}
					if ($usuario->estadocuenta_informacionbasica_salario != $fila['F']) {
						$informacionBasicaModel->editField($usuario->estadocuenta_informacionbasica_id, "estadocuenta_informacionbasica_salario", $fila['F']);
					}
					if ($usuario->estadocuenta_informacionbasica_direccion != $fila['G']) {
						$informacionBasicaModel->editField($usuario->estadocuenta_informacionbasica_id, "estadocuenta_informacionbasica_direccion", $fila['G']);
					}
					if ($usuario->estadocuenta_informacionbasica_fechaempresa != $fila['H']) {
						$informacionBasicaModel->editField($usuario->estadocuenta_informacionbasica_id, "estadocuenta_informacionbasica_fechaempresa", $fila['H']);
					}
					if ($usuario->estadocuenta_informacionbasica_celular != $fila['I']) {
						$informacionBasicaModel->editField($usuario->estadocuenta_informacionbasica_id, "estadocuenta_informacionbasica_celular", $fila['I']);
					}
					if ($usuario->estadocuenta_informacionbasica_correo != $fila['J']) {
						$informacionBasicaModel->editField($usuario->estadocuenta_informacionbasica_id, "estadocuenta_informacionbasica_correo", $fila['J']);
					}
				}
			}
		}
		if ($insert_id) {
			header('Location: /administracion/archivoestadocuenta?status=ok');
		} else {
			header('Location: /administracion/archivoestadocuenta?status=error');
		}
	}
	/* 
	
	public function cargarahorrosyaportesOLDAction()
	{
		ini_set("memory_limit", "-1");
		ini_set('max_execution_time', 30000);

		$this->setLayout('blanco');
		$ahorrosAportesModel = new Administracion_Model_DbTable_Ahorrosyaportes();
		$archivo = $this->mainModel->getById(2);
		$inputFileName = FILE_PATH . $archivo->estadocuenta_archivo_documento;
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);


		$ahorrosAportesModel->deleteAll();

		$infoexel = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		for ($i = 2; $i <= count($infoexel); $i++) {

			$fila = $infoexel[$i];

			$data['estadocuenta_ahorrosyaportes_numeroasociado'] = $fila['A'];
			$data['estadocuenta_ahorrosyaportes_nombre'] = $fila['B'];
			$data['estadocuenta_ahorrosyaportes_cedula'] = $fila['C'];
			$data['estadocuenta_ahorrosyaportes_fechaingreso'] = $fila['D'];
			$data['estadocuenta_ahorrosyaportes_direcciondomicilio'] = $fila['E'];
			$data['estadocuenta_ahorrosyaportes_fecharetiro'] = $fila['F'];
			$data['estadocuenta_ahorrosyaportes_cuotaaporte'] = $fila['G'];
			$data['estadocuenta_ahorrosyaportes_cuotaahorro'] = $fila['H'];
			$data['estadocuenta_ahorrosyaportes_saldoaportes'] = $fila['I'];
			$data['estadocuenta_ahorrosyaportes_saldoahorros'] = $fila['J'];
			$data['estadocuenta_ahorrosyaportes_email'] = $fila['K'];
			if ($data['estadocuenta_ahorrosyaportes_numeroasociado'] != '' && $data['estadocuenta_ahorrosyaportes_cedula'] != '' && ($data['estadocuenta_ahorrosyaportes_nombre'] != '' && $data['estadocuenta_ahorrosyaportes_nombre'] != 'FALSO')) {
				$insert_id = $ahorrosAportesModel->insert($data);
			}
		}
		if ($insert_id) {
			header('Location: /administracion/archivoestadocuenta?status=ok');
		} else {
			header('Location: /administracion/archivoestadocuenta?status=error');
		}
	} */
	public function cargarahorrosyaportesAction()
	{
		ini_set("memory_limit", "-1");
		ini_set('max_execution_time', 30000);

		$this->setLayout('blanco');
		$aportesModel = new Administracion_Model_DbTable_Aportes();
		$archivo = $this->mainModel->getById(2);
		$inputFileName = FILE_PATH . $archivo->estadocuenta_archivo_documento;
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);


		$aportesModel->deleteAll();

		$infoexel = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		for ($i = 2; $i <= count($infoexel); $i++) {

			$fila = $infoexel[$i];

			$data['estadocuenta_aportes_documento'] = $fila['A'];
			$data['estadocuenta_aportes_tipo'] = $fila['B'];
			$data['estadocuenta_aportes_saldo'] = $fila['C'];
			$data['estadocuenta_aportes_cuota'] = $fila['D'];
			$data['estadocuenta_aportes_periodicidad'] = $fila['E'];
			$data['estadocuenta_aportes_ultimoabono'] = $fila['F'];

			if ($data['estadocuenta_aportes_documento'] != '' && $data['estadocuenta_aportes_tipo'] != '' && ($data['estadocuenta_aportes_saldo'] != '')) {
				$insert_id = $aportesModel->insert($data);
			}
		}
		if ($insert_id) {
			header('Location: /administracion/archivoestadocuenta?status=ok');
		} else {
			header('Location: /administracion/archivoestadocuenta?status=error');
		}
	}


	public function cargarcarteraAction()
	{
		ini_set("memory_limit", "-1");
		ini_set('max_execution_time', 30000);

		$this->setLayout('blanco');
		$carteraModel = new Administracion_Model_DbTable_Cartera();
		$archivo = $this->mainModel->getById(3);
		$inputFileName = FILE_PATH . $archivo->estadocuenta_archivo_documento;
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);


		$carteraModel->deleteAll();

		$infoexel = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		for ($i = 2; $i <= count($infoexel); $i++) {

			$fila = $infoexel[$i];
			$data['estadocuenta_cartera_documento'] = $fila['A'];
			$data['estadocuenta_cartera_numero'] = $fila['B'];
			$data['estadocuenta_cartera_linea'] = $fila['C'];
			$data['estadocuenta_cartera_fechadesembolso'] = $fila['D'];
			$data['estadocuenta_cartera_cuota'] = $fila['E'];
			$data['estadocuenta_cartera_ultimoabono'] = $fila['F'];

			$data['estadocuenta_cartera_valorprestamo'] = $fila['G'];
			$data['estadocuenta_cartera_totalcuotas'] = $fila['H'];
			$data['estadocuenta_cartera_cuotaspagas'] = $fila['I'];
			$data['estadocuenta_cartera_saldocapital'] = $fila['J'];
			$data['estadocuenta_cartera_interesescorrientes'] = $fila['K'];
			$data['estadocuenta_cartera_saldototal'] = $fila['L'];


			if ($data['estadocuenta_cartera_documento'] != '' && $data['estadocuenta_cartera_numero'] != '' && ($data['estadocuenta_cartera_linea'] != '')) {
				$insert_id = $carteraModel->insert($data);
			}
		}
		if ($insert_id) {
			header('Location: /administracion/archivoestadocuenta?status=ok');
		} else {
			header('Location: /administracion/archivoestadocuenta?status=error');
		}
	}




	/**
	 * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Archivoestadocuenta.
	 *
	 * @return array con toda la informacion recibida del formulario.
	 */
	private function getData()
	{
		$data = array();
		$data['estadocuenta_archivo_nombre'] = $this->_getSanitizedParam("estadocuenta_archivo_nombre");
		$data['estadocuenta_archivo_fecha'] = $this->_getSanitizedParam("estadocuenta_archivo_fecha");
		$data['estadocuenta_archivo_documento'] = "";
		return $data;
	}
	/**
	 * Genera la consulta con los filtros de este controlador.
	 *
	 * @return array cadena con los filtros que se van a asignar a la base de datos
	 */
	protected function getFilter()
	{
		$filtros = " 1 = 1 ";
		$filtros = $filtros . " AND (estadocuenta_archivo_id = '1' OR estadocuenta_archivo_id = '2' OR estadocuenta_archivo_id = '3') ";

		if (Session::getInstance()->get($this->namefilter) != "") {
			$filters = (object)Session::getInstance()->get($this->namefilter);
			if ($filters->estadocuenta_archivo_nombre != '') {
				$filtros = $filtros . " AND estadocuenta_archivo_nombre LIKE '%" . $filters->estadocuenta_archivo_nombre . "%'";
			}
			if ($filters->estadocuenta_archivo_fecha != '') {
				$filtros = $filtros . " AND estadocuenta_archivo_fecha LIKE '%" . $filters->estadocuenta_archivo_fecha . "%'";
			}
			if ($filters->estadocuenta_archivo_documento != '') {
				$filtros = $filtros . " AND estadocuenta_archivo_documento LIKE '%" . $filters->estadocuenta_archivo_documento . "%'";
			}
		}
		return $filtros;
	}

	/**
	 * Recibe y asigna los filtros de este controlador
	 *
	 * @return void
	 */
	protected function filters()
	{
		if ($this->getRequest()->isPost() == true) {
			Session::getInstance()->set($this->namepageactual, 1);
			$parramsfilter = array();
			$parramsfilter['estadocuenta_archivo_nombre'] =  $this->_getSanitizedParam("estadocuenta_archivo_nombre");
			$parramsfilter['estadocuenta_archivo_fecha'] =  $this->_getSanitizedParam("estadocuenta_archivo_fecha");
			$parramsfilter['estadocuenta_archivo_documento'] =  $this->_getSanitizedParam("estadocuenta_archivo_documento");
			Session::getInstance()->set($this->namefilter, $parramsfilter);
		}
		if ($this->_getSanitizedParam("cleanfilter") == 1) {
			Session::getInstance()->set($this->namefilter, '');
			Session::getInstance()->set($this->namepageactual, 1);
		}
	}

	public function listMeses()
	{
		$meses = [
			"01" => "ENERO",
			"02" => "FEBRERO",
			"03" => "MARZO",
			"04" => "ABRIL",
			"05" => "MAYO",
			"06" => "JUNIO",
			"07" => "JULIO",
			"08" => "AGOSTO",
			"09" => "SEPTIEMBRE",
			"10" => "OCTUBRE",
			"11" => "NOVIEMBRE",
			"12" => "DICIEMBRE"
		];

		return $meses;
	}
}
