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
        $query = $conexion->query('SELECT * FROM t_cliente WHERE estatus = 0')or die(mysql_errno());
        while ($response = mysqli_fetch_array($query)) {
          echo "<tr>
            <td>".$response['id_t_cliente']."</td>
            <td>".strtoupper($response['nombre'])."</td>

            <td><a href='#editModal' class='modal-trigger' onclick='llenarinfo(".$response['id_t_cliente'].")'><i class='material-icons'>edit</i></a><i onclick='eliminar(".$response['id_t_cliente'].")' class='material-icons red-text'>close</i></td>
          </tr>";
        }
      }
    function create()
      {
        global $conexion;
        $resusltados = $conexion->query("SELECT * FROM t_cliente WHERE nombre = '$_POST[nombre]'")or die(mysql_errno());
        if ($query->num_rows > 0) {
          echo "1";
        }else {
          $query = $conexion->query("INSERT INTO `t_cliente`(`id_t_cliente`, `nombre`, `estatus`)
          VALUES
          ( NULL,
            '$_POST[nombre]',
            0)")or die(mysql_errno());
            echo "ok";
        }
      }
    function editModal($id)
      {
        global $conexion;
        $query = $conexion->query('SELECT * FROM t_cliente where id_t_cliente = '.$id)or die(mysqli_errno());
        $response = mysqli_fetch_array($query);
        echo '
        <div class="col m12 s12 input-field">
          <input type="hidden" name="accion" value="4">
          <input type="hidden" name="id" value="'.$response['id_t_cliente'].'">
          <input type="text" name="nombre" value="'.$response['nombre'].'" id="nombre" required>
        </div>
        <input class="btn-large green right" type="submit" name="enviar" value="Guardar Cambios">
        ';
      }
    function edit($id)
      {
        global $conexion;
        $query = $conexion->query('UPDATE t_cliente SET
          nombre = "'.$_POST['nombre'].'"
          WHERE id_t_cliente = '.$id.'
          ')or die('No se logro editar');
          echo "Se actualizo con exito";
      }
    function desactivar($id)
        {
          global $conexion;
      $query = $conexion->query('UPDATE t_cliente SET
        estatus = "1"
        WHERE id_t_cliente = '.$id.'
        ')or die('No se logro editar');
        echo "Se Elimino el tipo de cliente";
      }

 ?>
