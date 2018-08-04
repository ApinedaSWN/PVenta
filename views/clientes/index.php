<?php
  include $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

  <div class="container-fluid">
    <div class="fixed-action-btn">
      <a href="#crearModal" class="btn-floating btn-large green modal-trigger"><i class="material-icons">add</i></a>
    </div>


    <div class="row">
      <div class="col m6 s12">
        <div class="card">
          <h5 class="card-title headerCard right-align"></h5>
          <div class="card-content">
            <table class="responsive-table centered ">
              <thead>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>RFC</th>
                <th>Acciones</th>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col m6 s12">
        <div class="card">
          <h5 class="headerCard"></h5>
          <div class="card-content">
            <div class="row">
              <div class="col m12 s12">
                <p><b>Recuerda:</b> Crear un tipo de cliente <a href="tipo_cliente.php" class="blue-text">aqui</a></p>
              </div>
            </div>
            <div class="row">
              <div class="col m12 s12">
                <form action="Javascript:Crear()" id="formCrear">
                  <input type="hidden" name="accion" value="2">
                  <input type="hidden" name="usuario" value="<?php echo $_SESSION['id_usuario'] ?>" id="usuario" readonly>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="nombre" value="" required placeholder="Nombre cliente">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="r_social" value="" required placeholder="Razon Social">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="rfc" value="" required placeholder="RFC">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="calle" value="" required placeholder="Calle">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="exterior" value="" required placeholder="No.Exterior">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="interior" value="" required placeholder="No.Interior">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="colonia" value="" required placeholder="Colonia">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="municipio" value="" required placeholder="Delegacion o Municipio">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="text" name="estado" value="" required placeholder="Estado">
                  </div>
                  <div class="col m4 s12 input-field">
                    <input type="phone" name="telefono" maxlength="10" value="" id="telefono" required placeholder="Telefono">
                  </div>
                  <div class="col m8 s12 input-field">
                    <input type="email" name="email" value=""  required placeholder="Correo electronico">
                  </div>
                  <div class="col m6 s12 input-field">
                     <select class="" name="tienda" id="tienda"></select>
                  </div>
                  <div class="col m6 s12 input-field">
                     <select class="" name="t_cliente" id="t_cliente" placeholder="Tipo de cliente"></select>
                  </div>
                  <div class="col m12 s12 input-field">
                    <input class="btn-large green right" type="submit" name="enviar" value="Crear Cliente">
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
  <h5 class="headerModal">Editar Cliente</h5>
 <div class="modal-content">
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
    llenarTiendas();
    llenartCliente();
  })
  function llenarinfo(id){
      $.ajax({
        type:'POST',
        url:'/Modelos/modeloCliente.php',
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
        url: '/Modelos/modeloCliente.php',
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
      url: '/Modelos/modeloCliente.php',
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
  function llenartCliente(){
    $.ajax({
      type: 'POST',
      url: '/Modelos/modeloCliente.php',
      data:{accion:6},
      success:function(data){
        $('#t_cliente').empty();
        $('#t_cliente').append(data);
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
      url:'/Modelos/modeloCliente.php',
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
      url:'/Modelos/modeloCliente.php',
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
