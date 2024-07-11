<?php
/**
* Controlador de Informacionbasica que permite la  creacion, edicion  y eliminacion de los informaci&oacute;n b&aacute;sica del Sistema
*/
class Administracion_informacionbasicaController extends Administracion_mainController
{
	/**
	 * $mainModel  instancia del modelo de  base de datos informaci&oacute;n b&aacute;sica
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
	protected $pages ;

	/**
	 * $namefilter nombre de la variable a la fual se le van a guardar los filtros
	 * @var string
	 */
	protected $namefilter;

	/**
	 * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
	 * @var string
	 */
	protected $_csrf_section = "administracion_informacionbasica";

	/**
	 * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
	 * @var string
	 */
	protected $namepages;



	/**
     * Inicializa las variables principales del controlador informacionbasica .
     *
     * @return void.
     */
	public function init()
	{
		$this->mainModel = new Administracion_Model_DbTable_Informacionbasica();
		$this->namefilter = "parametersfilterinformacionbasica";
		$this->route = "/administracion/informacionbasica";
		$this->namepages ="pages_informacionbasica";
		$this->namepageactual ="page_actual_informacionbasica";
		$this->_view->route = $this->route;
		if(Session::getInstance()->get($this->namepages)){
			$this->pages = Session::getInstance()->get($this->namepages);
		} else {
			$this->pages = 20;
		}
		parent::init();
	}


	/**
     * Recibe la informacion y  muestra un listado de  informaci&oacute;n b&aacute;sica con sus respectivos filtros.
     *
     * @return void.
     */
	public function indexAction()
	{
		$title = "Aministración de informaci&oacute;n b&aacute;sica";
		$this->getLayout()->setTitle($title);
		$this->_view->titlesection = $title;
		$this->filters();
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
		$filters = $this->getFilter();
		$order = "";
		$list = $this->mainModel->getList($filters,$order);
		$amount = $this->pages;
		$page = $this->_getSanitizedParam("page");
		if (!$page && Session::getInstance()->get($this->namepageactual)) {
		   	$page = Session::getInstance()->get($this->namepageactual);
		   	$start = ($page - 1) * $amount;
		} else if(!$page){
			$start = 0;
		   	$page=1;
			Session::getInstance()->set($this->namepageactual,$page);
		} else {
			Session::getInstance()->set($this->namepageactual,$page);
		   	$start = ($page - 1) * $amount;
		}
		$this->_view->register_number = count($list);
		$this->_view->pages = $this->pages;
		$this->_view->totalpages = ceil(count($list)/$amount);
		$this->_view->page = $page;
		$this->_view->lists = $this->mainModel->getListPages($filters,$order,$start,$amount);
		$this->_view->csrf_section = $this->_csrf_section;
	}

	/**
     * Genera la Informacion necesaria para editar o crear un  informaci&oacute;n b&aacute;sica  y muestra su formulario
     *
     * @return void.
     */
	public function manageAction()
	{
		$this->_view->route = $this->route;
		$this->_csrf_section = "manage_informacionbasica_".date("YmdHis");
		$this->_csrf->generateCode($this->_csrf_section);
		$this->_view->csrf_section = $this->_csrf_section;
		$this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
		$id = $this->_getSanitizedParam("id");
		if ($id > 0) {
			$content = $this->mainModel->getById($id);
			if($content->estadocuenta_informacionbasica_id){
				$this->_view->content = $content;
				$this->_view->routeform = $this->route."/update";
				$title = "Actualizar informaci&oacute;n b&aacute;sica";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}else{
				$this->_view->routeform = $this->route."/insert";
				$title = "Crear informaci&oacute;n b&aacute;sica";
				$this->getLayout()->setTitle($title);
				$this->_view->titlesection = $title;
			}
		} else {
			$this->_view->routeform = $this->route."/insert";
			$title = "Crear informaci&oacute;n b&aacute;sica";
			$this->getLayout()->setTitle($title);
			$this->_view->titlesection = $title;
		}
	}

