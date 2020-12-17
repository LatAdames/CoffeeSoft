<div class="row">
	<div class="col-md-12">
	<a href="index.php?view=sell" class="btn btn-default btn-lg pull-right"><i class="glyphicon glyphicon-chevron-left"></i> Venta con factura </a>
	<h1>Venta sin factura</h1>
	<p><b>Buscar producto por nombre o por codigo:</b></p>
		<form>
		<div class="row">
			<div class="col-md-6">
				<input type="hidden" name="view" value="selln">
				<input type="text" name="product" class="form-control">
			</div>
			<div class="col-md-3">
			<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
			</div>
		</div>
		</form>
	</div>

<?php if(isset($_GET["product"])):?>
	<?php
$products = ProductData::getLike($_GET["product"]);
if(count($products)>0){
	?>
<h3>Resultados de la Busqueda</h3>
<table class="table table-bordered table-hover">
	<thead>
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Unidad</th>
		<th>Precio unitario</th>
		<th>En inventario</th>
		<th>Cantidad</th>
		<th style="width:100px;"></th>
	</thead>
	<?php
$products_in_cero=0;
	 foreach($products as $product):
$q= OperationData::getQNoF($product->id,$cut->id);
	?>
	<?php 
	if($q>0):?>
		<form method="post" action="index.php?view=addtocartn">
	<tr class="<?php if($q<=5){ echo "danger"; }?>">
		<td style="width:80px;"><?php echo $product->id; ?></td>
		<td><?php echo $product->name; ?></td>
		<td><?php echo $product->unit; ?></td>
		<td><b>$<?php echo $product->price_out; ?></b></td>
		<td>
			<?php echo $q; ?>
		</td>
		<td>
		<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
		<input type="" class="form-control" required name="q" placeholder="Cantidad de producto ..."></td>
		<td style="width:183px;">
		<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i> Agregar a la venta</button>
		</td>
	</tr>
	</form>
<?php else:$products_in_cero++;
?>
<?php  endif; ?>
	<?php endforeach;?>
</table>
<?php if($products_in_cero>0){ echo "<p class='alert alert-warning'>Se omitieron <b>$products_in_cero productos</b> que no tienen existencias en el inventario. <a href='index.php?module=inventary'>Ir al Inventario</a>"; }?>

	<?php
}
?>
<br><hr>
<hr><br>
<?php else:
?>

<?php endif; ?>

<?php if(isset($_SESSION["errorsn"])):?>
<h2>Errores</h2>
<p></p>
<table class="table table-bordered table-hover">
<tr class="danger">
	<th>Codigo</th>
	<th>Producto</th>
	<th>Mensaje</th>
</tr>
<?php foreach ($_SESSION["errorsn"]  as $error):
$product = ProductData::getById($error["product_id"]);
?>
<tr class="danger">
	<td><?php echo $product->id; ?></td>
	<td><?php echo $product->name; ?></td>
	<td><b><?php echo $error["message"]; ?></b></td>
</tr>

<?php endforeach; ?>
</table>
<?php
unset($_SESSION["errorsn"]);
 endif; ?>


<!--- Carrito de compras :) -->
<?php if(isset($_SESSION["cartn"])):
$total = 0;
?>
<h2>Lista de venta</h2>
<table class="table table-bordered table-hover">
<thead>
	<th style="width:30px;">Codigo</th>
	<th style="width:30px;">Cantidad</th>
	<th style="width:30px;">Unidad</th>
	<th>Producto</th>
	<th style="width:30px;">Precio Unitario</th>
	<th style="width:30px;">Precio Total</th>
	<th ></th>
</thead>
<?php foreach($_SESSION["cartn"] as $p):
$product = ProductData::getById($p["product_id"]);
?>
<tr >
	<td><?php echo $product->id; ?></td>
	<td ><?php echo $p["q"]; ?></td>
	<td><?php echo $product->unit; ?></td>
	<td><?php echo $product->name; ?></td>
	<td><b>$ <?php echo number_format($product->price_out); ?></b></td>
	<td><b>$ <?php  $pt = $product->price_out*$p["q"]; $total +=$pt; echo number_format($pt); ?></b></td>
	<td style="width:30px;"><a href="index.php?view=clearcartn&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
</tr>

<?php endforeach; ?>
</table>
<h2>Resumen</h2>
<div class="row">
<div class="col-md-6 col-md-offset-6">
<table class="table table-bordered">
<tr>
	<td><p>Subtotal</p></td>
	<td><p><b>$ <?php echo number_format($total*.84); ?></b></p></td>
</tr>
<tr>
	<td><p>IVA</p></td>
	<td><p><b>$ <?php echo number_format($total*.16); ?></b></p></td>
</tr>
<tr>
	<td><p>Total</p></td>
	<td><p><b>$ <?php echo number_format($total); ?></b></p></td>
</tr>

</table>
<form method="post" action="index.php?view=processselln">
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <div class="checkbox">
        <label>
          <input name="is_oficial" type="hidden" value="0">
        </label>
      </div>
    </div>
  </div>
<div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <div class="checkbox">
        <label>
		<a href="index.php?view=clearcartn" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
        <button class="btn btn-lg btn-primary"><i class="glyphicon glyphicon-usd"></i><i class="glyphicon glyphicon-usd"></i> Finalizar Venta</button>
        </label>
      </div>
    </div>
  </div>
</form>

</div>
</div>

<br><br><br><br><br>
<?php endif; ?>

</div>