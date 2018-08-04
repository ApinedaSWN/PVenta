<?php
// error_reporting(all);
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
      getAllAlmacen();
      break;
    default:
      # code...
      break;
  }

  function getAllAlmacen()
  {
    global $conexion;
    $query = $conexion->query('SELECT * FROM almacen')or die(mysql_errno());
    echo "<option value='' disabled>Selecciona un almacen</option>";
    while ($response = mysqli_fetch_array($query)) {
      echo "<option value='".$response[id_almacen]."'>".$response[nombre]."</option>";
    }
  }

    function getAll()
      {
        global $conexion;
        $query = $conexion->query('SELECT * FROM tienda WHERE estatus = 0')or die(mysql_errno());
        while ($response = mysqli_fetch_array($query)) {
          echo "<tr>
            <td>".$response['nombre']."</td>
            <td>".strtoupper($response['municipio'])."</td>
            <td>".$response['telefono']."</td>
            <td><a href='#editModal' class='modal-trigger' onclick='llenarinfo(".$response['id_tienda'].")'><i class='material-icons'>edit</i></a><i onclick='eliminar(".$response['id_tienda'].")' class='material-icons red-text'>close</i></td>
          </tr>";
        }
      }
    function create()
      {
        global $conexion;
          $almacenes = implode(",", $_POST['almacen']);
          $resultados = $conexion->query("SELECT * FROM tienda WHERE nombre = '$_POST[nombre]'")or die(mysql_errno());
        if ($query->num_rows > 0) {
          echo "1";
        }else {
          $consulta = "INSERT INTO  `puntoAgama`.`tienda` (
                                    `id_tienda` ,
                                    `nombre` ,
                                    `telefono` ,
                                    `estatus` ,
                                    `almacenes` ,
                                    `r_social` ,
                                    `rfc` ,
                                    `calle` ,
                                    `exterior` ,
                                    `interior` ,
                                    `colonia` ,
                                    `cp` ,
                                    `municipio` ,
                                    `estado` ,
                                    `email`
                                    )
                                    VALUES (
                                    NULL ,
                                    '".$_POST[nombre]."',
                                    '".$_POST[telefono]."',
                                    '0',
                                    '".$almacenes."',
                                    '".$_POST[r_social]."',
                                    '".$_POST[rfc]."',
                                    '".$_POST[calle]."',
                                    '".$_POST[exterior]."',
                                    '".$_POST[interior]."',
                                    '".$_POST[colonia]."',
                                    '".$_POST[cp]."',
                                    '".$_POST[municipio]."',
                                    '".$_POST[estado]."',
                                    '".$_POST[email]."')";
          $conexion->query($consulta)or die(mysql_errno());
          echo $consulta;
        }
      }
    function editModal($id)
      {
        global $conexion;
        $query = $conexion->query('SELECT * FROM tienda where id_tienda = '.$id)or die(mysqli_errno());
        $almacentxt ="";
        $response = mysqli_fetch_array($query);
        $almacenesarray = explode(",", $response['almacenes']);
        $almacenes = $conexion->query('SELECT * FROM almacen');
        while ($almacen = $almacenes->fetch_array(MYSQLI_ASSOC)) {
          $selected = "";
          if (in_array($almacen['id_almacen'], $almacenesarray)) {
            $selected = "selected";
          }
          $almacentxt .= "<option value='".$almacen['id_almacen']."' ".$selected.">".$almacen['nombre']."</option>";
        }
        echo '
        <div class="col m6 s12 input-field">
          <input type="hidden" name="id" value="'.$id.'">
          <input type="hidden" name="accion" value="4">
          <input type="text" name="nombre" value="'.$response['nombre'].'" id="nombre" required placeholder="Nombre tienda">
        </div>
        <div class="col m6 s12 input-field">
          <select class="" id="almacenes" value="'.$response['almacenes'].'" name="almacen[]" multiple>'.$almacentxt.'</select>
        </div>
        <div class="col m4 s12 input-field">
          <input type="text" name="r_social" value="'.$response['r_social'].'" required placeholder="Razon social">
        </div>
        <div class="col m4 s12 input-field">
          <input type="text" name="rfc" value="'.$response['rfc'].'" required placeholder="RFC">
        </div>
        <div class="col m4 s12 input-field">
          <input type="text" name="calle" value="'.$response['calle'].'" required placeholder="Calle">
        </div>
        <div class="col m3 s12 input-field">
          <input type="text" name="exterior" value="'.$response['exterior'].'" required placeholder="No.Exterior">
        </div>
        <div class="col m3 s12 input-field">
          <input type="text" name="interior" value="'.$response['interior'].'" required placeholder="No.Interior">
        </div>
        <div class="col m4 s12 input-field">
          <input type="text" name="colonia" value="'.$response['colonia'].'" required placeholder="Colonia">
        </div>
        <div class="col m2 s12 input-field">
          <input type="text" name="cp" value="'.$response['cp'].'" required placeholder="C.P.">
        </div>
        <div class="col m4 s12 input-field">
          <input type="text" name="municipio" value="'.$response['municipio'].'" required placeholder="Municipio">
        </div>
        <div class="col m4 s12 input-field">
          <input type="text" name="estado" value="'.$response['estado'].'" required placeholder="Estado">
        </div>
        <div class="col m4 s12 input-field">
          <input type="phone" name="telefono" value="'.$response['telefono'].'" maxlength="10" value=""  required placeholder="Telefono">
        </div>
        <div class="col m12 s12 input-field">
          <input type="email" name="email" value="'.$response['email'].'"  required placeholder="Email">
        </div>
        <div class="col m12 s12">
          <button type="submit" class="btn-large green" name="button">Guardar Cambios</button>
        </div>
        ';
      }
    function edit($id)
      {
        global $conexion;
        $almacenes = implode(",", $_POST['almacen']);
        $consulta = 'UPDATE tienda SET
        `nombre` = "'.$_POST['nombre'].'",
        `telefono` = "'.$_POST['telefono'].'",
        `estatus` = "0",
        `almacenes` = "'.$almacenes.'",
        `r_social` = "'.$_POST['r_social'].'",
        `rfc` = "'.$_POST['rfc'].'",
        `calle` = "'.$_POST['calle'].'",
        `exterior` = "'.$_POST['exterior'].'",
        `interior` = "'.$_POST['interior'].'",
        `colonia` = "'.$_POST['colonia'].'",
        `cp` = "'.$_POST['cp'].'",
        `municipio` = "'.$_POST['municipio'].'",
        `estado` = "'.$_POST['estado'].'",
        `email` = "'.$_POST['email'].'"
        WHERE id_tienda = '.$id;
        $conexion->query($consulta)or die('No se logro editar');
        echo 'Editado con exito';
      }

    function desactivar($id)
        {
          global $conexion;
      $query = $conexion->query('UPDATE tienda SET
        estatus = "1"
        WHERE id_tienda = '.$id.'
        ')or die('No se logro editar');
        echo "Se Elimino el tienda";
      }

 ?>
