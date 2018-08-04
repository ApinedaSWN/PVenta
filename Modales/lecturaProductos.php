<!-- Modal Structure -->
<div id="productos" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4>Cargar productos comprados</h4>
    <div class="row">
      <div class="input-field col m3 s12">
        <select class="" name="producto" id="producto" disabled>
              <option value="" selected disabled>Antes debes seleccionar un proveedor</option>
        </select>
        <label for="producto">Producto</label>
      </div>
      <div class="input-field col m3 s12">
        <input type="number" name="cantidad" value="" min="0">
        <label for="Cantidad">Cantidad</label>
      </div>
      <div class="input-field col m3 s12">
        <input type="number" name="precio" value="" min="0">
        <label for="Precio">Precio de compra unitario</label>
      </div>
      <div class="input-field col m3 s12 right-align">
        <input type="button" class="btn green" onclick="agregarProducto()" name="producto" value="Agregar Producto">
      </div>
    </div>

    <table class="striped highlight centered">
      <thead>
        <th>Numero Producto</th>
        <th>Cantidad</th>
        <th>Producto</th>
        <th>Precio de compra unitario</th>
        <th>Total</th>
        <th>Eliminar</th>
      </thead>
      <tbody id="tRes"></tbody>
    </table>
    <div class="row" style="margin:0;">
      <div class="col m12 s12 right-align" style="margin:0; padding:0;" id="totalCompra">
        <p id="total"></p>
      </div>
      <div class="col m12 s12 center-align">
        <input type="hidden" name="accion" value="3">
        <button type="submit" class="btn blue btnform modal-close" disabled>Guardar Compra</button>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-red red-text btn-flat ">Cancelar</a>
  </div>
</div>
