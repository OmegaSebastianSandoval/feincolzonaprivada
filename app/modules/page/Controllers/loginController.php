<?php

/**
 *
 */

class Page_loginController extends Page_mainController
{

  public function indexAction()
  {
  }


  public function loginAction()
  {

    // error_reporting(E_ALL);


    // Obtener los parámetros cedula y clave del formulario y sanearlos
    $cedula = $this->_getSanitizedParam('cedula');
    $clave = $this->_getSanitizedParam('clave');
   
    $captcha = $this->_getSanitizedParam('g-recaptcha-response');

    // Arreglo para almacenar la respuesta
    $response = array();

    // Modelo de la base de datos para usuarios
    $users_model = new Administracion_Model_DbTable_Informacionbasica();
    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();


    // Obtener información del usuario por su cédula
    $user = $users_model->getList("estadocuenta_informacionbasica_cedula = '$cedula'", "")[0];
    if (!$this->verifyCaptcha($captcha)) {
      $response = [
        'status' => 'error',
        'message' => 'Captcha incorrecto'
      ];
      // Devolver la respuesta como JSON
      die(json_encode($response));
    }

    // Si se encuentra un usuario con esa cédula
    if ($user) {

      $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$cedula' or bloqueo_ip = '".$_SERVER['REMOTE_ADDR']."' ", "bloqueo_id DESC")[0];
     
      $intentos = (int)$infoBloqueo->bloqueo_intentosfallidos;
      $fechaUltimoIntento = $infoBloqueo->bloqueo_fechaintento;
      // Convertir la fecha del último intento a un objeto DateTime
      $fechaUltimoIntento = new DateTime($fechaUltimoIntento);
      // Obtener la fecha y hora actual
      $fechaActual = new DateTime();

   
      // Calcular la diferencia entre las fechas
      $diferencia = $fechaActual->getTimestamp() - $fechaUltimoIntento->getTimestamp();

      if ($intentos >= 3 && $diferencia <= 900) {
     

        $response = [
          'status' => 'bloqueado',
          'message' => 'El usuario ha sido bloqueado durante 15 minutos por más de tres intentos fallidos'
        ];
        // Devolver la respuesta como JSON
        die(json_encode($response));
      }

      // Verificar si el usuario está activo
      if ($user->estadocuenta_informacionbasica_activo != 1 && $user->estadocuenta_informacionbasica_clave == '') {
        $response = [
          'status' => 'activar',
          'message' => 'Para iniciar sesion primero tiene que registrar una contraseña'
        ];
        // Devolver la respuesta como JSON
        die(json_encode($response));
      }

      // Verificar la contraseña del usuario
      if (password_verify($clave, $user->estadocuenta_informacionbasica_clave)) {


        //borrar registros de bloqueo para iniciar desde 0 la proxima vez que se equivoque
        $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$cedula'", "bloqueo_id DESC");
        if (count($infoBloqueo) > 0) {
          foreach ($infoBloqueo as $info) {
            $bloqueosModel->deleteRegister($info->bloqueo_id);
          }
        }

        // Iniciar sesión del usuario
        Session::getInstance()->set("user", $user);
        $response = [
          'status' => 'success',
          'message' => 'Bienvenido'
        ];
        // Devolver la respuesta como JSON
        die(json_encode($response));
      } else {

        $dataBloque = array();
        $dataBloque['bloqueo_usuario'] = $cedula;
        $dataBloque['bloqueo_intentosfallidos'] = $this->getIntentos($cedula);
        $dataBloque['bloqueo_ip'] = $_SERVER['REMOTE_ADDR'] ;

        $bloqueosModel->insert($dataBloque);

        // Si no se encuentra ningún usuario con esa cédula
        $response = [
          'status' => 'error',
          'message' => 'Contraseña incorrecta'
        ];
        // Devolver la respuesta como JSON
        die(json_encode($response));
      }
    } else {
      // Si no se encuentra ningún usuario con esa cédula
      $response = [
        'status' => 'error',
        'message' => 'No se ha encontrado ningún usuario con esa cédula'
      ];
      // Devolver la respuesta como JSON
      die(json_encode($response));
    }
  }

