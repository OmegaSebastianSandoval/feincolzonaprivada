<div class="container d-flex justify-content-center">
    <form class="form" action="/page/login/login" autocomplete="off" id="form-login" method="post">
        <span class="title">Inicio de sesi&oacute;n FEMEN</span>
        <span class="sub mb">Bienvenido asociado</span>

        <img src="/corte/Logo-Header.png" alt="Logo FEINCOL" class="logo-formulario">

        <input type="text" class="input" name="cedula" id="cedula" required autocomplete="off" placeholder="Ingrese su c&eacute;dula">
        <input type="password" name="clave" autocomplete="off" class="input" required placeholder="Ingrese su clave">

        <!-- <input type="email" class="input" placeholder="email">
        <input type="password" class="input" placeholder="password"> -->
        <span class="sub">¿Aún no está registrado? <a href="/page/index/registro">Registrese aqu&iacute;</a></span>
        <span class="sub">¿Olvidó su contraseña? <a href="/page/index/recuperacion">Recupérela aqu&iacute;</a></span>

        <div class="g-recaptcha mt-3 d-flex justify-content-center" data-sitekey="6LfFDZskAAAAAE2HmM7Z16hOOToYIWZC_31E61Sr"></div>

        <button>Iniciar sesi&oacute;n</button>
    </form>

</div>
<style>
    body {
        height: 100dvh
    }

    body.swal2-height-auto {
        height: 100vh !important;

    }

    header {
        display: none;
    }

    .main-general {
        display: grid;
    }
</style>