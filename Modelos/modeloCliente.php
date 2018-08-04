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
      echo getTCliente();
      break;
    default:
      # code...
      break;
  }

  function getTCliente()
    {
      global $conexion;
      $query = $conexion->query('SELECT * FROM t_cliente')or die(mysql_errno());
      echo '<option value="">Selecciona un tipo de cliente</option>';
      while ($response = mysqli_fetch_array($query)) {
        echo '<option value="'.$response['id_t_cliente'].'">'.$response['nombre'].'</option>';
      }
    }

    function getAll()
      {
        global $conexion;
        $query = $conexion->query('SELECT cliente.id_cliente,cliente.cliente,cliente.telefono, cliente.email,tienda.nombre as tienda, t_cliente.nombre as t_cliente, cliente.direccion, cliente.descuento FROM cliente INNER JOIN tienda on cliente.tienda_id = tienda.id_tienda INNER JOIN t_cliente on cliente.t_cliente_id = t_cliente.id_t_cliente WHERE cliente.estatus = 0')or die('No se logro la consulta 1');
        while ($response = mysqli_fetch_array($query)) {
          echo "<tr>
            <td>".$response['id_cliente']."</td>
            <td>".strtoupper($response['cliente'])."</td>
            <td>".strtoupper($response['direccion'])."</td>
            <td>".$response['telefono']."</td>
            <td>".$response['email']."</td>
            <td>".$response['created_at']."</td>
            <td>".$response['descuento']."</td>
            <td>".$response['nombre']."</td>


            <td><a href='#editModal' class='modal-trigger' onclick='llenarinfo(".$response['id_cliente'].")'><i class='material-icons'>edit</i></a><i onclick='eliminar(".$response['id_cliente'].")' class='material-icons red-text'>close</i></td>
          </tr>";
        }
      }
    function create()
      {
        global $conexion;
        $resusltados = $conexion->query("SELECT * FROM cliente WHERE email = '$_POST[email]'")or die(mysql_errno());
        if ($query->num_rows > 0) {
          echo "1";
        }else {
          $query = $conexion->query("INSERT INTO `cliente`(`id_cliente`, `cliente`, `telefono`, `email`, `direccion`, `t_cliente_id`, `descuento`, `created_at`, `tienda_id`, `usuario_id`, `estatus`)
          VALUES
          ( NULL,
            '$_POST[cliente]',
            '$_POST[telefono]',
            '$_POST[email]',
            '$_POST[direccion]',
            '$_POST[t_cliente]',
            '$_POST[descuento]',
            CURRENT_TIMESTAMP,
            '$_POST[tienda]',
            '$_POST[usuario]',
            '0')")or die(mysql_errno());
            echo "ok";
        }
      }
    function editModal($id)
      {
        global $conexion;
        $query = $conexion->query('SELECT cliente.id_cliente,cliente.cliente,cliente.telefono, cliente.email,tienda.nombre as tienda, t_cliente.nombre as t_cliente, cliente.direccion, cliente.descuento, cliente.tienda_id, cliente.t_cliente_id FROM cliente INNER JOIN tienda on cliente.tienda_id = tienda.id_tienda INNER JOIN t_cliente on cliente.t_cliente_id = t_cliente.id_t_cliente where id_cliente = '.$id)or die('No se logro la consulta');
        $response = mysqli_fetch_array($query);
        echo '
        <div class="col m3 s12 input-field">
          <input type="hidden" name="accion" value="4">
          <input type="hidden" name="id" value="'.$response[id_cliente].'"/>
          <input type="text" name="cliente" value="'.$response[cliente].'" id="cliente" required>
          <label for="cliente" class="active">Nombre cliente</label>
        </div>
        <div class="col m3 s12 input-field">
          <input type="number" name="telefono" maxlength="10" value="'.$response[telefono].'" id="telefono" required>
          <label for="telefono" class="active">Telefono</label>
        </div>
        <div class="col m3 s12 input-field">
          <input type="text" name="email" value="'.$response[email].'" id="email" required>
          <label for="email" class="active">Correo Electronico</label>
        </div>
        <div class="col m3 s12 input-field">
           <select class="" name="tienda" id="tienda">
            <option value="'.$response[tienda_id].'" selected>'.$response[tienda].'</option>';

          echo '</select>
           <label for="tienda">Selecciona una tienda</label>
        </div>
        <div class="col m3 s12 input-field">
           <select class="" name="t_cliente" id="t_cliente">
           <option value="'.$response[t_cliente_id].'" selected>'.$response[t_cliente].'</option>';
           echo getTCliente();
         echo '
           </select>
           <label for="t_cliente" >Tipo de cliente</label>
        </div>

        <div class="col m3 s12 input-field">
          <input type="number" name="descuento" min="0" max="100" value="'.$response[descuento].'" id="descuento">
          <input type="hidden" name="usuario" value="1" id="usuario" readonly>
          <label for="descuento" class="active">Descuento</label>
        </div>
        <div class="col m6 s12 input-field">
          <input type="text" name="direccion" value="'.$response[direccion].'" id="direccion" required>
          <label for="direccion" class="active">Direccion</label>
        </div>
        <input class="btn-large green right" type="submit" name="enviar" value="Guardar Cambios">
        ';
      }
    function edit($id)
      {
        global $conexion;
        $query = $conexion->query('UPDATE cliente SET
          cliente = "'.$_POST['cliente'].'",
          telefono = "'.$_POST['telefono'].'",
          direccion = "'.$_POST['direccion'].'",
          descuento = "'.$_POST['descuento'].'",
          tienda_id = "'.$_POST['tienda'].'",
          t_cliente_id = "'.$_POST['t_cliente'].'",
          email = "'.$_POST['email'].'"
          WHERE id_cliente = '.$id.'
          ')or die('No se logro editar');
          echo "Se actualizo con exito";
      }
    function desactivar($id)
        {
          global $conexion;
      $query = $conexion->query('UPDATE cliente SET
        estatus = "1"
        WHERE id_cliente = '.$id.'
        ')or die('No se logro editar');
        echo "Se Elimino el cliente";
      }

 ?>
