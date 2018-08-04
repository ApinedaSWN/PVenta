<?php
  include "../includes/conexion.php";

  switch ($_POST['accion']) {
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
      echo getPerfiles();
      break;
    case '7':
      echo getTiendas();
      break;
    default:
      # code...
      break;
  }

    function getPerfiles()
      {
        global $conexion;
        $query = $conexion->query('SELECT* FROM perfil')or die(mysql_errno());
        echo '<option value="">Selecciona un perfil</option>';
        while ($response = mysqli_fetch_array($query)) {
          echo '<option value="'.$response['id_perfil'].'">'.$response['perfil'].'</option>';
        }
      }
    function getTiendas()
      {
        global $conexion;
        $query = $conexion->query('SELECT* FROM tienda WHERE estatus = 0')or die(mysql_errno());
        echo '<option value="">Selecciona una tienda</option>';
        while ($response = mysqli_fetch_array($query)) {
          echo '<option value="'.$response['id_tienda'].'">'.$response['nombre'].'</option>';
        }
      }

    function getAll()
      {
        global $conexion;
        $query = $conexion->query('SELECT id_usuario,usuario,usuario.nombre,apellido,usuario.telefono,usuario.direccion,perfil,tienda.nombre as tienda FROM usuario
          INNER JOIN tienda on usuario.tienda_id = tienda.id_tienda
          INNER JOIN perfil on usuario.t_usuario_id = perfil.id_perfil
          WHERE usuario.estatus = 0')or die(mysql_errno());
        while ($response = mysqli_fetch_array($query)) {
          echo "<tr>
            <td>".$response['usuario']."</td>
            <td>".$response['nombre']."</td>
            <td>".$response['apellido']."</td>
            <td>".$response['telefono']."</td>
            <td>".strtoupper($response['direccion'])."</td>
            <td>".$response['perfil']."</td>
            <td>".$response['tienda']."</td>";
            if ($response['id_usuario'] != 1) {
              echo "<td>
              <a href='#editModal' class='modal-trigger' onclick='llenarinfo(".$response['id_usuario'].")'>
              <i class='material-icons'>edit</i>
              </a>
              <i onclick='eliminar(".$response['id_usuario'].")' class='material-icons red-text'>close</i>
              </td>";
            }else {
              echo "<td>No es posible editar</td>";
            }
            echo "</tr>";
        }
      }
    function create()
      {
        global $conexion;
        $resultados = $conexion->query("SELECT * FROM usuario WHERE nombre = '".$_POST['nombre']."'")or die(mysql_errno());
        if ($resultados->num_rows > 0) {
          echo "1";
        }else {
          $consulta = "INSERT INTO usuario (`id_usuario`, `usuario`, `password`, `nombre`, `apellido`, `telefono`, `direccion`, `t_usuario_id`, `tienda_id`, `created_at`, `email`)
            VALUES
             (NULL, '".$_POST['usuario']."', '".$_POST['password']."', '".$_POST['nombre']."', '".$_POST['apellido']."', '".$_POST['telefono']."', '".$_POST['direccion']."', '".$_POST['perfil']."', '".$_POST['tienda']."', CURRENT_TIMESTAMP,'".$_POST['email']."')";
          $conexion->query($consulta);
        }
        echo "ok";
      }
    function editModal($id)
      {
        global $conexion;
        $query = $conexion->query('SELECT id_usuario,password,usuario,usuario.nombre,apellido,usuario.telefono,usuario.direccion,perfil,t_usuario_id,tienda_id,tienda.nombre as tienda FROM usuario
          INNER JOIN tienda on usuario.tienda_id = tienda.id_tienda
          INNER JOIN perfil on usuario.t_usuario_id = perfil.id_perfil where id_usuario = '.$id)or die(mysqli_errno());
        $response = mysqli_fetch_array($query);
        echo '
        <div class="col m3 s12 input-field">
          <input type="hidden" name="accion" value="4">
          <input type="hidden" name="id" value="'.$response['id_usuario'].'">
          <input type="text" name="usuario" value="'.$response['usuario'].'" id="usuario" required>
          <label for="usuario" class="active">Nombre usuario</label>
        </div>
        <div class="col m3 s12 input-field">
          <input type="text" name="password" value="'.$response['password'].'" id="password" required>
          <label for="password" class="active">Contraseña</label>
        </div>
        <div class="col m3 s12 input-field">
          <input type="text" name="nombre" value="'.$response['nombre'].'" id="nombre" required>
          <label for="nombre" class="active">Nombre</label>
        </div>
        <div class="col m3 s12 input-field">
          <input type="text" name="apellido" value="'.$response['apellido'].'" id="apellido" required>
          <label for="apellido" class="active">Apellido</label>
        </div>
        <div class="col m3 s12 input-field">
          <input type="number" name="telefono" maxlength="10" value="'.$response['telefono'].'" id="telefono" required>
          <label for="telefono" class="active">Telefono</label>
        </div>
        <div class="col m3 s12 input-field">
           <select class="" name="tienda" id="tienda" >
           <option value="'.$response[tienda_id].'">'.$response[tienda].'</option>';
            echo getTiendas();
            echo '
           </select>
           <label for="tienda">Selecciona una tienda</label>
        </div>
        <div class="col m3 s12 input-field">
           <select class="" name="perfil" id="perfil" >
              <option value="'.$response[t_usuario_id].'">'.$response[perfil].'</option>';
              echo getPerfiles();
          echo '
           </select>
           <label for="perfil">Tipo de usuario</label>
        </div>
        <div class="col m6 s12 input-field">
          <input type="text" name="direccion" value="'.$response['direccion'].'" id="direccion" required>
          <label for="direccion" class="active">Direccion</label>
        </div>
        <input class="btn-large green right" type="submit" name="enviar" value="Guardar Cambios">
        ';
      }
    function edit($id)
      {
        global $conexion;
        $query = $conexion->query('UPDATE usuario SET
          usuario = "'.$_POST['usuario'].'",
          password = "'.$_POST['password'].'",
          nombre = "'.$_POST['nombre'].'",
          apellido = "'.$_POST['apellido'].'",
          telefono = "'.$_POST['telefono'].'",
          direccion = "'.$_POST['direccion'].'",
          t_usuario_id = "'.$_POST['perfil'].'",
          tienda_id = "'.$_POST['tienda'].'"
          WHERE id_usuario = '.$id.'
          ')or die('No se logro editar');

          echo "Se actualizo con exito";
      }
    function desactivar($id)
        {
          global $conexion;
      $query = $conexion->query('UPDATE usuario SET
        estatus = "1"
        WHERE id_usuario = '.$id.'
        ')or die('No se logro editar');
        echo "Se Elimino el usuario";
      }

 ?>
