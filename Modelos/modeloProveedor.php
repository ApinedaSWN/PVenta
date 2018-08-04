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
        $query = $conexion->query('SELECT * FROM proveedor WHERE estatus = 0')or die(mysql_errno());
        while ($response = mysqli_fetch_array($query)) {
          echo "<tr>
            <td>".$response['nombre']."</td>
            <td>".strtoupper($response['direccion'])."</td>
            <td>".$response['telefono']."</td>
            <td>".$response['email']."</td>
            <td>".$response['created_at']."</td>
            <td><a href='#editModal' class='modal-trigger' onclick='llenarinfo(".$response['id_proveedor'].")'><i class='material-icons'>edit</i></a><i onclick='eliminar(".$response['id_proveedor'].")' class='material-icons red-text'>close</i></td>
          </tr>";
        }
      }
    function create()
      {
        global $conexion;
        $resusltados = $conexion->query("SELECT * FROM proveedor WHERE email = '$_POST[email]'")or die(mysql_errno());
        if ($query->num_rows > 0) {
          echo "1";
        }else {
          $query = $conexion->query("INSERT INTO `proveedor`
            (`id_proveedor`, `nombre`, `direccion`, `telefono`, `email`, `created_at`, `contacto`)
            VALUES
            (NULL, '".$_POST['nombre']."', '".$_POST['direccion']."', '".$_POST['telefono']."', '".$_POST['email']."', CURRENT_TIMESTAMP, '".$_POST['contacto']."')")or die(mysql_errno());
            echo "ok";
        }
      }
    function editModal($id)
      {
        global $conexion;
        $query = $conexion->query('SELECT * FROM proveedor where id_proveedor = '.$id)or die(mysqli_errno());
        $response = mysqli_fetch_array($query);
        echo '
        <div class="col m3 s12 input-field">
          <input type="hidden" name="accion" value="4">
          <input type="hidden" name="id" value="'.$response['id_proveedor'].'">
          <input type="text" name="nombre" value="'.$response['nombre'].'" id="nombre" required>
          <label for="nombre" class="active">Nombre proveedor</label>
        </div>
        <div class="col m3 s12 input-field">
          <input type="number" name="telefono" maxlength="10" value="'.$response['telefono'].'" id="telefono" required>
          <label for="telefono" class="active">Telefono</label>
        </div>
        <div class="col m3 s12 input-field">
          <input type="text" name="email" value="'.$response['email'].'" id="email" required>
          <label for="email" class="active">Correo Electronico</label>
        </div>
        <div class="col m3 s12 input-field">
          <input type="text" name="contacto" value="'.$response['contacto'].'" id="contacto">
          <label for="contacto" class="active">Nombre de contacto</label>
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
        $query = $conexion->query('UPDATE proveedor SET
          nombre = "'.$_POST['nombre'].'",
          telefono = "'.$_POST['telefono'].'",
          direccion = "'.$_POST['direccion'].'",
          contacto = "'.$_POST['contacto'].'",
          email = "'.$_POST['email'].'"
          WHERE id_proveedor = '.$id.'
          ')or die('No se logro editar');

          echo "Se actualizo con exito";
      }
    function desactivar($id)
        {
          global $conexion;
      $query = $conexion->query('UPDATE proveedor SET
        estatus = "1"
        WHERE id_proveedor = '.$id.'
        ')or die('No se logro editar');
        echo "Se Elimino el proveedor";
      }

 ?>
