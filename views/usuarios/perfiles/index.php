<?php
$titulo ="Administracion de perfiles";
  include $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
  <div class="container-fluid">
    <div class="row">
      <div class="col s12 m6">
        <div class="card z-depth-1">
          <h5 class="card-title headerCard"></h5>
          <div class="card-content">
            <table class="responsive-table centered ">
              <thead>
                <th>#Perfil</th>
                <th>Perfil</th>
                <th>Acciones</th>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col s12 m6">
        <div class="card z-depth-1">
          <h5 class="card-title headerCard"></h5>
          <div class="card-content">
            <div class="row">
              <form action="Javascript:Crear()" id="formCrear">
                <div class="input-field col m9 s12" >
                  <input type="hidden" name="accion" value="2">
                  <input type="text" name="perfil" value="" id="perfil" required placeholder="Nombre del nuevo Perfil">
                </div>
                <div class="input-field col m3 s12 right-align">
                  <input type="submit" class="btn green" name="" value="Crear Perfil">
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
   <h4>Editar Perfil</h4>
   <div class="divider"></div>
   <div class="row" id="formEditarRow">
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
        url:'/Modelos/modeloPerfil.php',
        data:{id:id,accion:3},
        success:function(data){
          $('#formEditarRow').empty();
          $('#formEditarRow').append(data);
        }
      })
    }
  function Crear(){
    data = $('#formCrear').serialize();
      $.ajax({
        type: 'POST',
        url: '/Modelos/modeloPerfil.php',
        data:data,
        success:function(data){
          if (data != 1) {
            reiniciar();
            M.toast({html: 'Creado Correctamente'});
          }else {
            M.toast({html: 'Ya existe un perfil con ese nombre'});
          }
        }
      })
  }
  function getall(){
    $.ajax({
      type: 'POST',
      url: '/Modelos/modeloPerfil.php',
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
      url:'/Modelos/modeloPerfil.php',
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
      url:'/Modelos/modeloPerfil.php',
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
