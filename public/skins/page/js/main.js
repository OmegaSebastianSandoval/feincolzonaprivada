var videos = [];
$(document).ready(function () {
  $(".dropdown-toggle").dropdown();
  $(".carouselsection").carousel({
    quantity: 4,
    sizes: {
      900: 3,
      500: 1,
    },
  });

  $(".banner-video-youtube").each(function () {
    // console.log($(this).attr('data-video'));
    const datavideo = $(this).attr("data-video");
    const idvideo = $(this).attr("id");
    const playerDefaults = {
      autoplay: 0,
      autohide: 1,
      modestbranding: 0,
      rel: 0,
      showinfo: 0,
      controls: 0,
      disablekb: 1,
      enablejsapi: 0,
      iv_load_policy: 3,
    };
    const video = {
      videoId: datavideo,
      suggestedQuality: "hd1080",
    };
    videos[videos.length] = new YT.Player(idvideo, {
      videoId: datavideo,
      playerVars: playerDefaults,
      events: {
        onReady: onAutoPlay,
        onStateChange: onFinish,
      },
    });
  });

  $(function () {
    $(".doc-item-theme").on("click", function () {
      let id = $(this).attr("data-id");
      console.log(id);
      $("#" + id).slideToggle();
    });
  });

  function onAutoPlay(event) {
    event.target.playVideo();
    event.target.mute();
  }

  function onFinish(event) {
    if (event.data === 0) {
      event.target.playVideo();
    }
  }
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );
});

$(document).ready(function () {
  $(document).ajaxStart(function () {
    $(".loader-bx").addClass("show");
  });

  $(document).ajaxStop(function () {
    $(".loader-bx").removeClass("show");
  });

  /* ****************************************
 INICIO DE FORMULARIO INICIO DE SESION
  **************************************** */

  $("#form-login").on("submit", function (e) {
    var captcha = document.querySelector(".g-recaptcha-response").value;
    if (!captcha) {
      // Si no se ha completado el reCAPTCHA, evita que el formulario se envíe y muestra un mensaje de error.
      e.preventDefault();
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Es necesario validar el captcha",
        confirmButtonColor: "#192a4b",
      });
      return;
    }

    e.preventDefault();

    let data = $(this).serialize();
    // console.log(data);

    $.ajax({
      url: $(this).attr("action"),
      type: $(this).attr("method"),
      data: data,
      dataType: "json",
      success: function (response) {
        // console.log(response);

        if (response.status == "success") {
          window.location.href = "/page/home";
          //window.location.href = "/page/estadocuenta";
          // window.location.href = "/page/totalestadocuenta";
        } else if (response.status == "activar") {
          Swal.fire({
            icon: "info",
            title: "El asociado no ha registrado ninguna contraseña",
            text: response.message,
            confirmButtonColor: "#192a4b",

            confirmButtonText: "Continuar",
          }).then((result) => {
            window.location.href = "/page/index/registro";
          });
        } else if (response.status == "error") {
          Swal.fire({
            icon: "error",
            title: "Error",
            confirmButtonColor: "#192a4b",

            text: response.message,
          }).then((result) => {
            if (response.message == "Captcha incorrecto") {
              window.location.reload();
            }
          });
        } else if (response.status == "bloqueado") {
          Swal.fire({
            icon: "error",
            title: "Error",
            confirmButtonColor: "#192a4b",

            text: response.message,
          });
        }
      },
    });
  });

  // Fin de sesion
  /* ****************************************
 FIN DE FORMULARIO INICIO DE SESION
  **************************************** */

  /* ****************************************
 INICIO DE FORMULARIO INICIO DE REGISTRO DE CLAVE
  **************************************** */

  // Inicio de registro
  $("#form-registro").on("submit", function (e) {
    e.preventDefault();

    let data = $(this).serialize();
    // console.log(data);
    $.ajax({
      url: $(this).attr("action"),
      type: $(this).attr("method"),
      data: data,
      dataType: "json",
      success: function (response) {
        // console.log(response);

        if (response.status == "success") {
          Swal.fire({
            icon: "success",
            title: "Solicitud de registro exitoso",
            text: response.message,
            confirmButtonColor: "#192a4b",

            confirmButtonText: "Continuar",
          }).then((result) => {
            window.location.href = "/";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
            confirmButtonColor: "#192a4b",
          });
        }
      },
    });
  });
  // Fin de registro

  /* ****************************************
 FIN DE FORMULARIO INICIO DE REGISTRO DE CLAVE
  **************************************** */

  /* ****************************************
 INICIO DE FORMULARIO REGISTRO DE CLAVE
  **************************************** */
  // Inicio registro de contraseña
  $("#form-resgistroclave").on("submit", function (e) {
    e.preventDefault();

    let data = $(this).serialize();
    $.ajax({
      url: $(this).attr("action"),
      type: $(this).attr("method"),
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status == "success") {
          Swal.fire({
            icon: "success",
            title: "Registro de contraseña exitoso",
            text: response.message,
            confirmButtonColor: "#192a4b",
            confirmButtonText: "Continuar",
          }).then((result) => {
            window.location.href = "/page/home";
            // window.location.href = "/page/estadocuenta";
            //window.location.href = "/page/totalestadocuenta";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
            confirmButtonColor: "#192a4b",
          });
        }
      },
    });
  });
  // Fin registro de contraseña
  /* ****************************************
 FIN DE FORMULARIO REGISTRO DE CLAVE
  **************************************** */

  /* ****************************************
 INICIO DE FORMULARIO SOLICITAR CAMBIO DE CLAVE
  **************************************** */
  // Inicio de  solicitar cambio de contraseña
  $("#form-recuperacion").on("submit", function (e) {
    e.preventDefault();

    let data = $(this).serialize();
    // console.log(data);
    $.ajax({
      url: $(this).attr("action"),
      type: $(this).attr("method"),
      data: data,
      dataType: "json",
      success: function (response) {
        // console.log(response);

        if (response.status == "success") {
          Swal.fire({
            icon: "success",
            title: "Solicitud de cambio exitoso",
            text: response.message,
            confirmButtonColor: "#192a4b",

            confirmButtonText: "Continuar",
          }).then((result) => {
            window.location.href = "/";
          });
        } else if (response.status == "errorActivacion") {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
            confirmButtonColor: "#192a4b",
          }).then((result) => {
            window.location.href = "/page/index/registro";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
            confirmButtonColor: "#192a4b",
          });
        }
      },
    });
  });
  // Fin de solicitar cambio de contraseña
  /* ****************************************
 FIN DE FORMULARIO SOLICITAR CAMBIO DE CLAVE
  **************************************** */

  /* ****************************************
 INICIO DE CAMBIO DE CLAVE
  **************************************** */
  // Inicio cambio de contraseña
  $("#form-recuperar").on("submit", function (e) {
    e.preventDefault();

    let data = $(this).serialize();
    $.ajax({
      url: $(this).attr("action"),
      type: $(this).attr("method"),
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status == "success") {
          Swal.fire({
            icon: "success",
            title: "Recuperación de contraseña exitoso",
            text: response.message,
            confirmButtonColor: "#192a4b",
            confirmButtonText: "Continuar",
          }).then((result) => {
            window.location.href = "/page/home";
            //window.location.href = "/page/estadocuenta";
            //window.location.href = "/page/totalestadocuenta";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
            confirmButtonColor: "#192a4b",
          });
        }
      },
    });
  });
  // Fin cambio de contraseña
  /* ****************************************
 FIN DE CAMBIO DE CLAVE
  **************************************** */
});
