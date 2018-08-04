<?php
$titulo = 'Administracion de usuarios';
  include $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
  <div class="container-fluid">
    <div class="fixed-action-btn">
      <a href="#crearModal" class="btn-floating btn-large green modal-trigger"><i class="material-icons">add</i></a>
    </div>
    <div class="row">
      <div class="col s12 m12">
        <div class="card">
          <h5 class="card-title headerCard right-align"></h5>
          <div class="card-content">
            <div class="row">
              <div class="col m12 s12">
                <p>Antes de comenzar a crear un usuario recuerda que hay ciertos puntos que debes cubrir, como tener creado un tipo de usuario o perfil de usuario si, el cual destinara los permisos que este usuario tendra dentro del sistema, si no tienes el perfil creado puedes crearlo aqui <a href="perfiles.php" class="blue-text">crear o modificar tipo de usuario, </a>el usuario debe tener asignada una tienda, la cual tambien debes crear, si aun no tienes ninguna creada puedes comezar a crearla <a href="tiendas.php">crear una tienda o sucursal.</a> </p>


              </div>
            </div>
            <table class="responsive-table centered ">
              <thead>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Tipo de usuario</th>
                <th>Tienda</th>
                <th>Acciones</th>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
<div id="crearModal" class="modal modal-fixed-footer">
  <h5 class="headerModal">Crear usuario</h5>
 <div class="modal-content">

   <div class="row">
     <form action="Javascript:Crear()" id="formCrear">
       <div class="col m6 s12 input-field">
         <input type="text" name="nombre" value="" id="nombre" required placeholder="Nombre">
       </div>
       <div class="col m6 s12 input-field">
         <input type="text" name="apellido" value="" id="apellido" required placeholder="Apellido">
       </div>
       <div class="col m4 s12 input-field">
         <input type="email" name="email" value="" id="email" required placeholder="Correo Electronico">
       </div>
       <div class="col m4 s12 input-field">
         <input type="number" name="telefono" maxlength="10" value="" id="telefono" required placeholder="Telefono">
       </div>
       <div class="col m4 s12 input-field">
          <select class="" name="tienda" id="tienda"></select>
       </div>
       <div class="col m12 s12 input-field">
         <input type="text" name="direccion" value="" id="direccion" required placeholder="Direccion">
       </div>
       <div class="col m4 s12 input-field">
         <select class="" name="perfil" id="perfil"></select>
       </div>
       <div class="col m4 s12 input-field">
         <input type="hidden" name="accion" value="2">
         <input type="text" name="usuario" value="" id="usuario" required placeholder="Usuario">
       </div>
       <div class="col m4 s12 input-field">
         <input type="password" name="password" value="" id="password" required placeholder="Password">
       </div>
   </div>
 </div>
 <div class="modal-footer">
       <input class="btn green right" type="submit" name="enviar" value="Crear Usuario">
 </div>
</form>
</div>
<div id="editModal" class="modal">
  <h5 class="headerModal">Editar Usuario</h5>
 <div class="modal-content">
   <div class="row">
     <form action="Javascript:edit()" id="formEditar"></form>
   </div>
 </div>
 <div class="modal-footer">
 </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    getall();
    llenarTiendas();
    llenarPerfiles();
  })


  function llenarinfo(id){
      $.ajax({
        type:'POST',
        url:'/Modelos/modeloUsuario.php',
        data:{id:id,accion:3},
        success:function(data){
          $('#formEditar').empty();
          $('#formEditar').append(data);
          $('select').formSelect();
        }
      })
    }
  function Crear(){
    data = $('#formCrear').serialize();
      $.ajax({
        type: 'POST',
        url: '/Modelos/modeloUsuario.php',
        data:data,
        success:function(data){
          if (data != 1) {
            reiniciar();
            M.toast({html: 'Creado Correctamente'});
          }else {
            M.toast({html: 'El correo electronico ya esta registrado'});
          }
        }
      })
  }
  function getall(){
    $.ajax({
      type: 'POST',
      url: '/Modelos/modeloUsuario.php',
      data:{accion:1},
      success:function(data){
        $('table tbody').empty();
        $('table tbody').append(data)
      }
    })
  }
  function llenarTiendas(){
    $.ajax({
      type: 'POST',
      url: '/Modelos/modeloUsuario.php',
      data:{accion:7},
      success:function(data){
        $('#tienda').empty();
        $('#tienda').append(data);
        $('select').formSelect();

      }
    })
  }
  function llenarPerfiles(){
    $.ajax({
      type: 'POST',
      url: '/Modelos/modeloUsuario.php',
      data:{accion:6},
      success:function(data){
        $('#perfil').empty();
        $('#perfil').append(data);
        $('select').formSelect();

      }
    })
  }
  function reiniciar() {
    $('input[type="text"],input[type="number"],input[type="email"]').val("");
    $('.modal').modal('close');
    getall();
  }
  function edit(){
    data = $('#formEditar').serialize();
    $.ajax({
      type:'POST',
      url:'/Modelos/modeloUsuario.php',
      data:data,
      success:function(data){
        reiniciar();
        M.toast({html: data});
      }
    })

  }
  function eliminar(id) {
    $.ajax({
      type:'POST',
      url:'/Modelos/modeloUsuario.php',
      data: {id:id,accion:5},
      success:function(data){
        reiniciar();
        M.toast({html: data});
      }
    })
  }
</script>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php";
 ?>
