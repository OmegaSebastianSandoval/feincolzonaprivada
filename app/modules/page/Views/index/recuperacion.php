<div class="container d-flex justify-content-center">
    <form class="form" action="/page/login/inicarrecuperacion" id="form-recuperacion" method="post">
        <span class="title">Recuperación de contraseña</span>



        <img src="/corte/Logo-Header.png" alt="Logo FEINCOL" class="logo-formulario">


        <input type="text" class="input" required name="cedula" placeholder="Ingrese su c&eacute;dula">

        <span class="sub">¿Ya está registrado? <a href="/page/">Inicie sesión aqu&iacute;</a></span>
        <button>Iniciar registro</button>
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