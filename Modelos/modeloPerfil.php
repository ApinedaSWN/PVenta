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
      echo agregarPermisoMenu($_POST['data']);
      break;
    case '7':
      echo quitarPermisoMenu($_POST['data']);
      break;
    default:
      # code...
      break;
  }

    function getAll()
      {
        global $conexion;
        $query = $conexion->query('SELECT * FROM perfil WHERE estatus = 0 AND id_perfil != 1')or die(mysql_errno());
        while ($response = mysqli_fetch_array($query)) {
          echo "<tr>
            <td>".$response['id_perfil']."</td>
            <td>".strtoupper($response['perfil'])."</td>

            <td><a href='#editModal' class='modal-trigger' onclick='llenarinfo(".$response['id_perfil'].")'><i class='material-icons'>edit</i></a><i onclick='eliminar(".$response['id_perfil'].")' class='material-icons red-text'>close</i></td>
          </tr>";
        }
      }
    function create()
      {
        global $conexion;
        $resusltados = $conexion->query("SELECT * FROM perfil WHERE perfil = '".$_POST['perfil']."'")or die(mysql_errno());
        if ($resusltados->num_rows > 0) {
          echo "1";
        }else {
          $query = $conexion->query("INSERT INTO `perfil`(`id_perfil`, `perfil`, `created_at`)
          VALUES
          ( NULL,
            '".$_POST['perfil']."',
            CURRENT_TIMESTAMP)")or die(mysql_errno());
            echo "2";

        }
      }
    function editModal($id)
      {
        global $conexion;
        $query = $conexion->query('SELECT * FROM perfil where id_perfil = '.$id)or die(mysqli_errno());
        $response = mysqli_fetch_array($query);
        $respuesta = '<form action="Javascript:edit()" id="formEditar">
            <div class="col m12 s12 input-field">
            <input type="hidden" name="accion" value="4">
            <input type="hidden" name="id" value="'.$response['id_perfil'].'">
            <input type="text" name="perfil" value="'.$response['perfil'].'" id="perfil" required>
            <label for="perfil" class="active">Nombre perfil</label>
          </div>';
        $respuesta .= '<div class="col m12 s12 input-field">
                        <input class="btn-large green right" type="submit" name="enviar" value="Guardar Cambios">
                      </div>
                      </form>
                      ';
        $query2 = $conexion->query('SELECT * FROM menu')or die('no se encontro menu relacionado');

        while ($menu = mysqli_fetch_array($query2)) {
          $checked = "";
          $permisosArray = explode(',', $menu['permisos']);
          if (in_array($id, $permisosArray)) {
            $checked = 'checked';
          }
          $respuesta .='<div class="col m4">
            <div class="card">
              <h5 class="card-title headerCard" id="menuTitle">
                <label class="white-text">
                  <input style="border: 2px solid #fff" type="checkbox" '.$checked.' value="'.$id.','.$menu['id_menu'].'"/>
                  <span>'.$menu['menu'].'</span>
                </label>
              </h5>
              <div class="card-content">
                <div class="row">
                  <div class="col m12 input-field">
                    <p><label><input type="checkbox" /><span>Ver</span></label></p>
                    <p><label><input type="checkbox" /><span>Crear</span></label></p>
                    <p><label><input type="checkbox" /><span>Editar</span></label></p>
                    <p><label><input type="checkbox" /><span>Eliminar</span></label></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          ';
        }



        ?>

        <script type="text/javascript">
        $('.card-title input[type=\"checkbox\"]').change(function(){
          data = $(this).val();
          if ($(this).is(':checked')) {
            accion = 6;
          }else {
            accion = 7;
          }
          $.ajax({
            type:'POST',
            url:'Modelos/modeloPerfil.php',
            data: {data:data,accion:accion},
            success:function(data){
              M.toast({html: data});
            }
          })

        })
        </script>
        <?php

        echo $respuesta;
      }
    function edit($id)
      {
        global $conexion;
        $query = $conexion->query('UPDATE perfil SET
          perfil = "'.$_POST['perfil'].'"
          WHERE id_perfil = '.$id.'
          ')or die('No se logro editar');
          echo "Se actualizo con exito";
      }
    function desactivar($id)
        {
          global $conexion;
      $query = $conexion->query('UPDATE perfil SET
        estatus = "1"
        WHERE id_perfil = '.$id.'
        ')or die('No se logro editar');
        echo "Se Elimino el perfil";
      }

    function agregarPermisoMenu($data)
    {
      global $conexion;
      // echo "$data";
          $valores = explode(',' , $data);
          $query1 = $conexion -> query('SELECT permisos FROM menu where id_menu ='.$valores[1])or die('No se logro la consulta');
          $permiso = $query1->fetch_array(MYSQLI_ASSOC);
          $permisos = $permiso['permisos'].','.$valores[0];
          $query = $conexion->query('UPDATE menu SET permisos = "'.$permisos.'" WHERE id_menu = '.$valores[1])or die('No se logro editar');
          echo 'Permiso agregado exitosamente';
          }

    function quitarPermisoMenu($data)
    {
      global $conexion;
      // echo "$data";
          $valores = explode(',' , $data);

          $query1 = $conexion -> query('SELECT permisos FROM menu where id_menu ='.$valores[1])or die('No se logro la consulta');
          $permiso = $query1->fetch_array(MYSQLI_ASSOC);
          $permisos = str_replace(",".$valores[0], "", $permiso['permisos']);
          $query = $conexion->query('UPDATE menu SET permisos = "'.$permisos.'" WHERE id_menu = '.$valores[1])or die('No se logro editar');
          echo 'Permiso eliminado exitosamente';
      }
 ?>
