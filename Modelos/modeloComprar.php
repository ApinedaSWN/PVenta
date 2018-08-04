<?php
  include '../includes/conexion.php';
  switch ($_POST['accion']) {
    case '1':
      echo llenarProductos($_POST['proveedor']);
      break;
    case '2':
      echo agregarProducto($_POST['producto']);
      break;
    case '3':
      echo guardar($_POST['id'],$_POST['total'],$_POST['cantidad']);
      break;
    case '4':
      getAll();
      break;
    case '5':
      llenarCompra($_POST['doc']);
      break;
    default:
      // code...
      break;
  }

function getAll()
  {
    global $conexion;
    $compras = $conexion->query('SELECT
      id_documento,
      proveedor.nombre as proveedor,
      tienda.nombre as tienda,
      CONCAT(usuario.nombre ," ",usuario.apellido) as usuario,
      ticket,
      factura,
      subtotal,
      iva,
      total
      FROM documento
      INNER JOIN proveedor on documento.id_proveedor = proveedor.id_proveedor
      INNER JOIN usuario on documento.id_usuario = usuario.id_usuario
      INNER JOIN tienda on documento.id_tienda = tienda.id_tienda
      WHERE id_tipoDocumento = 1
      ORDER BY id_documento DESC');

      while ($compra = $compras->fetch_array(MYSQLI_ASSOC)) {
      ?>
        <tr>
          <td><?php echo $compra['id_documento'] ?></td>
          <td><?php echo $compra['proveedor'] ?></td>
          <td><?php echo $compra['tienda'] ?></td>
          <td><?php echo $compra['usuario'] ?></td>
          <td><?php echo $compra['ticket'] ?></td>
          <td><?php echo $compra['factura'] ?></td>
          <td><?php echo $compra['subtotal'] ?></td>
          <td><?php echo $compra['iva'] ?></td>
          <td><?php echo $compra['total'] ?></td>
          <td><button class="btn-flat modal-trigger" data-target="modalCompra"  onclick="llenarCompra(<?php echo $compra['id_documento'] ?>)"><i class="material-icons">remove_red_eye</i></button></td>
        </tr>
      <?php
      }
  }
function llenarProductos($proveedor)
  {
    global $conexion;
    $productos = $conexion->query('SELECT * FROM producto where id_proveedor = '.$proveedor)or die('No se encontraron productos');
    echo "<option value='' selected>Selecciona un producto</option>";
    while ($producto = mysqli_fetch_array($productos)) {
      echo "<option value='".$producto['id_producto']."'>".$producto['producto']."</option>";
    }
  }
function agregarProducto($producto)
  {
    global $conexion;
    $productos = $conexion->query('SELECT * FROM producto where id_producto = '.$producto)or die('No se encontraron productos');
    $producto = mysqli_fetch_array($productos);

    echo
    "<tr>
      <td>
      <div class='col m12 s12 input-field'>
        <input name='id[]' type='text' class='center-align' readonly value='".$producto['id_producto']."' />
      </div>
      </td>
      <td>
      <input name='cantidad[]' type='text' class='center-align' readonly value='".$_POST['cantidad']."' />
      </td>
      <td>
        ".$producto['producto']."
      </td>
      <td>
      ".$_POST['precio']."
      </td>
      <td>
      <div class='col m12 s12 input-field center-aling'>
      <input name='total[]' type='text' class='center-align' class='center-align' value='".$_POST['precio'] * $_POST['cantidad']."' />
      </div>

      </td>
      <td>
        <div class='col m12 s12 input-field'><button class='btn-flat red-text del'><i class='material-icons' style='font-size: 2em;'>delete</i></button></div>
      </td>
    </tr>";
  }
function guardar($productos,$totales,$cantidades)
  {
    global $conexion;
    $total = array_sum($totales);
    $iva = $total * 0.16;
    $subtotal = $total - $iva;

        $values = "'',
                  ".$_POST['proveedor'].
                  ",".$_POST['usuario'].
                  ",".$_POST['tienda'].
                  ",1".
                  ",'".$_POST['ticket'].
                  "','".$_POST['factura'].
                  "',".$subtotal.
                  ",".$iva.
                  ",".$total.
                  ", CURRENT_TIMESTAMP,CURRENT_TIMESTAMP";

        if($conexion->query("INSERT INTO documento VALUES(".$values.")"))
        {
          $documento = $conexion->insert_id;
          $numProd = count($productos);
          for ($i=0; $i < $numProd ; $i++) {
            $valuesArray = "$productos[$i],$documento,$cantidades[$i],$totales[$i]";
            $conexion->query("INSERT INTO movimientosproducto(id_producto,id_documento,cantidad,costo) VALUES(".$valuesArray.")");
            $inventario = $conexion->query('SELECT inventario FROM producto WHERE id_producto ='.$productos[$i]);
            $cantidad = $inventario->fetch_array(MYSQLI_ASSOC);
            $conexion->query('UPDATE `producto` SET `inventario` = '.($cantidad['inventario'] + $cantidades[$i]).' WHERE `producto`.`id_producto` = '.$productos[$i]);
          }
          echo "Compra creada, correctamente";
        }else {
          echo "Ocurrio un error al guardar la compra";
        }


  }
function llenarCompra($documento)
  {
  global $conexion;
  $compras = $conexion->query('SELECT
                                proveedor.nombre as pnom,
                                proveedor.direccion as pdir,
                                proveedor.telefono as ptel,
                                proveedor.email as pemail,
                                proveedor.contacto as pcont,
                                tipo_documento.documentoTipo as doct,
                                tienda.nombre as tnom,
                                tienda.direccion as tdir,
                                perfil.perfil as perfil,
                                CONCAT(usuario.nombre," ",usuario.apellido) as usuario,
                                documento.created_at as creacion,
                                documento.total,
                                documento.subtotal,
                                documento.iva,
                                documento.ticket,
                                documento.factura
                                FROM documento
                                INNER JOIN proveedor on documento.id_proveedor = proveedor.id_proveedor
                                INNER JOIN usuario on documento.id_usuario = usuario.id_usuario
                                INNER JOIN perfil on usuario.t_usuario_id = perfil.id_perfil
                                INNER JOIN tienda on documento.id_tienda = tienda.id_tienda
                                INNER JOIN tipo_documento on documento.id_tipoDocumento = tipo_documento.id_documento_tipo
                                WHERE id_documento ='.$documento);

                                if ($compras->num_rows > 0) {
                                  $compra = $compras->fetch_array(MYSQLI_ASSOC);


                ?>
                <h5 class="headerCard" style="margin:0;">Detalle de la compra</h5>
                <div class="modal-content">
                   <div class="row">
                     <div class="col m6 s12">
                       <div class="card">
                         <div class="card-content">
                           <div class="row">
                             <table>
                               <thead>
                                 <th>Producto</th>
                                 <th>Unidades</th>
                                 <th>Total Pagado</th>
                               </thead>
                               <tbody>
                                 <?php
                                    if ($productos = $conexion->query('SELECT * FROM movimientosproducto
                                                                    INNER JOIN producto on movimientosproducto.id_producto = producto.id_producto
                                                                    WHERE id_documento ='.$documento)) {
                                      if ($productos->num_rows > 0) {
                                        while ($producto = $productos->fetch_array(MYSQLI_ASSOC)) {
                                          ?>
                                          <tr>
                                            <td><?php echo $producto['producto'] ?></td>
                                            <td><?php echo $producto['cantidad'] ?></td>
                                            <td>$ <?php echo $producto['costo'] ?></td>
                                          </tr>
                                          <?php
                                        }
                                      }
                                    }

                                  ?>
                               </tbody>
                             </table>
                             <table>
                               <tr>
                                 <td class="right-align"><b>Subtotal: </b> $ <?php echo $compra['subtotal'] ?></td>
                               </tr>
                               <tr>
                                 <td class="right-align"><b>IVA 16%: </b>$ <?php echo $compra['iva'] ?></td>
                               </tr>
                               <tr>
                                 <td class="right-align"><b>Total: </b>$ <?php echo $compra['total'] ?></td>
                               </tr>
                             </table>


                           </div>
                         </div>
                       </div>
                     </div>
                     <div class="col m6 s12">
                       <div class="card">
                         <div class="card-content">

                           <div class="row">
                             <div class="col m12 s12">
                               <h5 class="headerCard">Datos del Proveedor</h5>
                             </div>
                             <div class="col m6 s12 center-align"><b>Ticket: </b><?php echo $compra['ticket'] ?></div>
                             <div class="col m6 s12 center-align"><b>Factura: </b><?php echo $compra['factura'] ?></div>
                             <div class="col m12 s12">
                               <h5><?php echo $compra['pnom'] ?></h5>
                             </div>
                             <div class="col m12 s12">
                               <?php echo $compra['ptel'] ?>
                             </div>
                             <div class="col m12 s12">
                               <?php echo $compra['pemail'] ?>
                             </div>

                             <div class="col m12 s12">
                               <?php echo $compra['pdir'] ?>
                             </div>
                             <div class="col m12 s12"><?php echo $compra['creacion'] ?></div>
                             <div class="col m12 s12">
                               <h5 class="headerCard">Datos del Usuario</h5>
                             </div>
                             <div class="col m12 s12">

                               <h5><?php echo $compra['usuario'] ?></h5></div>
                             <div class="col m12 s12"><?php echo $compra['tnom'] ?></div>
                             <div class="col m12 s12"><?php echo $compra['perfil'] ?></div>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
                </div>
                                <?php
                              }

  }

?>
