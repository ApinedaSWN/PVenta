<?php
  include '../includes/conexion.php';

  switch ($_POST['accion']) {
    case '1':
      cargarProductos();
      break;

    default:
      echo "NO existe ";
      break;
  }

  function cargarProductos()
  {
    global $conexion;
    $respuesta = array();
    if ($productos = $conexion->query('SELECT producto, inventario FROM producto where estatus = 0 AND inventario > 0')) {
      while ($producto = $productos->fetch_array(MYSQLI_ASSOC)) {
        $respuesta .= $producto;
      }
    }
    echo $respuesta;
  }
?>
