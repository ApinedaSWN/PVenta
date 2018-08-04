<?php
  include $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

  <div class="container-fluid">
    <div class="fixed-action-btn">
      <a href="crear" class="btn-floating btn-large green modal-trigger"><i class="material-icons">add</i></a>
    </div>
    <style media="screen">
      .dropdown-content{
        min-width: 300px;
      }
    </style>
    <div class="row">
      <div class="col s12 m6">
        <div class="card large">
          <h5 class="card-title headerCard right-align"></h5>
          <ul id='opciones' class='dropdown-content'>
            <li><a href="crear" >Crear producto</a></li>
            <li><a href="#delModal" onclick="cargarEliminados()" class="modal-trigger">Productos eliminados</a></li>
          </ul>
          <div class="card-content">
            <table class="responsive-table centered " id="VGeneral">
              <thead>
                <th>CR</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Acciones</th>
              </thead>
              <tbody id="General">

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col m6"></div>
    </div>

  </div>

<div id="crearModal" class="modal">
  <h5 class="headerModal"></h5>
 <div class="modal-content">
   <div class="row">
     <form action="Javascript:Crear()" id="formCrear">
       <div class="col m4 s12 input-field">
         <input type="hidden" name="accion" value="2">
         <input type="text" name="producto" value="" id="producto" required placeholder="Producto">

       </div>
       <div class="col m4 s12 input-field">
         <input type="text" name="descripcion" min="0" max="100" value="" id="descripcion" placeholder="Descripcion">

       </div>
       <div class="col m4 s12 input-field">
         <input type="text" name="precio" maxlength="10" value="" id="precio" required placeholder="Precio Lista">
       </div>
       <div class="col m4 s12 input-field">
         <input type="text" name="inventario" maxlength="10" value="" id="inventario" required placeholder="Cantidad">
       </div>
       <div class="col m4 s12 input-field">
          <select class="" name="proveedor" id="proveedor" >
          </select>
       </div>
   </div>
 </div>
 <div class="modal-footer">
       <input class="btn-large green right" type="submit" name="enviar" value="Crear Inventario">
 </div>
</form>
</div>
<style media="screen">
@media screen and (max-width:1000px) {
  #editModal,#crearModal{
    max-width: 25% !important;
  }
}
  .botonxl{
    width: 100%;
  }
</style>
<div id="editModal" class="modal" >
 <div class="modal-content">
   <h4>Editar Producto</h4>
   <div class="divider"></div>
   <div class="row">
     <form action="Javascript:edit()" id="formEditar"></form>
   </div>
 </div>
 <div class="modal-footer">
 </div>
</div>

<div id="delModal" class="modal">
 <div class="modal-content">
   <h4>Productos eliminados</h4>
   <div class="divider"></div>
   <div class="row">
     <table id="EliminadosGeneral">
       <thead>
         <th>Producto</th>
         <th>Descripcion</th>
         <th>Accion</th>
       </thead>
       <tbody id="eliminados">

       </tbody>
     </table>
   </div>
 </div>
 <div class="modal-footer">
 </div>
</div>



<script type="text/javascript">
  $(document).ready(function(){
    $('#EliminadosGeneral').pagination();
    getall();
    llenarProveedor();
  })
  function llenarinfo(id){
      $.ajax({
        type:'POST',
        url:'/Modelos/modeloInventario.php',
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
        url: '/Modelos/modeloInventario.php',
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
      url: '/Modelos/modeloInventario.php',
      data:{accion:1},
      success:function(data){
        $('table tbody#General').empty();
        $('table tbody#General').append(data);
        $('#VGeneral').DataTable();

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
  function llenarProveedor(){
    $.ajax({
      type: 'POST',
      url: '/Modelos/modeloInventario.php',
      data:{accion:6},
      success:function(data){
        $('#proveedor').empty();
        $('#proveedor').append(data);
        $('select').formSelect();
      }
    })
  }

  function reiniciar() {
    $('input[type="text"],input[type="number"],input[type="email"]').val("");
    $('.modal').modal('close');
    reiniciarTablas()
    getall();
  }
  function edit(){
    data = $('#formEditar').serialize();
    $.ajax({
      type:'POST',
      url:'/Modelos/modeloInventario.php',
      data:data,
      success:function(data){
        reiniciar();
        M.toast({html: data});
      }
    })

  }

  function cargarEliminados(){
    $.ajax({
      type: 'POST',
      url: '/Modelos/modeloInventario.php',
      data:{accion:7},
      success:function(data){
        $('table tbody#eliminados').empty();
        $('table tbody#eliminados').append(data);
        $('#EliminadosGeneral').DataTable();
      }
    })
  }
  function eliminar(id) {
    $.ajax({
      type:'POST',
      url:'/Modelos/modeloInventario.php',
      data: {id:id,accion:5},
      success:function(data){
        reiniciarTablas();
        getall();
        M.toast({html: data});
      }
    })
  }
  function reiniciarTablas(){
    $('table').DataTable().destroy();
  }
  function reactivar(id) {
    $.ajax({
      type:'POST',
      url:'/Modelos/modeloInventario.php',
      data: {id:id,accion:8},
      success:function(data){
        M.toast({html: data});
        reiniciarTablas();
        getall();
        cargarEliminados();
      }
    })
  }
</script>
<?php
include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php";
 ?>