  public function inicarrecuperacionAction()
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
    if ($user->estadocuenta_informacionbasica_activo != 1) {
      $response = [
        'status' => 'errorActivacion',
        'message' => 'El usuario aun no se encuentra activo'
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
    $mail = $mailModel->enviarrecuperacion($user, $token);

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

  public function recuperarclaveAction()
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

  private function verifyCaptcha($response)
  {
    $secretKey = '6LfFDZskAAAAAOvo1878Gv4vLz3CjacWqy08WqYP';

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
      'secret' => $secretKey,
      'response' => $response
    );

    $options = array(
      'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
      )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);

    return $response->success;
  }
  public function getIntentos($cedula)
  {
    $bloqueosModel = new Administracion_Model_DbTable_Bloqueos();

    $infoBloqueo = $bloqueosModel->getList("bloqueo_usuario = '$cedula'", "bloqueo_id DESC")[0];

    $intento = $infoBloqueo->bloqueo_intentosfallidos ?? 0;

    $intento = $intento + 1;

    // Devolver el consecutivo obtenido
    return $intento;
  }

  //Cerrar sesión
  public function logoutAction()
  {

    Session::getInstance()->set('user', null);
    Session::getInstance()->set('user', null);

    header('location: www.google.com');
    // it is probably Facebook's bot
    header("Location: /");
  }
}


/* 03AFcWeA75UsUo0Q5Fif5HCz7rdJeoaeThUqSQt5jVzKUEE5dLKdGfs1-4-PhQOSCVB2cS9fozUdfoAcqO9ELdLY281pnmLovfug695OO1G1c_idEyahyImOcMMceR1BqXjqlzNFaYzqdzCcbxnoRD4I2mhTEsdDqvHQQULXlaTKtqg0mc8AMYBKrirVnaTALsLWzUi6Bw5rCcyjNRkRBxCinu3Id__Zx18y0PTFlz3KCJef9Qvfsk3QKDFKb8ek6g3p0AJLBjdyVcklaSpP_EbpJ7mFK4r9jg4re3nlTnF8FS94iQX37PCWnCYZqGmnu81EcqeplCl3olgquenD_YhSHbTkHNpZYF2_iaBeYLAd5ptPQLmReudvhOAqIRS5kB4X1lTEy72b51FPNsTwYDgB8s-4kPHr-fZci7RB7KyQ3EmGWPuUf7Kx0crh6rVhZMw9uxNbs9UnkcrIXMDaUmXpWKqY9WuiXqyrxUz7SMY49-WEyqaizmQRCmYixMnMP5kiZEpM6l3CM4SSLiLV3eWGkitbCPBM8K661Admhnjb5xridW91IxFjTG4oSg9PHZh6mBt0E2q2gbhg-eT4OqxGHU5b0z2EP0T0NmEW8SOrC8DazPWHrAmdc */

/* 03AFcWeA4RsdZg4d7m1e46gWyx70Znc57ERaw2P7SA5Kw793uawRzpOXTHCuHxM-64Qr4W7Rl0-vfzbFZdJ83xxEQSAvY33Nj47CkYz-qKIdAEaISCtFu5RTCinpw2MOkhrUI9cFM0iI7dddGu9dzg5HtIOwuAZtexCSFCjpDztfAxUA5QU2rzccZtHJCGaNkmiDazPy-NRGztFUZnDmhRw-jxq0l2FNe4-lngC7FiKndtIjvv1pRfPJ7sYwk9ch63DQMWD5kH0tk4hKN6DsPSAfR8HIoZ2vjEdpuQkHvOgPfOsUeJbVUFnKYEPqdKWiwf2ngjg85ACWzv77keVbSkBAng-DQ7_ZgQzpw7it-T7HMND8FpR9DAvBgbSBSYAIuvQx81N6Gp6B-54Yo1xHaMbU_ktlae_T_EY7V0Ry_wP_vc2lGHvEdSRn6jPP9C6nOHN5gT3kafhPQdPtz0a5LmKACrY-rXxB6Esmi2HBciQDLPYCodUcYQThl1cgJCCitCTaPtQXIxlvSkmNk-N7rUKoafxBRIwtRYXMEkcPgf4J2a29OepI0vaoXYm6zUIMpKrFhiPVasZZzSLL23Ih5y3yeIQ3lC3kRgLSpA8sKmPSXEAyJKFk1ioSnGsr5I_hjqc2g-a6JvGWeb5hW3DuTz60tB5UL8Dltah9RJGo4smv7WNz2g8pxIkNjoWfOkPaTAJV2sBeOg5z1I */
