<?php
  session_start();
  if (!isset($_SESSION['usuario'])) {
    header('Location:/');
  }
  include $_SERVER['DOCUMENT_ROOT'].'/includes/conexion.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="google-site-verification" content="o1wVV3t4zM2nPcyvOPJhF6y0A5SxxFfdVbr-TmCvMvw" />
  <title>Agama Ventas</title>
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
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
  <link rel="stylesheet" href="/assets/css/estilos.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
  <script src="http://pagination.js.org/dist/2.1.3/pagination.min.js" charset="utf-8"></script>
</head>
<body class="grey lighten-3">
  <header>
    <nav class=" blue-grey darken-4">
      <ul id="nav-mobile" class="">
        <li>
          <a href="#" data-target="slide-out" class="sidenav-trigger show-on-small">
            <i class="material-icons">menu</i>
          </a>
        </li>
        <li class="center"><a href="" ><?php echo $titulo ?></a></li>
      </ul>
      <ul id="nav-mobile" class="right">
        <li>
          <a href="/Modelos/CloseSession.php" class="btn-flat white-text ">
            <i class="material-icons">exit_to_app</i>
          </a>
        </li>
        <li>
          <a href="configuracion.php" class="btn-flat white-text disabled">
            <i class="material-icons">settings</i>
          </a>
        </li>
      </ul>
    </nav>
    <ul id="slide-out" class="sidenav sidenav-fixed">
      <li><div class="user-view right-align">
        <div class="background  blue-grey darken-1">
          <img src="/assets/img/userimg.jpg">
        </div>
        <a href="#user"><img class="responsive-img circle" src="/assets/img/jimmy.png" ></a>
        <a href="#name"><span class="white-text name"><?php echo $_SESSION['nombre']; ?></span></a>
        <a href="#email"><span class="white-text email"><?php echo $_SESSION['perfil']; ?></span></a>
      </div></li>
      <li><a class="waves-effect" href="inicio.php"><i class="material-icons">dashboard</i>Inicio</a></li>
      <?php
          $menus = $conexion->query('SELECT * FROM menu WHERE permisos LIKE "%'.$_SESSION['id_perfil'].'%"');
          while ($menu= $menus->fetch_array(MYSQLI_ASSOC)) {
          ?>
          <li><a class="waves-effect" href="/views/<?php echo strtolower($menu['menu']) ?>"><i class="material-icons"><?php echo $menu['icon'] ?></i><?php echo $menu['menu'] ?></a></li>
          <?php
          }
       ?>
    </ul>
  </header>
  <main>
