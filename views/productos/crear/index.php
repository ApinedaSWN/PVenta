<?php
  include $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
<div class="row">
  <div class="col s12 m12">
    <div class="card">
      <h5 class="card-title headerCard"></h5>
      <div class="card-content">
        <div class="card-tabs">
     <ul class="tabs tabs-fixed-width black-text">
       <li class="tab"><a class="active" href="#principales">Principales</a></li>
       <li class="tab"><a href="#opcionales">Opcionales</a></li>
       <li class="tab"><a href="#precios">Precios</a></li>
       <li class="tab"><a href="#almacenes">Almacenes</a></li>
     </ul>
   </div>
   <div class="card-content">
     <div id="principales">
       <div class="row">
         <div class="col s12 m4 l3 input-field">
           <input type="text" name="" value="" placeholder="Codigo">
         </div>
         <div class="col s12 m4 l3 input-field">
           <input type="text" name="" value="" placeholder="Nombre">
         </div>
         <div class="col s12 m4 l2 input-field">
           <input type="text" name="" value="" placeholder="Costo Inicial">
         </div>
         <div class="col s12 m4 l2 input-field">
           <input type="text" name="" value="" placeholder="Costeo">
         </div>
         <div class="col s12 m4 l1 input-field">
           <input type="text" name="" value="MXN" readonly>
         </div>
         <div class="col s12 m4 l1 input-field">
           <input type="text" name="" value="16%" readonly>
         </div>
         <div class="col s12 m4 l3 input-field">
           <select class="" name="">
             <option value="">Clave CFDI</option>
           </select>
         </div>
         <div class="col s12 m4 l3 input-field">
           <select class="" name="">
             <option value="">Unidad CFDI</option>
           </select>
         </div>
         <div class="col s12 m4 l3 input-field">
           <input type="text" name="" value="" placeholder="Tipo">
         </div>
         <div class="col s12 m4 l3 input-field">
           <input type="text" name="" value="" placeholder="Unidad de Medida">
         </div>
         <div class="col s12 m12 l12 input-field">
           <textarea name="name" class="materialize-textarea" rows="8" cols="80" placeholder="Descripcion"></textarea>
         </div>
       </div>
     </div>
     <div id="opcionales">
       <div class="row">
         <div class="col s12 m4 l3 input-field">
           <input type="text" name="" value="" placeholder="SKU">
         </div>
         <div class="col s12 m4 l3 input-field">
           <input type="text" name="" value="" placeholder="Tiempo de surtido">
         </div>
         <div class="col s12 m4 l2 input-field">
           <input type="text" name="" value="" placeholder="Volumen">
         </div>
         <div class="col s12 m4 l2 input-field">
           <input type="text" name="" value="" placeholder="Peso">
         </div>
         <div class="col s12 m4 l1 input-field" placeholder="ieps">
           <input type="text" name="" value="" >
         </div>
         <div class="col s12 m4 l1 input-field" placeholder="tiempo de compra">
           <input type="text" name="" value="">
         </div>
         <div class="col s12 m4 l3 input-field">
           <select class="" name="">
             <option value="">Categoria 1</option>
           </select>
         </div>
         <div class="col s12 m4 l3 input-field">
           <select class="" name="">
             <option value="">Categoria 2</option>
           </select>
         </div>
         <div class="col s12 m4 l3 input-field">
           <select class="" name="">
             <option value="">Categoria 3</option>
           </select>
         </div>
         <div class="col s12 m12 l12 input-field">
          <label>
            <input type="checkbox" />
            <span>Produccion automatica</span>
          </label>
         </div>
       </div>
     </div>
     <div id="precios">
       <div class="row">
         <div class="col s12 m6 l6 input-field">
           <select class="" name="">
             <option value="">Lista a asignar</option>
           </select>
         </div>
         <div class="col s12 m6 l6 input-field">
           <select class="" name="">
             <option value="">Tipo</option>
           </select>
         </div>
         <div class="col s12 m4 l4 input-field">
           <input type="text" name="" value="" placeholder="Minimo">
         </div>
         <div class="col s12 m4 l4 input-field">
           <input type="text" name="" value="" placeholder="Maximo">
         </div>
         <div class="col s12 m4 l4 input-field">
           <input type="text" name="" value="" placeholder="Valor">
         </div>
       </div>
     </div>
     <div id="almacenes">
       <div class="row">
         <div class="col s12 m4 l2 input-field">
           <select class="" name="">
             <option value="">Almacen</option>
           </select>
         </div>
         <div class="col s12 m2 l2 input-field">
           <input type="text" name="" value="" placeholder="Minimo">
         </div>
         <div class="col s12 m2 l2 input-field">
           <input type="text" name="" value="" placeholder="Maximo">
         </div>
         <div class="col s12 m2 l2 input-field">
           <input type="text" name="" value="" placeholder="inventario inicial">
         </div>
         <div class="col s12 m2 l2 input-field">
           <input type="text" name="" value="" placeholder="inventario actual">
         </div>
         <div class="col m2 s2 l1 center-alig valign-wrapper">
           <a href="#opcionales" class="btn-floating green" style="width:30px; height:30px;"><i class="material-icons" style="line-height:30px">add</i></a>
         </div>
         <div class="col m12 s12 l12 right-align">
           <a href="#opcionales" class="btn green">Guardar</a>
         </div>

       </div>
     </div>

   </div>
      </div>
    </div>
  </div>
</div>

  <?php
    include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php";
  ?>
