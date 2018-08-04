<div id="ventaRapida" class="modal">
  <div class="modal-content">
    <div class="row">
      <div class="col m8 s12 ">
        <div class="card z-depth-3">
          <h5 class="card-title headerCard">Ticket de venta</h5>
          <div class="card-content">
            <div class="row">
              <div class="col m12 s12 center-align">
                <h5>Mostrador - <?php echo $dato['tienda']; ?></h5>
                <p><?php echo $dato['tDir'] ?>, <?php echo $dato['tTel'] ?></p>
                <p><b>Vendedor:</b> <?php echo $dato['usuario'] ?></p>
              </div>
              <div class="col m12 s12">
                <div class="divider" style="margin:24px;"></div>
              </div>
            </div>
            <div class="row">
              <table>
                <thead>
                  <th>Cantidad</th>
                  <th>Producto</th>
                  <th>Unitario</th>
                  <th>Total</th>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col m4 s12">
        <div class="card">
          <h5 class="card-title headerCard">Caraga de producto</h5>
          <div class="card-content">
            <div class="row">
              <div class="col m12 s12 input-field">
                <i class="material-icons prefix">format_list_bulleted</i>
                <input type="text" id="producto" class="autocomplete" name="producto" value="" autocomplete="off">
                <label for="producto">Producto</label>
              </div>
              <div class="col m12 s12 input-field">
                <i class="material-icons prefix">format_list_bulleted</i>
                <input type="text" id="cantidad" class="autocomplete" name="cantidad" value="">
                <label for="cantidad">Cantidad</label>
              </div>
              <div class="col m12 s12 right-align">
                <button type="button" class="btn green" name="button">Listar producto</button>
              </div>
              <div class="col m12 s12 input-field"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
      type:'POST',
      url:'Modelos/modeloVender.php',
      data:{accion:1},
      success:function(resp){
        alert(resp);
        resp = resp.toString();
        $('input.autocomplete').autocomplete({
          data: {resp},
        });
      }
    })
  })
</script>
