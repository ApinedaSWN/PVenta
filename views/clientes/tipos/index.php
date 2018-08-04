<?php
  include $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
  <div class="container-fluid">
    <div class="row">
      <div class="col s12 m6">
        <div class="card">
          <h5 class="card-title headerCard right-align"></h5>
          <div class="card-content">
            <table class="responsive-table centered ">
              <thead>
                <th>#Tipo Cliente</th>
                <th>Tipo Cliente</th>
                <th>Acciones</th>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col s12 m6">
        <div class="card">
          <h5 class="card-title headerCard"></h5>
          <div class="card-content">
            <div class="row">
              <form action="Javascript:Crear()" id="formCrear">
                <div class="input-field col m12 s12" >
                  <input type="hidden" name="accion" value="2">
                  <input type="text" name="nombre" value="" id="nombre" placeholder="Nombre del nuevo Tipo Cliente">
                </div>
                <div class="input-field col m12 s12 right-align">
                  <input type="submit" class="btn-large green" name="" value="Crear TipoCliente">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div id="editModal" class="modal">
 <div class="modal-content">
   <h4>Editar TipoCliente</h4>
   <div class="divider"></div>
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
  })
  function llenarinfo(id){
      $.ajax({
        type:'POST',
        url:'/Modelos/modeloTipoCliente.php',
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
        url: '/Modelos/modeloTipoCliente.php',
        data:data,
        success:function(data){
          if (data != 1) {
            reiniciar();
            M.toast({html: 'Creado Correctamente'});
          }else {
            M.toast({html: 'Ya existe un Tipo de Cliente con ese nombre'});
          }
        }
      })
  }
  function getall(){
    $.ajax({
      type: 'POST',
      url: '/Modelos/modeloTipoCliente.php',
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
      url:'/Modelos/modeloTipoCliente.php',
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
      url:'/Modelos/modeloTipoCliente.php',
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
