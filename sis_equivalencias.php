<?php
	include("php/conexion.php");
	session_start();
	if(!isset($_SESSION['id_usuario']))
	{
		header("Location: pages-signin.php");
    }
    
    if(isset($_GET['codigo']))
    {
        $id_producto = mysqli_escape_string($conexion, $_GET['codigo']);
    }
    else
    {
        echo "<script>
                    alert('Codigo no encontrado');
                    window.history.back();
				</script>";
    }

    $sql_pro = "SELECT  * from productos 
            where id = $id_producto ";
        $nombre = "";
        $codigo_barra = "";
        $codigo = "";

$resultado_pro = $conexion->query($sql_pro);
$rows_pro = $resultado_pro->num_rows;
    if($rows_pro>0)
    {
        $rows_pro = $resultado_pro->fetch_assoc();
        $nombre = $rows_pro["nombre"];
        $codigo_barra = $rows_pro['codigo_barra'];
        $codigo = $rows_pro['codigo'];
        

    }

	$sqlequival = "select unidades.id as id_unidad, unidades.nombre as nombre_unidad, equivalencias.id as id_equivalencia, equivalencias.cantidad, 
					equivalencias.precio as e_precio, equivalencias.precio_iva as e_precio_iva, 
					equivalencias.costo as e_costo, equivalencias.costo_iva as e_costo_iva, 
					equivalencias.costo_agregado as e_costo_agregado, equivalencias.costo_agregado_iva as e_costo_agregado_iva,
					equivalencias.costo_total as e_costo_total, equivalencias.costo_total_iva as e_costo_total_iva,
                    productos.id, productos.codigo as pro_codigo, productos.codigo_barra as pro_codigo_barra, productos.nombre as pro_nombre
                    from unidades
                    inner join equivalencias on equivalencias.id_unidad = unidades.id
                    inner join productos on productos.id = equivalencias.id_producto
                    WHERE equivalencias.id_producto = '$id_producto' ORDER by equivalencias.cantidad ";

		$resultadoequival = $conexion->query($sqlequival);
		$registrosequival = $resultadoequival->num_rows;
	

	?>
	
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Dashboard | JSOFT Themes | JSOFT-Admin</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="JSOFT Admin - Responsive HTML5 Template">
		<meta name="author" content="JSOFT.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/morris/morris.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
		
				<!-- start: sidebar -->
				<?php
				include('phpPage/header.php');
				?>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Responsive Tables</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Tables</span></li>
								<li><span>Responsive</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<!-- start: page -->
						
						
						<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<!-- <a href="#" class="fa fa-times"></a> -->
								</div>
						
                                <h2 class="panel-title">Gestion Equivalencias</h2>
                               <?php
                                echo "<h3>".$nombre."</h3>";
                                echo "<h5>Codigo: ".$codigo."</h5>";
                                echo "<h5>Codigo Barras: ".$codigo_barra."</h5>";
                               ?>
                                <div class="text-right">
                                <button class="btn btn-primary " onclick="location.href = 'sis_equivalencia_crud.php?opcion=CREAR&codigo=<?php echo $id_producto; ?>&id_eq=0.&idunidad=0';">Crear Nueva Equivalencia</button>
                                </div>
                            </header>
							<div class="panel-body">
								<div class="table-responsive ">
								<table class="table table-bordered table-striped table-condensed mb-none">
										<thead>
											<tr>
												<th>Unidad de Medida</th>
                                                <th class="text-left">Cantidad</th>
                                                <th class="text-left">Costo Iva</th>
                                                <th class="text-left">Costo Agregado IVA</th>
												<th class="text-left">Costo Total Iva</th>
                                                <th class="text-left">Precio IVA</th>
												<th class="text-left">Opciones</th>
											</tr>
										</thead>
										<tbody>
                                            <?PHP
                                            if($registrosequival>0)
                                            {
                                                while($fila = $resultadoequival->fetch_assoc())
                                                {
                                                    echo '
                                                    <tr>
												<td>'.$fila['nombre_unidad'].'</td>
												<td>'.$fila['cantidad'].'</td>
                                                <td class="text-left">'.$fila['e_costo_iva'].'</td>
												<td class="text-left">'.$fila['e_costo_agregado_iva'].'</td>
												<td class="text-left">'.$fila['e_costo_total_iva'].'</td>
												<td class="text-left">'.$fila['e_precio_iva'].'</td>
												';
												if( strtoupper($fila['nombre_unidad']) == "UNIDAD" )
												{
												echo '	<td class="text-left"><a href="sis_equivalencia_crud.php?opcion=EDITAR&codigo='.$fila['id'].'&id_eq='.$fila['id_equivalencia'].'&idunidad='.$fila['id_unidad'].'" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
													<label for="      " ></label>
													</td> ';
												}
												else
												{
													echo '<td class="text-left"><a href="sis_equivalencia_crud.php?opcion=EDITAR&codigo='.$fila['id'].'&id_eq='.$fila['id_equivalencia'].'&idunidad='.$fila['id_unidad'].'" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                                <label for="      " ></label>
												<a href="sis_equivalencia_crud.php?opcion=BORRAR&codigo='.$fila['id'].'&codigo='.$fila['id'].'&id_eq='.$fila['id_equivalencia'].'&idunidad='.$fila['id_unidad'].'" class="on-default remove-row"><i class="fa fa-trash-o"></i></a></td>';
												}
                                                echo '
											</tr>
                                                    ';
                                                }
                                    
                                            }
                                            
                                            ?>
											


										</tbody>
									</table>
								</div>
							</div>
						</section>
						
						
					<!-- end: page -->
				</section>
					
<div class="row">
			
						
						
								
							</section>
					

					

					<div class="row">
					
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
		<script src="assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
		<script src="assets/vendor/flot/jquery.flot.js"></script>
		<script src="assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
		<script src="assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
		<script src="assets/vendor/raphael/raphael.js"></script>
		<script src="assets/vendor/morris/morris.js"></script>
		<script src="assets/vendor/gauge/gauge.js"></script>
		<script src="assets/vendor/snap-svg/snap.svg.js"></script>
		<script src="assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="assets/vendor/jqvmap/jquery.vmap.js"></script>
		<script src="assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
		<script src="assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="assets/javascripts/dashboard/examples.dashboard.js"></script>
	</body>
</html>