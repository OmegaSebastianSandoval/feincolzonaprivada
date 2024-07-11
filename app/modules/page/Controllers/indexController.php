<?php

/**
 *
 */

class Page_indexController extends Page_mainController
{

  public function init()
  {
    //si no existe un usuario activo llevar al paso 1
    if (Session::getInstance()->get('user')) {
      header("Location: /page/home");
    }
    parent::init();
  }
  public function indexAction()
  {
    $this->_view->banner = $this->template->banner("1");
    $this->_view->contenido = $this->template->getContentseccion("1");
  }
  public function registroAction()
  {
  }

  public function inicarregistroAction()
  {

    // Obtener el parámetro cédula del formulario y sanearlo
    $cedula = $this->_getSanitizedParam('cedula');

    // Crear una instancia del modelo de usuarios
    $usersModel = new Administracion_Model_DbTable_Informacionbasica();

    // Obtener información del usuario por su cédula
    $user = $usersModel->getList("estadocuenta_informacionbasica_cedula = '$cedula'", "")[0];

    // Si no se encuentra ningún usuario con esa cédula
    if (!$user) {
      $response = [
        'status' => 'error',
        'message' => 'No se ha encontrado ningún usuario con esa cédula'
      ];
      // Devolver la respuesta como JSON y finalizar el script
      die(json_encode($response));
    }

    // Si el usuario ya está activo
    if ($user->estadocuenta_informacionbasica_activo == 1) {
      $response = [
        'status' => 'error',
        'message' => 'El usuario ya se encuentra activo'
      ];
      // Devolver la respuesta como JSON y finalizar el script
      die(json_encode($response));
    }

    // Ocultar parte del correo electrónico por motivos de seguridad
    $email = $user->estadocuenta_informacionbasica_correo;
    $email = explode('@', $email);
    $email[0] = substr($email[0], 0, 5) . '***';
    $email = implode('@', $email);

    // Generar un token único y una fecha de token
    $token = md5(uniqid(rand(), true));
    $token_date = date('Y-m-d H:i:s');

    // Crear una instancia del modelo de envío de correo electrónico
    $mailModel = new Core_Model_Sendingemail($this->_view);

    // Enviar correo de recuperación y almacenar el resultado
    $mail = $mailModel->enviarregistro($user, $token);

    // Si el correo se envió correctamente
    if ($mail == '1') {
      // Actualizar el token y la fecha de token del usuario en la base de datos
      $usersModel->editField($user->estadocuenta_informacionbasica_id, 'estadocuenta_informacionbasica_token', $token);
      $usersModel->editField($user->estadocuenta_informacionbasica_id, 'estadocuenta_informacionbasica_tokendate', $token_date);

      // Preparar la respuesta exitosa
      $response = [
        'status' => 'success',
        'message' => 'Se ha enviado un correo a ' . $email . ' con los pasos a seguir',
        'user' => $cedula,
        'email' => $email
      ];
    } else {
      // Preparar la respuesta en caso de error en el envío de correo
      $response = [
        'status' => 'errorMail',
        'message' => 'Ha ocurrido un error al enviar el correo'
      ];
    }

    // Devolver la respuesta como JSON
    die(json_encode($response));
  }

  public function registrarseAction()
  {
    // Obtener el token del parámetro de la URL y sanearlo
    $token = $this->_getSanitizedParam('t');

    // Crear una instancia del modelo de usuarios
    $usersModel = new Administracion_Model_DbTable_Informacionbasica();

    // Obtener información del usuario por su token
    $user = $usersModel->getList("estadocuenta_informacionbasica_token = '$token'", "")[0];

    // Si se encuentra un usuario con ese token
    if ($user) {
      // Convertir la fecha de token almacenada en el usuario a un objeto DateTime
      $token_date = new DateTime($user->estadocuenta_informacionbasica_tokendate);

      // Obtener la fecha y hora actual
      $now = new DateTime();

      // Calcular la diferencia de tiempo entre la fecha de token y la fecha actual
      $interval = $now->diff($token_date);

      // Si la diferencia de horas es menor que 1 hora
      if ($interval->h < 1) {
        // Configurar la vista para mostrar el formulario de registro
        $this->_view->error = false;
        $this->_view->user = $user;
      } else {
        // Configurar la vista para mostrar un error de expiración de token
        $this->_view->error = true;
      }
    } else {
      // Configurar la vista para mostrar un error si no se encuentra ningún usuario con ese token
      $this->_view->error = true;
    }
  }
  public function registrarclaveAction()
  {
    // Obtener y sanear los parámetros de contraseña
    $password = $this->_getSanitizedParam('password');
    $password2 = $this->_getSanitizedParam('password2');

    // Crear una instancia del modelo de usuarios
    $usersModel = new Administracion_Model_DbTable_Informacionbasica();

    // Obtener el ID de usuario de los parámetros de la solicitud y obtener información del usuario
    $user_id = $this->_getSanitizedParam('user_id');
    $user = $usersModel->getById($user_id);

    // Verificar si las contraseñas coinciden
    if ($password == $password2) {
      // Cambiar la contraseña del usuario y actualizar otros campos relacionados
      $usersModel->editField($user_id, 'estadocuenta_informacionbasica_clave', password_hash($password, PASSWORD_DEFAULT));
      $usersModel->editField($user_id, 'estadocuenta_informacionbasica_token', '');
      $usersModel->editField($user_id, 'estadocuenta_informacionbasica_tokendate', '');
      $usersModel->editField($user_id, 'estadocuenta_informacionbasica_activo', 1);

      // Iniciar sesión del usuario
      Session::getInstance()->set("user", $user);

      // Preparar la respuesta de éxito
      $response = [
        'status' => 'success',
        'message' => 'Contraseña cambiada correctamente'
      ];
    } else {
      // Preparar la respuesta de error si las contraseñas no coinciden
      $response = [
        'status' => 'error',
        'message' => 'Las contraseñas no coinciden'
      ];
    }

    // Devolver la respuesta como JSON
    die(json_encode($response));
  }



  public function recuperacionAction()
  {
  }

  public function recuperarAction()
  {
    // Obtener el token del parámetro de la URL y sanearlo
    $token = $this->_getSanitizedParam('t');

    // Crear una instancia del modelo de usuarios
    $usersModel = new Administracion_Model_DbTable_Informacionbasica();

    // Obtener información del usuario por su token
    $user = $usersModel->getList("estadocuenta_informacionbasica_token = '$token'", "")[0];

    // Si se encuentra un usuario con ese token
    if ($user) {
      // Convertir la fecha de token almacenada en el usuario a un objeto DateTime
      $token_date = new DateTime($user->estadocuenta_informacionbasica_tokendate);

      // Obtener la fecha y hora actual
      $now = new DateTime();

      // Calcular la diferencia de tiempo entre la fecha de token y la fecha actual
      $interval = $now->diff($token_date);

      // Si la diferencia de horas es menor que 1 hora
      if ($interval->h < 1) {
        // Configurar la vista para mostrar el formulario de registro
        $this->_view->error = false;
        $this->_view->user = $user;
      } else {
        // Configurar la vista para mostrar un error de expiración de token
        $this->_view->error = true;
      }
    } else {
      // Configurar la vista para mostrar un error si no se encuentra ningún usuario con ese token
      $this->_view->error = true;
    }
  }


  //Cerrar sesión
  public function logoutAction()
  {
    Session::getInstance()->set('user', null);

    header("Location: /");
  }
}
