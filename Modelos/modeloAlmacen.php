<?php
error_reporting(0);
  include "../includes/conexion.php";

  switch ($_POST[accion]) {
    case '1':
      echo getAll();
      break;
    case '2':
      echo create();
      break;
    case '3':
      echo editModal($_POST['id']);
      break;
    case '4':
      echo edit($_POST['id']);
      break;
    case '5':
      echo desactivar($_POST['id']);
      break;
    default:
      # code...
      break;
  }

    function getAll()
      {
        global $conexion;
        $query = $conexion->query('SELECT * FROM almacen')or die(mysql_errno());
        while ($response = mysqli_fetch_array($query)) {
          echo "<tr>
            <td>".$response['nombre']."</td>
            <td>".strtoupper($response['direccion'])."</td>
            <td>".$response['telefono']."</td>
            <td><a href='#editModal' class='modal-trigger' onclick='llenarinfo(".$response['id_almacen'].")'><i class='material-icons'>edit</i></a></td>
          </tr>";
        }
      }
    function create()
      {
        global $conexion;
        $resusltados = $conexion->query("SELECT * FROM almacen WHERE nombre = '$_POST[nombre]'")or die(mysql_errno());
        if ($query->num_rows > 0) {
          echo "1";
        }else {
          $query = $conexion->query("INSERT INTO `almacen` (`id_almacen`, `nombre`, `direccion`, `telefono`)
            VALUES
            (NULL, '".$_POST['nombre']."', '".$_POST['direccion']."', '".$_POST['telefono']."')")or die(mysql_errno());
            echo "ok";
        }
      }
    function editModal($id)
      {
        global $conexion;
        $query = $conexion->query('SELECT * FROM almacen where id_almacen = '.$id)or die(mysqli_errno());
        $response = mysqli_fetch_array($query);
        echo '
        <div class="col m3 s12 input-field">
          <input type="hidden" name="accion" value="4">
          <input type="hidden" name="id" value="'.$response['id_almacen'].'">
          <input type="text" name="nombre" value="'.$response['nombre'].'" id="nombre" required>
          <label for="nombre" class="active">Nombre tienda</label>
        </div>
        <div class="col m3 s12 input-field">
          <input type="number" name="telefono" maxlength="10" value="'.$response['telefono'].'" id="telefono" required>
          <label for="telefono" class="active">Telefono</label>
        </div>
        <div class="col m12 s12 input-field">
          <input type="text" name="direccion" value="'.$response['direccion'].'" id="direccion" required>
          <label for="direccion" class="active">Direccion</label>
        </div>
        <input class="btn-large green right" type="submit" name="enviar" value="Guardar Cambios">
        ';
      }
    function edit($id)
      {
        global $conexion;
        $query = $conexion->query('UPDATE almacen SET
          nombre = "'.$_POST['nombre'].'",
          telefono = "'.$_POST['telefono'].'",
          direccion = "'.$_POST['direccion'].'"
          WHERE id_almacen = '.$id.'
          ')or die('No se logro editar');

          echo "Se actualizo con exito";
      }
    function desactivar($id)
        {
          global $conexion;
      $query = $conexion->query('UPDATE almacen SET
        estatus = "1"
        WHERE id_almacen = '.$id.'
        ')or die('No se logro editar');
        echo "Se Elimino el almacen";
      }

 ?>
