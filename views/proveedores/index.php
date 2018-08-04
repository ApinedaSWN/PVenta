<?php
  include $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

  <div class="container-fluid">
    <div class="fixed-action-btn">
      <a href="#crearModal" class="btn-floating btn-large green modal-trigger"><i class="material-icons">add</i></a>
    </div>

    <div class="row">
      <div class="col s12 m12">
        <div class="card">
          <h5 class="card-title headerCard right-align"><i class="material-icons left btn-flat white-text">more_vert</i>Proveedores</h5>
          <div class="card-content">
            <table class="responsive-table centered ">
              <thead>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Fecha</th>
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

<div id="crearModal" class="modal">
 <div class="modal-content">
   <h4>Crear proveedor</h4>
   <div class="divider"></div>
   <div class="row">
     <form action="Javascript:Crear()" id="formCrear">
       <div class="col m3 s12 input-field">
         <input type="hidden" name="accion" value="2">
         <input type="text" name="nombre" value="" id="nombre" required>
         <label for="nombre">Nombre proveedor</label>
       </div>
       <div class="col m3 s12 input-field">
         <input type="number" name="telefono" maxlength="10" value="" id="telefono" required>
         <label for="telefono">Telefono</label>
       </div>
       <div class="col m3 s12 input-field">
         <input type="text" name="email" value="" id="email" required>
         <label for="email">Correo Electronico</label>
       </div>
       <div class="col m3 s12 input-field">
         <input type="text" name="contacto" value="" id="contacto">
         <label for="contacto">Nombre de contacto</label>
       </div>

       <div class="col m12 s12 input-field">
         <input type="text" name="direccion" value="" id="direccion" required>
         <label for="direccion">Direccion</label>
       </div>

   </div>
 </div>
 <div class="modal-footer">
       <input class="btn-large green right" type="submit" name="enviar" value="Crear Proveedor">
 </div>
</form>
</div>

<div id="editModal" class="modal">
 <div class="modal-content">
   <h4>Editar proveedor</h4>
   <div class="divider"></div>
   <div class="row">
     <form action="Javascript:edit()" id="formEditar">


     </form>
   </div>
 </div>
 <div class="modal-footer">
 </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    getall();
  })
  function llenarinfo(id){
      $.ajax({
        type:'POST',
        url:'/Modelos/modeloProveedor.php',
        data:{id:id,accion:3},
        success:function(data){
          $('#formEditar').empty();
          $('#formEditar').append(data);
        }
      })
    }
  function Crear(){
    data = $('#formCrear').serialize();
      $.ajax({
        type: 'POST',
        url: '/Modelos/modeloProveedor.php',
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
      url: '/Modelos/modeloProveedor.php',
      data:{accion:1},
      success:function(data){
        $('table tbody').empty();
        $('table tbody').append(data)
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
      url:'/Modelos/modeloProveedor.php',
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
      url:'/Modelos/modeloProveedor.php',
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
