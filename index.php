<?php
session_start();
if (isset($_SESSION['usuario'])) {
  header('Location:/views/inicio');
}
$msg_error = "";
$display ="display:none;";
  if (isset($_POST['usuario'])) {
    include $_SERVER['DOCUMENT_ROOT'].'/includes/conexion.php';
    $query = $conexion->query('SELECT id_usuario,t_usuario_id,perfil,password,usuario,tienda.nombre as tienda, usuario.nombre, usuario.apellido, usuario.email FROM usuario
      inner join tienda on usuario.tienda_id = tienda.id_tienda
      inner join perfil on usuario.t_usuario_id = perfil.id_perfil
      WHERE usuario LIKE "'.$_POST['usuario'].'"');
    if ($query->num_rows > 0) {
      $usuario = $query->fetch_array(MYSQLI_ASSOC);
      if (isset($_POST['password']) && $_POST['password'] == $usuario['password']) {
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['usuario'] = $usuario['usuario'];
        $_SESSION['nombre'] = $usuario['nombre']." ".$usuario['apellido'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['tienda'] = $usuario['tienda'];
        $_SESSION['perfil'] = $usuario['perfil'];
        $_SESSION['id_perfil'] = $usuario['t_usuario_id'];
        $_SESSION['id'] = $usuario['id_usuario'];
        header('Location:/views/inicio');
      }else {
        $msg_error = 'La contraseña no coincide con el usuario';
        $display ="display:block;";
      }

    }else {
      $msg_error = 'El usuario no existe en el sistema';
      $display ="display:block;";
    }
  }
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="apple-touch-icon" sizes="57x57" href="/assets/img/fav/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/assets/img/fav/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/assets/img/fav/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/fav/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/assets/img/fav/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/assets/img/fav/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/assets/img/fav/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/fav/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/fav/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/assets/img/fav/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/fav/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/assets/img/fav/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/fav/favicon-16x16.png">
  <title>Agama Ventas</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
  <link rel="stylesheet" href="/assets/css/estilos.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style media="screen">
  *{
    font-family: 'Montserrat', sans-serif;
  }
  main{
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100% !important;
    position: absolute;
    background-color: rgba(51,71,79,0.8);
  }
  .container-fluid{
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    height: 100% !important;
    position: absolute;

  }
  .row{
    margin: 0;
  }
  .center-h{
    display: flex;
    justify-content: center;
    flex-flow: row wrap;
  }
  video {
    background-size: cover;
    bottom: 0;
    height: auto;
    min-height: 100%;
    min-width: 100%;
    position: fixed;
    right: 0;
    width: auto;
    z-index: -100;
  }
  .headerTitle{
    padding: 10px;
    text-align: center;
    letter-spacing: 7px;
  }

  .btnlogin{
    width: 100%;
  }


  </style>
</head>
<body class="">
  <video src="/assets/img/loginBack.mp4" autoplay loop>

  </video>
  <main>
    <div class="container-fluid ">
      <div class="center-h row" style="width:100%;">
        <div class="col m3 s12">
          <div class="card cont-login" >
            <h5 class="headerTitle" style="padding-top:1.5em;"><img src="/assets/img/LogoCirculo.png" class="responsive-img" style="width:50%;" alt=""></h5>
            <div class="card-content">
              <div class="row">
                <div class="col m12 s12">
                  <div class="divider"></div>
                </div>
                <form class="" action="" method="post"  style="padding-bottom:10px;">
                  <div class="col m12 s12 input-field">
                    <input type="text" name="usuario" value="" id="usuario" autocomplete="off" placeholder="Nombre de usuario" required>
                  </div>
                  <div class="col m12 s12 input-field">
                    <input type="password" name="password" value="" id="password" required placeholder="Contraseña">
                  </div>
                  <div class="col m12 s12 inline input-field">
                    <input type="submit" class="btn-large blue btnlogin" name="" value="Entrar">
                    <span class="helper-text center-align" data-error="wrong" data-success="right">Si olvidaste tu password comunicate con el administrador </span>
                  </div>
                </form>
              </div>

              <div class="row"  style="padding-top:1.5em;">
                <div class="col m12 s12 red white-text center-align" style="padding:10px; <?php echo $display; ?>">
                  <?php echo $msg_error; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
</html>
