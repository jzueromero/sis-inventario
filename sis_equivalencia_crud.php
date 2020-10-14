<?php
	include("php/conexion.php");
	session_start();
	if(!isset($_SESSION['id_usuario']))
	{
		header("Location: pages-signin.php");
    }

	ini_set('display_errors', 'On');
 
	// Valor por defecto en PHP
	// Muestra todos los errores menos las notificaciones
	error_reporting(E_ALL ^ E_NOTICE);
 
	// Muestro todos los errores
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	error_reporting(E_ALL);
	error_reporting(-1);
 
	// Muestro todos los errores, incluso los estrictos
	error_reporting(E_ALL | E_STRICT);
 
	// No muestra ningún error
	error_reporting(0);
 
	// También se puede usar la función ini_set
	ini_set('error_reporting', E_ALL);

	
	$valor = "CREAR";
	$Requerido = "";
	$SoloLectura = "";

	$id_producto = 0;
    $nombre = "";
    $codigo_barra = "";
    $codigo = "";
    $precio = 0;
	$precio_iva = 0;

	$costo_compra = 0;
	$costo_agregado = 0;
	$costo_total = 0;
	$costo_compra_iva = 0;
	$costo_agregado_iva = 0;
	$costo_total_iva = 0;
	
	$id_unidad_principal =0;
	$id_unidad_utilizada = 0;
	$unidades = 0;
	$id_equivalencia = 0;

	$sqlProducto = "";
	$sqlMedidas = "";




	if(isset($_GET['opcion']) )
	{
		$valor = $_GET['opcion'];
		$id_producto = $_GET['codigo'];
		$id_equivalencia = $_GET['id_eq'];
		$id_unidad_utilizada = $_GET['idunidad'];


		if($valor == "BORRAR")
		{
			$SoloLectura = "readonly";
		}

		if($id_equivalencia == 0 )
		{
			$sqlProducto = "select 0 as id_unidad, '' as nombre_unidad,
							0 as id_equivalencia, 0 cantidad, 0 as e_precio, 0 as e_precio_iva,
							productos.id, productos.codigo as pro_codigo, productos.codigo_barra as pro_codigo_barra, 
							productos.nombre as pro_nombre 
							from productos 
							WHERE productos.id =  '$id_producto' ";
		}
		else
		{
			$sqlProducto = "select unidades.id as id_unidad, unidades.nombre as nombre_unidad, equivalencias.id as id_equivalencia, equivalencias.cantidad, 
							equivalencias.precio as e_precio, equivalencias.precio_iva as e_precio_iva, 
							equivalencias.costo as e_costo, equivalencias.costo_iva as e_costo_iva, 
							equivalencias.costo_agregado as e_costo_agregado, equivalencias.costo_agregado_iva as e_costo_agregado_iva,
							equivalencias.costo_total as e_costo_total, equivalencias.costo_total_iva as e_costo_total_iva,
							productos.id, productos.codigo as pro_codigo, productos.codigo_barra as pro_codigo_barra, productos.nombre as pro_nombre
							from unidades
							inner join equivalencias on equivalencias.id_unidad = unidades.id
							inner join productos on productos.id = equivalencias.id_producto
							WHERE productos.id = '$id_producto' AND equivalencias.id = '$id_equivalencia'";
		}

		if($valor == "CREAR")
		{
			$sqlMedidas = "select '0' as id, ' - seleccione una unidad ' as nombre 
			UNION ALL 
			SELECT id, nombre 
			from unidades 
			where id NOT IN 
			(select id_unidad from equivalencias 
			where equivalencias.id_unidad = unidades.id 
			and equivalencias.id_producto = '$id_producto');";
		}
		else
		{
			$sqlMedidas = "
			select '0' as id, ' - seleccione una unidad ' as nombre 
			UNION ALL
            SELECT id, nombre 
			from unidades 
			where id = '$id_unidad_utilizada'
			UNION ALL 
			SELECT id, nombre 
			from unidades 
			where id NOT IN 
			(select id_unidad from equivalencias 
			where equivalencias.id_unidad = unidades.id 
			and equivalencias.id_producto = '$id_producto')
			";
		}

	}
	
	

	$resultadoMedidas = $conexion->query($sqlMedidas);
	$comprobarUnidadFromQuery = $conexion->query($sqlMedidas);
	$EsUnidad = false;
	$registrosMedidas = $resultadoMedidas->num_rows;


	$resultadoPro = $conexion->query($sqlProducto);
	
	$filasProducto = $resultadoPro->num_rows;
	if($filasProducto > 0)
	{
		$registrosPro = $resultadoPro->fetch_assoc();
		$nombre = $registrosPro['pro_nombre'];
		$codigo_pro = $registrosPro['pro_codigo'];
		$codigo_barra = $registrosPro['pro_codigo_barra'];
		$id_equivalencia = $registrosPro['id_equivalencia'];
		$unidades = $registrosPro['cantidad'];
		$precio = $registrosPro['e_precio'];
		$precio_iva = $registrosPro['e_precio_iva'];
		$id_unidad_principal = $registrosPro['id_unidad'];

		$costo_compra = $registrosPro['e_costo'];
        $costo_agregado = $registrosPro['e_costo_agregado'];
        $costo_total = $registrosPro['e_costo_total'];
        $costo_compra_iva = $registrosPro['e_costo_iva'];
        $costo_agregado_iva = $registrosPro['e_costo_agregado_iva'];
        $costo_total_iva = $registrosPro['e_costo_total_iva'];

	}


	if(isset($_POST['BORRAR']) || isset($_POST['CREAR']) || isset($_POST['EDITAR']))
	{

		$id_producto = mysqli_escape_string($conexion, $_POST['hhdProducto']); 
		$id_equivalencia = mysqli_escape_string($conexion, $_POST['hhdEquivalencia']); 
		$cantidad = mysqli_escape_string($conexion, $_POST['unidades']);
		$id_unidad = mysqli_escape_string($conexion, $_POST['medida']);
		$precio = mysqli_escape_string($conexion, $_POST['precio']) * 1.000000;
		$precio_iva = mysqli_escape_string($conexion, $_POST['precioIva']) * 1.000000;

		$costo_compra = mysqli_escape_string($conexion, $_POST['costo']) * 1.00;
        $costo_agregado = mysqli_escape_string($conexion, $_POST['flete']) * 1.00;
        $costo_total = mysqli_escape_string($conexion, $_POST['costoFinal']) * 1.00;
        $costo_compra_iva = mysqli_escape_string($conexion, $_POST['costoIva']) * 1.00;
        $costo_agregado_iva = mysqli_escape_string($conexion, $_POST['fleteIva']) * 1.00;
        $costo_total_iva = mysqli_escape_string($conexion, $_POST['costoFinalIva']) * 1.00;

		if(isset($_POST['BORRAR']))
		{
				$sqlDelete = "
											DELETE FROM equivalencias
											WHERE id = '$id_equivalencia' and id_producto = '$id_producto';
							 ";
				$resultadoDelete = $conexion->query($sqlDelete);
				if($resultadoDelete > 0)
				{
					echo "<script>
						alert('Borrar con exito');
					</script>";
					header("Location:sis_equivalencias.php?codigo=$id_producto");
				}
				else
				{
					echo "<script>
						alert('Error al borrar producto');
					</script>";
	
				}
		}
		if(isset($_POST['CREAR']))
		{
			if($cantidad <= 0)
			{
				echo "<script>
						alert('La cantidad debe ser mayor a cero');
					</script>";
				return;
			}
			if($id_unidad == 0)
			{
				echo "<script>
						alert('Debe elegir una unidad');
					</script>";
				return;
			}

			if($id_unidad > 0 && $cantidad > 0)
			{
				$sqlinsert = "INSERT INTO equivalencias(cantidad, id_unidad, id_producto, precio, precio_iva, costo, costo_iva, costo_agregado, costo_agregado_iva, costo_total, costo_total_iva) 
							values('$cantidad', '$id_unidad', '$id_producto', '$precio', '$precio_iva', '$costo_compra', '$costo_compra_iva', '$costo_agregado', '$costo_agregado_iva', '$costo_total', '$costo_total_iva' );";
				$resultadograbarProducto = $conexion->query($sqlinsert);
				if($resultadograbarProducto > 0)
				{
					echo "<script>
						alert('Registro exitoso');
					</script>";
					header("Location:sis_equivalencias.php?codigo=$id_producto");
				}
				else
				{
					echo "<script>
						alert('Error al grabar nuevo producto');
					</script>";
	
				}
			}

			
			
		}
		if(isset($_POST['EDITAR']))
		{
			if($cantidad <= 0)
			{
				echo "<script>
						alert('La cantidad debe ser mayor a cero');
					</script>";
				return;
			}
			if($id_unidad == 0)
			{
				echo "<script>
						alert('Debe elegir una unidad');
					</script>";
				return;
			}

			if($id_unidad > 0 && $cantidad > 0)
			{
				$sqlupdate = "
											UPDATE equivalencias
											SET
											cantidad = '$cantidad',
											id_unidad = '$id_unidad',
											precio = '$precio',
											precio_iva = '$precio_iva',
											costo = '$costo_compra',
											costo_iva = '$costo_compra_iva',
											costo_agregado = '$costo_agregado',
											costo_agregado_iva = '$costo_agregado_iva',
											costo_total = '$costo_total',
											costo_total_iva = '$costo_total_iva'
											WHERE id = '$id_equivalencia' and id_producto = '$id_producto';
							 ";
				//echo $sqlupdate;
				$resultadoActualizar = $conexion->query($sqlupdate);
				if($resultadoActualizar > 0)
				{
					echo "<script>
						alert('Modificacion con exito');
					</script>";
					header("Location:sis_equivalencias.php?codigo=$id_producto");
				}
				else
				{
					echo "<script>
						alert('Error al grabar modificacion de producto');
					</script>";
	
				}
			}
		}

	}



