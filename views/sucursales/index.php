<?php
  $titulo ="Administracion de sucursales";
  include $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

  <div class="container-fluid">
    <div class="row">
      <div class="col m6 s12">
        <div class="card">
          <h5 class="card-title headerCard"></h5>
          <div class="card-content">
            <table class="responsive-table centered ">
              <thead>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Acciones</th>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col m6 s12">
        <div class="card">
          <h5 class="card-title headerCard"></h5>
          <div class="card-content">
            <div class="row">
              <div class="col m12 s12">
                <span class="helper-text right" style="margin-right:1%;"><a href="/almacen.php">Crear nuevo almacen</a></span>
              </div>
              <div class="col m12 s12">
                <form action="Javascript:Crear()" id="formCrear">
                  <div class="col m6 s12 input-field">
                    <input type="hidden" name="accion" value="2">
                    <input type="text" name="nombre" value="" id="nombre" required placeholder="Nombre tienda">
                  </div>
                  <div class="col m6 s12 input-field">
                    <select class="" id="almacenes" name="almacen[]" multiple></select>
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="r_social" value="" required placeholder="Razon social">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="rfc" value="" required placeholder="RFC">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="calle" value="" required placeholder="Calle">
                  </div>
                  <div class="col m3 s12 input-field">
                    <input type="text" name="exterior" value="" required placeholder="No.Exterior">
                  </div>
                  <div class="col m3 s12 input-field">
                    <input type="text" name="interior" value="" required placeholder="No.Interior">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="colonia" value="" required placeholder="Colonia">
                  </div>
                  <div class="col m2 s12 input-field">
                    <input type="text" name="cp" value="" required placeholder="C.P.">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="municipio" value="" required placeholder="Municipio">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="estado" value="" required placeholder="Estado">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="phone" name="telefono" maxlength="10" value=""  required placeholder="Telefono">
                  </div>
                  <div class="col m12 s12 input-field">
                    <input type="email" name="email" value=""  required placeholder="Email">
                  </div>
                  <div class="col m12 s12">
                    <button type="submit" class="btn-large green" name="button">Crear tienda</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<div id="editModal" class="modal">
  <h5 class="headerModal">Editar tienda</h5>
 <div class="modal-content">
   <div class="row">
     <form action="Javascript:edit()" id="formEditar"></form>
   </div>
 </div>
 <div class="modal-footer"></div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    getall();
    llenarAlmacen();
  })
  function llenarAlmacen() {
    $.ajax({
      type: 'POST',
      url: '/Modelos/modeloTienda.php',
      data:{accion:6},
      success:function(data){
        $('#almacenes').empty();
        $('#almacenes').append(data);
        $('select').formSelect();
      }
    })
  }
  function llenarinfo(id){
      $.ajax({
        type:'POST',
        url:'/Modelos/modeloTienda.php',
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
        url: '/Modelos/modeloTienda.php',
        data:data,
        success:function(data){
          if (data != 1) {
            // reiniciar();
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
      url: '/Modelos/modeloTienda.php',
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
      url:'/Modelos/modeloTienda.php',
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
      url:'/Modelos/modeloTienda.php',
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