	/**
     * Inserta la informacion de un informaci&oacute;n b&aacute;sica  y redirecciona al listado de informaci&oacute;n b&aacute;sica.
     *
     * @return void.
     */
	public function insertAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {	
			$data = $this->getData();
			$id = $this->mainModel->insert($data);
			
			$data['estadocuenta_informacionbasica_id']= $id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'CREAR INFORMACI&OACUTE;N B&AACUTE;SICA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y Actualiza la informacion de un informaci&oacute;n b&aacute;sica  y redirecciona al listado de informaci&oacute;n b&aacute;sica.
     *
     * @return void.
     */
	public function updateAction(){
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_getSanitizedParam("csrf_section")] == $csrf ) {
			$id = $this->_getSanitizedParam("id");
			$content = $this->mainModel->getById($id);
			if ($content->estadocuenta_informacionbasica_id) {
				$data = $this->getData();
					$this->mainModel->update($data,$id);
			}
			$data['estadocuenta_informacionbasica_id']=$id;
			$data['log_log'] = print_r($data,true);
			$data['log_tipo'] = 'EDITAR INFORMACI&OACUTE;N B&AACUTE;SICA';
			$logModel = new Administracion_Model_DbTable_Log();
			$logModel->insert($data);}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe un identificador  y elimina un informaci&oacute;n b&aacute;sica  y redirecciona al listado de informaci&oacute;n b&aacute;sica.
     *
     * @return void.
     */
	public function deleteAction()
	{
		$this->setLayout('blanco');
		$csrf = $this->_getSanitizedParam("csrf");
		if (Session::getInstance()->get('csrf')[$this->_csrf_section] == $csrf ) {
			$id =  $this->_getSanitizedParam("id");
			if (isset($id) && $id > 0) {
				$content = $this->mainModel->getById($id);
				if (isset($content)) {
					$this->mainModel->deleteRegister($id);$data = (array)$content;
					$data['log_log'] = print_r($data,true);
					$data['log_tipo'] = 'BORRAR INFORMACI&OACUTE;N B&AACUTE;SICA';
					$logModel = new Administracion_Model_DbTable_Log();
					$logModel->insert($data); }
			}
		}
		header('Location: '.$this->route.''.'');
	}

	/**
     * Recibe la informacion del formulario y la retorna en forma de array para la edicion y creacion de Informacionbasica.
     *
     * @return array con toda la informacion recibida del formulario.
     */
	private function getData()
	{
		$data = array();
		$data['estadocuenta_informacionbasica_nombre'] = $this->_getSanitizedParam("estadocuenta_informacionbasica_nombre");
		$data['estadocuenta_informacionbasica_cedula'] = $this->_getSanitizedParam("estadocuenta_informacionbasica_cedula");
		$data['estadocuenta_informacionbasica_codigo'] = $this->_getSanitizedParam("estadocuenta_informacionbasica_codigo");
		$data['estadocuenta_informacionbasica_fechaafiliacion'] = $this->_getSanitizedParam("estadocuenta_informacionbasica_fechaafiliacion");
		$data['estadocuenta_informacionbasica_empresa'] = $this->_getSanitizedParam("estadocuenta_informacionbasica_empresa");
		$data['estadocuenta_informacionbasica_correo'] = $this->_getSanitizedParam("estadocuenta_informacionbasica_correo");
		$data['estadocuenta_informacionbasica_clave'] = $this->_getSanitizedParam("estadocuenta_informacionbasica_clave");
		$data['estadocuenta_informacionbasica_token'] = $this->_getSanitizedParam("estadocuenta_informacionbasica_token");
		$data['estadocuenta_informacionbasica_tokendate'] = $this->_getSanitizedParam("estadocuenta_informacionbasica_tokendate");
		if($this->_getSanitizedParam("estadocuenta_informacionbasica_activo") == '' ) {
			$data['estadocuenta_informacionbasica_activo'] = '0';
		} else {
			$data['estadocuenta_informacionbasica_activo'] = $this->_getSanitizedParam("estadocuenta_informacionbasica_activo");
		}
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
        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->estadocuenta_informacionbasica_nombre != '') {
                $filtros = $filtros." AND estadocuenta_informacionbasica_nombre LIKE '%".$filters->estadocuenta_informacionbasica_nombre."%'";
            }
            if ($filters->estadocuenta_informacionbasica_cedula != '') {
                $filtros = $filtros." AND estadocuenta_informacionbasica_cedula LIKE '%".$filters->estadocuenta_informacionbasica_cedula."%'";
            }
            if ($filters->estadocuenta_informacionbasica_codigo != '') {
                $filtros = $filtros." AND estadocuenta_informacionbasica_codigo LIKE '%".$filters->estadocuenta_informacionbasica_codigo."%'";
            }
            if ($filters->estadocuenta_informacionbasica_fechaafiliacion != '') {
                $filtros = $filtros." AND estadocuenta_informacionbasica_fechaafiliacion LIKE '%".$filters->estadocuenta_informacionbasica_fechaafiliacion."%'";
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
        if ($this->getRequest()->isPost()== true) {
        	Session::getInstance()->set($this->namepageactual,1);
            $parramsfilter = array();
					$parramsfilter['estadocuenta_informacionbasica_nombre'] =  $this->_getSanitizedParam("estadocuenta_informacionbasica_nombre");
					$parramsfilter['estadocuenta_informacionbasica_cedula'] =  $this->_getSanitizedParam("estadocuenta_informacionbasica_cedula");
					$parramsfilter['estadocuenta_informacionbasica_codigo'] =  $this->_getSanitizedParam("estadocuenta_informacionbasica_codigo");
					$parramsfilter['estadocuenta_informacionbasica_fechaafiliacion'] =  $this->_getSanitizedParam("estadocuenta_informacionbasica_fechaafiliacion");Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }
}