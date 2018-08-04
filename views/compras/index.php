<?php
  include $_SERVER['DOCUMENT_ROOT'].'/includes/header.php';
 ?>

  <div class="container-fluid">
    <div class="row">
      <div class="col m12 s12">
        <div class="card">
          <h5 class="card-title headerCard">Crear documento de compra</h5>
          <div class="card-content">
            <form class="" action="Javascript:guardarCompra()" id="formGuardarCompra" method="post">
              <?php include 'Modales/lecturaProductos.php'; ?>
              <div class="row">
                <div class="col m4 s12 input-field">
                  <input type="hidden" name="usuario" value="<?php echo $_SESSION['id'] ?>">
                  <select class="" name="proveedor" id="proveedor">
                    <option value="">Selecciona un proveedor</option>
                    <?php
                      $proveedores = $conexion->query('SELECT * FROM proveedor WHERE estatus = 0');
                      while ($proveedor = mysqli_fetch_array($proveedores)) {
                        echo "<option value='$proveedor[id_proveedor]'>$proveedor[nombre]</option>";
                      }
                     ?>
                  </select>
                  <label for="">Proveedor</label>
                </div>
                <div class="col m4 s12 input-field">
                  <select class="" name="tienda">
                    <option value="" selected readonly>Selecciona una tienda</option>
                    <?php
                      $tiendas = $conexion->query('SELECT * FROM tienda where estatus = 0');
                      while ($tienda = mysqli_fetch_array($tiendas)) {
                        echo "<option value='$tienda[id_tienda]'>$tienda[nombre]</option>";
                      }
                     ?>
                  </select>
                  <label for="">Tienda</label>
                </div>
                <div class="col m4 s12 input-field">
                  <input type="text" name="ticket" value="">
                  <label for="">Ticket</label>
                </div>
                <div class="col m4 s12 input-field">
                  <input type="text" name="factura" value="">
                  <label for="">Factura</label>
                </div>
                <div class="col m12 s12 input-field right-align">
                  <a class="waves-effect waves-light green btn modal-trigger" href="#productos">Llenar productos</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col m12 s12">
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col m12 s12">
                <table id="vistaGeneral">
                  <thead >
                    <th>#Compra</th>
                    <th>Proveedor</th>
                    <th>Tienda</th>
                    <th>Usuario</th>
                    <th>Ticket</th>
                    <th>Factura</th>
                    <th>Subtotal</th>
                    <th>IVA</th>
                    <th>Total</th>
                    <th>Ver</th>
                  </thead>
                  <tbody id="VerGeneral"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

 <div id="modalCompra" class="modal"></div>
<script type="text/javascript">
  $(document).ready(function(){
    getAll();
  })
  function getAll() {
    $.ajax({
      type:'POST',
      url:'/Modelos/modeloComprar.php',
      data:{accion:4},
      success:function(resp){
        $('#VerGeneral').empty();
        $('#VerGeneral').append(resp);
        if (resp != "") {
          $('#vistaGeneral').DataTable({
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.18/i18n/Spanish.json"
          },
          "order": [[ 0, "desc" ]],

          });
        }
      }
    })
  }
  function reiniciarTablas(){
    $('table').DataTable().destroy();
  }
  $('#proveedor').change(function(){
    proveedor = $('#proveedor').val();
    if ( proveedor != "") {
        $.ajax({
          type:'POST',
          url:'/Modelos/modeloComprar.php',
          data:{accion:1,proveedor:proveedor},
          success:function(data){
            $("#producto").prop('disabled',false);
            $("#producto").empty();
            $("#producto").append(data);
            $('select').formSelect();
          }
        })
    }
  })
  $('#producto').change(function(){
    if ($('#producto') != "") {
      $('#proveedor').prop('disabled',true);
    }else {
      $('#proveedor').prop('disabled',false);
    }
  })
  $('table').on('click','.del',function(){
      $(this).parents('tr').remove().ready(function(){
        sumarTotal();
      });
      if ($('table tr').length <= 1) {
        $('.tablaNota').css({'display':'none'});
      }
  })
  function reiniciar(){
    $('#tRes').empty();
    $('input[type="text"],input[type="number"]').val("");
    $('select').val('0');
    $('select').formSelect();
    $('#total').empty();
    reiniciarTablas();
    getAll();
    }
  function agregarProducto() {
    if ($('#proveedor').val() == '') {
      M.toast({html:'Selecciona un proveedor'});
    }else if ($('#producto').val() == '') {
      M.toast({html:'Selecciona un producto'});
    }else if ($('input[name="precio"]').val() == '') {
      M.toast({html:'Especifica un precio de compra(Cuanto te costo)'});
    }else if ($('input[name="cantidad"]').val() == '') {
      M.toast({html:'Debes Especificar una cantidad, ¿Cuanto compraste?'});
    }else {
      producto = $('#producto').val();
      cantidad = $('input[name="cantidad"]').val();
      precio = $('input[name="precio"]').val();
      $.ajax({
        type:'POST',
        url:'/Modelos/modeloComprar.php',
        data:{producto:producto,cantidad:cantidad,accion:2,precio:precio},
        success:function(resp){
          $('#tRes').append(resp).ready(function(){
            $('#proveedor').prop('disabled',true);
            $('select').formSelect();
            sumarTotal();
            $('.tablaNota').css({'display':'block'});
            $('.btnform').prop('disabled',false);
          });
        }
      })
    }
  }
  function sumarTotal(){
    total = 0;
    $('input[name="total[]"]').each(function(){
      total = total + parseFloat($( this ).val());
      mensaje = "<p id='total'><b>Total: </b>$ "+total+'</p>';
      $('#totalCompra').empty();
      $('#totalCompra').append(mensaje);
    }).get();
  }
  function guardarCompra(){
    $('#proveedor').prop('disabled',false);
    data = $('#formGuardarCompra').serialize();
    $.ajax({
      type:'POST',
      url:'/Modelos/modeloComprar.php',
      data:data,
      success:function(resp){
        alert(resp);
        reiniciar();
      }
    })
  }
  function llenarCompra(doc) {
    $.ajax({
      type:'POST',
      url:'/Modelos/modeloComprar.php',
      data:{accion:5,doc:doc},
      success:function(resp){
        $('#modalCompra').empty();
        $('#modalCompra').append(resp);
      }
    })
  }
</script>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
