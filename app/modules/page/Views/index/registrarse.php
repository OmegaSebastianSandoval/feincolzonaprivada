<div class="container d-grid justify-content-center pb-5 mt-5">
  <section class="shadow p-5 ">

    <h3 class="login-title" style="font-size: 2.4rem;">Registra tu contraseña</h3>
    <p class="login-par text-center">

      <!-- Si tu token es válido, ingresa tu nueva contraseña. -->
      Ingresa tu nueva contraseña.

    </p>
    <img src="/corte/Logo-Header.png" alt="Logo FEINCOL" class="logo-formulario">

    <?php if ($this->error) { ?>
      <div class="alert alert-danger" role="alert">
        <strong>Token no valido.</strong> Tu token ha expirado o no es valido, por favor solicita uno nuevo.
      </div>
    <?php } else { ?>
      <form class="form" action="/page/index/registrarclave" id="form-resgistroclave" method="post">

        <input type="hidden" value="<?php echo $this->user->estadocuenta_informacionbasica_id  ?>" name="user_id">
        <input type="password" class="input mb-3" name="password" id="client-password" placeholder="Contraseña" required>
        <input type="password" class="input mb-3" id="client-password2" name="password2" placeholder="Repite tu contraseña" required>

        <div class="col-12 my-2 alert-contrasenia" id="alert-contrasenia2">
          <div class="alert alert-danger" role="alert">
            Las contraseñas no son iguales.
          </div>
        </div>
        <div class="col-12 my-2 alert-contrasenia" id="alert-contrasenia">
          <div class="alert alert-danger text-start" role="alert">
            La contraseña debe incluir al menos
            <ul class="pl-4">
              <li>8 caracteres</li>
              <li>Una minuscula</li>
              <li>Una Mayuscula</li>
              <li>Un Numero</li>
            </ul>
          </div>
        </div>
        <button type="submit">Cambiar</button>

      </form>
    <?php } ?>

  </section>


</div>

<style>
  body {
    height: 100dvh;
    /* padding: 50px 0 0 0; */
  }

  body.swal2-height-auto {
    height: 100vh !important;

  }

  header {
    display: none;
  }

  .main-general {
    /* min-height: auto; */
    /* display: grid;
    align-items: center; */
  }

  .form {

    gap: 1px;
  }

  .alert-contrasenia {
    display: none;
  }

  footer {
    position: relative;
  }
</style>

<script>
  $(document).ready(function() {
    $("#client-password").on("keyup", function() {
      validar_clave($(this).val());
      comparar_claves();
    });
    $("#client-password2").on("keyup", function() {
      comparar_claves();
    });

    function comparar_claves() {
      let clave = $("#client-password").val(),
        clave2 = $("#client-password2").val();
      if (clave == clave2) {
        $("#alert-contrasenia2").hide();
      } else {
        $("#alert-contrasenia2").show();
      }
    }

    function validar_clave(contrasenna) {
      var mayuscula = false;
      var minuscula = false;
      var numero = false;
      var count = false;

      for (var i = 0; i < contrasenna.length; i++) {
        if (contrasenna.charCodeAt(i) >= 65 && contrasenna.charCodeAt(i) <= 90) {
          mayuscula = true;
        } else if (
          contrasenna.charCodeAt(i) >= 97 &&
          contrasenna.charCodeAt(i) <= 122
        ) {
          minuscula = true;
        } else if (
          contrasenna.charCodeAt(i) >= 48 &&
          contrasenna.charCodeAt(i) <= 57
        ) {
          numero = true;
        }
      }
      if (mayuscula == true && minuscula == true && numero == true) {
        if (contrasenna.length > 8) {
          $("#alert-contrasenia").hide();
        } else {
          $("#alert-contrasenia").show();
        }
      } else {
        $("#alert-contrasenia").show();
      }
    }
  });
</script>