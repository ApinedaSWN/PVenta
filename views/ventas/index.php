<?php
  include_once $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
  $datos = $conexion->query('SELECT CONCAT(usuario.nombre," ",usuario.apellido) as usuario, tienda.nombre as tienda, tienda.direccion as tDir,tienda.telefono as tTel FROM usuario INNER JOIN tienda ON usuario.tienda_id = tienda.id_tienda WHERE id_usuario ='.$_SESSION['id_usuario']);
  $dato = $datos->fetch_array(MYSQLI_ASSOC);
  include_once $_SERVER['DOCUMENT_ROOT']."/Modales/ventarapida.php";

 ?>
 <style media="screen">
   #menuVentas > button{
    display: flex;
    height: 500px;
    width: 100%;
    justify-content: center;
    align-items: center;
    color: white;
   }
   #menuVentas > button i{
     font-size: 5em;
   }
   #menuVentas > button {
     font-size: 1.5em;
   }
   .modal{
     width: 90%;
   }
 </style>

   <div class="container-fluid">
     <div class="row" >
       <div class="col m4">
         <div class="card " id="menuVentas">
           <button data-target="ventaRapida" class="btn light-blue darken-4 modal-trigger" type="button" name="button">
             <div class="row">
             <div class="col m12 s12 center-align">
               <i class="material-icons">store</i>
             </div>
             <div class="col m12 s12 center-align">
               Venta Rapida

             </div>
           </div>
           </button>
         </div>
       </div>
       <div class="col m4">
         <div class="card" id="menuVentas">
           <button class="btn orange darken-2" type="button" name="button">
             <div class="row">
             <div class="col m12 s12 center-align">
               <i class="material-icons">people</i>
             </div>
             <div class="col m12 s12 center-align">
               Venta a Cliente
             </div>
           </div>
           </button>
         </div>
       </div>
       <div class="col m4">
         <div class="card" id="menuVentas">
               <button data-target="" class="btn blue-grey darken-2 " type="button" name="button">
                 <div class="row">
                 <div class="col m12 s12 center-align">
                   <i class="material-icons">insert_drive_file</i>
                 </div>
                 <div class="col m12 s12 center-align">
                   Factura Electronica

                 </div>
               </div>
               </button>
         </div>
       </div>
     </div>
   </div>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php"; ?>
