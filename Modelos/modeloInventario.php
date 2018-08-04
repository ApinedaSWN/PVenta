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
    case '6':
      echo getProveedor();
      break;
    case '7':
      echo eliminados();
      break;
    case '8':
    reactivar($_POST['id']);
      // code...
      break;
    default:
      # code...
      break;
  }

  function getProveedor()
    {
      global $conexion;
      $query = $conexion->query('SELECT * FROM proveedor WHERE estatus = 0')or die(mysql_errno());
      echo '<option value="">Selecciona un proveedor</option>';
      while ($response = mysqli_fetch_array($query)) {
        echo '<option value="'.$response['id_proveedor'].'">'.$response['nombre'].'</option>';
      }
    }

    function getAll()
      {
        global $conexion;
        $query = $conexion->query('SELECT * FROM producto INNER JOIN proveedor on producto.id_proveedor = proveedor.id_proveedor WHERE producto.estatus = 0')or die('No se logro la consulta 1');
        while ($response = mysqli_fetch_array($query)) {
          echo "<tr>
            <td>".$response['id_producto']."</td>
            <td>".strtoupper($response['producto'])."</td>
            <td>".strtoupper($response['nombre'])."</td>
            <td>".$response['precioUnitario']."</td>
            <td>".strtoupper($response['inventario'])."</td>
            <td>".strtoupper($response['descripcion'])."</td>
            <td><a href='#editModal' class='modal-trigger' onclick='llenarinfo(".$response['id_producto'].")'><i class='material-icons'>edit</i></a><i onclick='eliminar(".$response['id_producto'].")' class='material-icons red-text'>close</i></td>
          </tr>";
        }
      }
    function create()
      {
        global $conexion;
        $resusltados = $conexion->query("SELECT * FROM producto WHERE producto LIKE '$_POST[producto]'")or die(mysql_errno());
        if ($query->num_rows > 0) {
          echo "1";
        }else {
          $query = $conexion->query("INSERT INTO `producto`(`id_producto`, `producto`, `descripcion`, `precioUnitario`,`id_proveedor`, `inventario`,  `created_at`, `estatus`)
          VALUES
          ( NULL,
            '$_POST[producto]',
            '$_POST[descripcion]',
            '$_POST[precio]',
            '$_POST[proveedor]',
            '$_POST[inventario]',
            CURRENT_TIMESTAMP,
            '0')")or die(mysql_errno());
            echo "ok";
        }
      }
    function editModal($id)
      {
        global $conexion;
        $query = $conexion->query('SELECT * FROM producto INNER JOIN proveedor on producto.id_proveedor = proveedor.id_proveedor WHERE id_producto ='.$id)or die('No se logro la consulta');
        $response = mysqli_fetch_array($query);
        echo '
        <div class="col m12 s12 input-field">
          <input type="hidden" name="accion" value="4">
          <input type="hidden" name="id" value="'.$response[id_producto].'"/>
          <input type="text" name="producto" value="'.$response[producto].'" id="producto" required>
          <label for="producto" class="active">Producto</label>
        </div>
        <div class="col m12 s12 input-field">
          <input type="number" name="precio" maxlength="10" value="'.$response[precioUnitario].'" id="precio" required>
          <label for="precio" class="active">Precio</label>
        </div>
        <div class="col m12 s12 input-field">
          <input type="text" name="descripcion" value="'.$response[descripcion].'" id="descripcion" required>
          <label for="descripcion" class="active">Descripcion</label>
        </div>

        <div class="col m12 s12 input-field">
           <select class="" name="proveedor" id="proveedor">
           <option value="'.$response[id_proveedor].'" selected>'.$response[nombre].'</option>';
           echo getProveedor();
         echo '
           </select>
           <label for="proveedor" >Tipo de cliente</label>
        </div>
        <input class="btn-large green right botonxl" type="submit" name="enviar" value="Guardar Cambios">
        ';
      }
    function edit($id)
      {
        global $conexion;
        $query = $conexion->query('UPDATE producto SET
          producto = "'.$_POST[producto].'",
          descripcion = "'.$_POST[descripcion].'",
          precioUnitario = "'.$_POST[precio].'",
          id_proveedor = "'.$_POST[proveedor].'",
          inventario = "'.$_POST[inventario].'"
          WHERE id_producto = '.$id.'
          ')or die('No se logro editar');
          echo "Se actualizo con exito";
      }
    function desactivar($id)
        {
          global $conexion;
      $query = $conexion->query('UPDATE producto SET
        estatus = "1"
        WHERE id_producto = '.$id.'
        ')or die('No se logro editar');
        echo "Se Elimino el producto";
      }
      function reactivar($id)
          {
            global $conexion;
        $query = $conexion->query('UPDATE producto SET
          estatus = "0"
          WHERE id_producto = '.$id.'
          ')or die('No se logro editar');
          echo "Se recupero el producto";
        }
    function eliminados(){
      global $conexion;
      $query = $conexion->query('SELECT * FROM producto INNER JOIN proveedor on producto.id_proveedor = proveedor.id_proveedor WHERE producto.estatus = 1')or die('No se logro la consulta 1');
      while ($response = mysqli_fetch_array($query)) {
        echo "<tr>
          <td>".strtoupper($response['producto'])."</td>
          <td>".strtoupper($response['descripcion'])."</td>
          <td><button  onclick='reactivar(".$response['id_producto'].")' class='btn green'><i class='material-icons left'>done</i>Recuperar</button></td>
        </tr>";
      }
    }

 ?>