?>

<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Gestion Equivalencias</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

		<script>
        function CalcularCostoSin() {
        var x = parseFloat(document.getElementById("costo").value);
        document.getElementById("costoIva").value = (x  * 1.13).toFixed(6);
        CostoTotal();
        }

        function CalcularCostoCon() {
        var x = parseFloat(document.getElementById("costoIva").value);
        document.getElementById("costo").value = (x  / 1.13).toFixed(6);
        CostoTotal();
        }

        function CalcularFleteSin() {
        var x = parseFloat(document.getElementById("flete").value);
        document.getElementById("fleteIva").value = (x  * 1.13).toFixed(6);
        CostoTotal();
        }

        function CalcularFleteCon() {
        var x = parseFloat(document.getElementById("fleteIva").value);
        document.getElementById("flete").value = (x  / 1.13).toFixed(6);
        CostoTotal();
        }

        function CostoTotal()
        {
            var costo = ValidarNumericoCero( document.getElementById("costo").value);
            var flete = ValidarNumericoCero(document.getElementById("flete").value);
            // costo = ValidarNumericoCero(costo);
            // flete = ValidarNumericoCero(flete);            

            document.getElementById("costoFinal").value = costo  + flete;

            var costoIva = ValidarNumericoCero(document.getElementById("costoIva").value);
            var fleteIva = ValidarNumericoCero(document.getElementById("fleteIva").value);

            // costoIva = ValidarNumericoCero(costoIva);
            // fleteIva = ValidarNumericoCero(fleteIva); 

            document.getElementById("costoFinalIva").value = costoIva  + fleteIva;

        }

        function ValidarNumericoCero(ValorDecimal)
        {
            var valor = 0;
            if (isNaN(ValorDecimal) || ValorDecimal == null || ValorDecimal == '')
            {
                valor = 0;
            } else
            {
                valor = parseFloat(ValorDecimal);
            }

            return parseFloat( valor );
        }
        
        function CalcularPrecioSin() {
        var x = parseFloat(document.getElementById("precio").value);
        document.getElementById("precioIva").value = (x  * 1.13).toFixed(6);
        }

        function CalcularPrecioCon() {
        var x = parseFloat(document.getElementById("precioIva").value);
        document.getElementById("precio").value = (x  / 1.13).toFixed(6);
        }



