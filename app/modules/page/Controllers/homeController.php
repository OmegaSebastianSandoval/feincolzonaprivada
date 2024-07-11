<?php

/**
 *
 */

class Page_homeController extends Page_mainController
{

  public function init()
  {
    //si no existe un usuario activo llevar al paso 1
    if (!Session::getInstance()->get('user')) {
      header("Location: /");
    }
    parent::init();
  }
  public function indexAction()
  {
    $this->_view->contenido =  $this->template->getContentseccion(1);
  }
}