</script>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
		
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php
				include('phpPage/header.php');
				?>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Gestion Equivalencias</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Forms</span></li>
								<li><span>Validation</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
				
					<div class="row">
						<div class="col-md-12">
							<form id="form" action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST" class="form-horizontal">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<!-- <a href="#" class="fa fa-times"></a> -->
										</div>

										<h2 class="panel-title"><?php echo $valor; ?> - Gestion Equivalencias</h2>
										
									</header>
									<div class="panel-body">

                                       <row class="form-group">
                                      <div class="form-group col-md-12">
											
											<div class="col-md-6">
												<div class="form-group">
												<label class="col-sm-3 control-label">Nombre </label>
												<div class="col-md-9">
													<input readonly="" type="text"  value="<?php echo $nombre; ?>" class="form-control" required/>
												</div>
                                        </div>
											</div>
											<div class="col-md-6">
												<div class="form-group ">
												<label class="col-sm-3 control-label">Codigo </label>
													<div class="col-sm-9">
													<input readonly="" type="text"  value="<?php echo $codigo_pro; ?>" class="form-control" required/>
														
														<input type="hidden" value="<?php echo $id_producto; ?>" name="hhdProducto" id="hhdProducto" />
														<input type="hidden" value="<?php echo $id_equivalencia; ?>" name="hhdEquivalencia" id="hhdEquivalencia" />
													</div>
                                       			</div>

											</div>
	
									  </div>
									  </row>
									  
									  <row class="form-group">
											<div class="form-group col-md-12">
											<div class="col-md-6">
													<div class="form-group">
													<label class="col-sm-5 control-label">Cantidad de Unidades <span class="required">*</span></label>
															<div class="col-sm-7">
																<?php

														$NumeroUnidadesInput = '<input '.$SoloLectura.' type="text" id="unidades" name="unidades" value="'.$unidades.'" class="form-control" placeholder="Numero de unidades que tiene" required/>';
														if($registrosMedidas>0)
														{
															while($ComprobarEsUnidad = $comprobarUnidadFromQuery->fetch_assoc())
															{
																														
																if($id_unidad_principal == $ComprobarEsUnidad["id"] && strtoupper($ComprobarEsUnidad['nombre']) == "UNIDAD" )
																{
																	$NumeroUnidadesInput = '<input readonly="" type="text" id="unidades" name="unidades" value="'.$unidades.'" class="form-control" placeholder="Numero de unidades que tiene" required/>';
																	$EsUnidad = true;
																}
															}
														}
																		echo $NumeroUnidadesInput;
																?>
																
															</div>
													</div>
											</div>
												<div class="col-md-6">

														<div class="form-group col-md-12">
															<label class="col-md-3 control-label" for="inputSuccess">Medida </label>
															<div class="col-md-6">

																<select class="form-control mb-md" name="medida" id="medida" >

																<?php
																$DesabilitarOpcionPorUnidad = "";
																if($EsUnidad)
																{
																	$DesabilitarOpcionPorUnidad = "disabled";	
																}


														if($registrosMedidas>0)
														{
															while($filaLab = $resultadoMedidas->fetch_assoc())
															{
																echo "<option value='".$filaLab["id"]."' ";
																
																if($id_unidad_principal == $filaLab["id"] )
																{
																echo "selected='selected'";
																}
																else
																{
																echo " $DesabilitarOpcionPorUnidad ";
																}
																echo "  >".$filaLab['nombre']."</option>";
															}

														}
														?>
																</select>
														
															</div>
													</div>

												</div>
											</div>
									 </row>
									  
                                       
                                            
                                            

                                        <div class="table-responsive " class=".col-sm-2" >
									<table class="table table-bordered table-striped table-condensed mb-none">
										<thead>
											<tr  class="dark">
                                            <th class="text-left">Valor</th>

                                                <th class="text-left">Precio</th>
											</tr>
										</thead>
										<tbody>
                                           
                                            <tr>
												<td>
                                                <div class=".col-sm-2">       
                                                Sin IVA
                                                </div>
                                                </td>
                                               
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input <?php echo $SoloLectura; ?> onkeyup="CalcularPrecioSin();" type="number" min="0.000000" max="999999.00" step="0.010000" name="precio" id="precio" value="<?php echo $precio ?>" class="form-control" placeholder="Precio de Venta" />
                                                </div>
                                            </td>
                                            </tr>
                                            
                                            <tr>
												<td>
                                                <div class=".col-sm-2">       
                                                Con IVA
                                                </div>
                                                </td>
                                                
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input <?php echo $SoloLectura; ?> onkeyup="CalcularPrecioCon();" type="number" min="0.000000" max="999999.00" step="0.010000" name="precioIva" id="precioIva" value="<?php echo $precio_iva ?>" class="form-control" placeholder="Precio de Venta" />
												</div>
												<input type="hidden" name="id_producto" value="<?php echo $id_producto ?>" />
                                            </td>
											</tr>
                                                    
											


										</tbody>
									</table>

									<div class="table-responsive " class=".col-sm-2" >
									<table class="table table-bordered table-striped table-condensed mb-none">
										<thead>
											<tr  class="dark" >
                                            <th class="text-left">Valor</th>
												<th class="text-left">Costo</th>
												<th class="text-left">Costo Agregado</th>
                                                <th class="text-left">Costo Final</th>
											</tr>
										</thead>
										<tbody>
                                           
                                            <tr>
												<td>
                                                <div class=".col-sm-2">       
                                                Sin IVA
                                                </div>
                                                </td>
                                                <td>
                                                <div class=".col-sm-2">    
                                                <input <?php echo $SoloLectura; ?>  onkeyup="CalcularCostoSin();"  type="number" min="0.000000" max="999999.00" step="0.010000" name="costo" id="costo" value="<?php echo $costo_compra ?>" class="form-control" placeholder="Costo" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input <?php echo $SoloLectura; ?>  onkeyup="CalcularFleteSin();" type="number" min="0.000000" max="999999.00" step="0.010000" name="flete" id="flete" value="<?php echo $costo_agregado ?>" class="form-control" placeholder="Flete, Cargos" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input readonly  type="number" min="0.000000" max="999999.00" step="0.010000" name="costoFinal" id="costoFinal" value="<?php echo $costo_total ?>" class="form-control" placeholder="Costo Final" />
                                                </div>
                                            </td>

                                            </tr>
                                            
                                            <tr>
												<td>
                                                <div class=".col-sm-2">       
                                                Con IVA
                                                </div>
                                                </td>
                                                <td>
                                                <div class=".col-sm-2">    
                                                <input <?php echo $SoloLectura; ?> onkeyup="CalcularCostoCon();" type="number" min="0.000000" max="999999.00" step="0.010000" name="costoIva" id="costoIva" value="<?php echo $costo_compra_iva ?>" class="form-control" placeholder="Costo" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input <?php echo $SoloLectura; ?> onkeyup="CalcularFleteCon();" type="number" min="0.000000" max="999999.00" step="0.010000" name="fleteIva" id="fleteIva" value="<?php echo $costo_agregado_iva ?>" class="form-control" placeholder="Flete, Cargos" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input readonly  type="number" min="0.000000" max="999999.00" step="0.010000" name="costoFinalIva" id="costoFinalIva" value="<?php echo $costo_total_iva ?>" class="form-control" placeholder="Costo Final" />
                                                </div>
                                            </td>
											</tr>
                                                    
											


										</tbody>
									</table>
								</div>
								</div>



                                    <br>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-9 ">
												<button type="submit" name="<?php echo $valor; ?>" class="btn btn-primary "><?php echo $valor; ?></button>
												<button onclick="window.history.back();" class="btn btn-default ">Cancelar</button>
												<br>
												<div class="checkbox-custom checkbox-default">
																<input type="checkbox"   id="checkboxExample1">
																<label for="checkboxExample1" class="text-dark">Actualizar todos Costos en base esta unidad de medida</label>
												</div>
												<br>
												<span>Al marcar esta casilla todos los costos de: <?php echo $nombre; ?> </span>
												<span>van actualizarse tomando como referencia esta unidad de medida.</span>
												<br>
												<label class="text-dark">Los precios se actualizan de forma individual</label>
											</div>
										</div>
									</footer>
								</section>
							</form>
						</div>
						<!-- col-md-6 -->

					</div>

					<div class="row">
						<div class="col-md-6">

						</div>
						<div class="col-md-6">
						
						</div>
					</div>
					<!-- end: page -->
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark" ></div>
			
							
							</div>
			
							
						</div>
					</div>
				</div>
			</aside>
		</section>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-validation/jquery.validate.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="assets/javascripts/forms/examples.validation.js"></script>
	</body>
</html>

