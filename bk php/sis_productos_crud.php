<?php
	include("php/conexion.php");
	session_start();
	if(!isset($_SESSION['id_usuario']))
	{
		header("Location: pages-signin.php");
    }

	$id_producto = 0;
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
    $nombre = "";
    $codigo_barra = "";
    $codigo = "";
    $descripcion = "";
    $costo_compra = 0;
    $costo_agregado = 0;
    $costo_total = 0;
    $costo_compra_iva = 0;
    $costo_agregado_iva = 0;
    $costo_total_iva = 0;
    $precio = 0;
    $precio_iva = 0;
    $id_proveedor =0;
    $id_unidad_principal =0;
	$id_laboratorio = 0;
	$id_producto = 0;

	$sqlLaboratorios = "select '0' as id, ' - seleccione un Laboratorio ' as nombre, '0' as pais
	UNION ALL
	SELECT  * from laboratorios ;";
	$resultadoLab = $conexion->query($sqlLaboratorios);
	$registrosLab = $resultadoLab->num_rows;



	$sqlProveedor = "SELECT '0' AS id, '- Seleecione un proveedor' as nombre 
	UNION ALL
	SELECT idproveedor AS id, nombre_proveedor as nombre FROM proveedores;";
	$resultadoProv = $conexion->query($sqlProveedor);
	$registrosProv = $resultadoProv->num_rows;


    if(isset($_GET['opcion']))
    {
        if($_GET['opcion'] == "BORRAR")
        {
            $SoloLectura = "readonly";
		        
        }

         $valor= $_GET['opcion'];
         $codigo = $_GET['codigo'];


         

         $sql = "SELECT  * from productos 
                        where id = $codigo ";
         
         $sqlLaboratorios= "";




                               
                        
                       

		$resultado = $conexion->query($sql);
		$rows = $resultado->num_rows;
		if($rows>0)
		{
			$row = $resultado->fetch_assoc();
            $nombre = $row["nombre"];
			$codigo_barra = $row['codigo_barra'];
			$codigo = $row['codigo'];
			$descripcion = $row['descripcion'];
			$costo_compra = $row['costo_compra'];
			$costo_agregado = $row['costo_agregado'];
			$costo_total = $row['costo_total'];
			$costo_compra_iva = $row['costo_compra_iva'];
			$costo_agregado_iva = $row['costo_agregado_iva'];
			$costo_total_iva = $row['costo_total_iva'];
			$precio = $row['precio'];
			$precio_iva = $row['precio_iva'];
			$id_proveedor = $row['id_proveedor'];
			//$id_unidad_principal = $row['unidad']);
			$id_laboratorio = $row['id_laboratorio'];
			$id_producto = $row['id'];
		}

    }

    if(isset($_POST['CREAR']))
    {
		 
        $Requerido = "required";
		$nombre = mysqli_escape_string($conexion, $_POST['nombre']);
        $codigo_barra = mysqli_escape_string($conexion, $_POST['codigoBarra']);
        $codigo = mysqli_escape_string($conexion, $_POST['codigo']);
        $descripcion = mysqli_escape_string($conexion, $_POST['descripcion']);
        $costo_compra = mysqli_escape_string($conexion, $_POST['costo']) * 1.00;
        $costo_agregado = mysqli_escape_string($conexion, $_POST['flete']) * 1.00;
        $costo_total = mysqli_escape_string($conexion, $_POST['costoFinal']) * 1.00;
        $costo_compra_iva = mysqli_escape_string($conexion, $_POST['costoIva']) * 1.00;
        $costo_agregado_iva = mysqli_escape_string($conexion, $_POST['fleteIva']) * 1.00;
        $costo_total_iva = mysqli_escape_string($conexion, $_POST['costoFinalIva']) * 1.00;
        $precio = mysqli_escape_string($conexion, $_POST['precio']) * 1.00;
        $precio_iva = mysqli_escape_string($conexion, $_POST['precioIva']) * 1.00;
        $id_proveedor =mysqli_escape_string($conexion, $_POST['proveedor']);
        //$id_unidad_principal =mysqli_escape_string($conexion, $_POST['unidad']);
        $id_laboratorio = mysqli_escape_string($conexion, $_POST['laboratorio']);
	    $id_producto = mysqli_escape_string($conexion, $_POST['id']);
		

        $sqluser = "select codigo from productos where codigo = ".$codigo;

	


		$resultadouser = $conexion->query($sqluser);
		$filas = $resultadouser->num_rows;
		if($filas > 0)
		{
			echo "<script>
					alert('El codigo de producto ya existe');
					window.location = 'index.php';
				</script>";
		}
		else 
		{
												 //codigo`, `codigo_barra`, `nombre`, `descripcion`, `costo_compra`, `costo_agregado`, `costo_total`, `costo_compra_iva`, `costo_agregado_iva`, `costo_total_iva`, `precio`, `precio_iva`,  `id_laboratorio`) VALUES ('3', '3', 'tercer producto', 'trecre producto', '3', '3', '3', '3', '3', '3', '3', '3', '1', '1', '1', '1');
			$sqlproducto = "INSERT INTO productos(codigo, codigo_barra, nombre, descripcion, costo_compra, costo_agregado, costo_total, costo_compra_iva, costo_agregado_iva, costo_total_iva,precio,  precio_iva, id_laboratorio, id_proveedor) 
											values('$codigo', '$codigo_barra', '$nombre', '$descripcion', '$costo_compra', '$costo_agregado', '$costo_total', '$costo_compra_iva', '$costo_agregado_iva', '$costo_total_iva','$precio', '$precio_iva', '$id_laboratorio', '$id_proveedor' )";


			//header("Location: sis_productos_crud.php?dato=".$sqlproducto) ;
			$resultadograbarProducto = $conexion->query($sqlproducto);
			if($resultadograbarProducto > 0)
			{
				echo "<script>
					alert('Registro exitoso');
					window.location = 'index.php';
				</script>";
			}
			else
			{
				//  header("Location: sis_productos_crud.php?dato=".$sqlproducto) ;
				echo "<script>
					alert('".$sqlproducto."');
				</script>";

				echo "<script>
					alert('Error al grabar nuevo producto');
				</script>";

			}

		}

    }

    if(isset($_POST['EDITAR']))
    {
        

		$nombre = mysqli_escape_string($conexion, $_POST['nombre']);
        $codigo_barra = mysqli_escape_string($conexion, $_POST['codigoBarra']);
        $codigo = mysqli_escape_string($conexion, $_POST['codigo']);
        $descripcion = mysqli_escape_string($conexion, $_POST['descripcion']);
        $costo_compra = mysqli_escape_string($conexion, $_POST['costo']) * 1.00;
        $costo_agregado = mysqli_escape_string($conexion, $_POST['flete']) * 1.00;
        $costo_total = mysqli_escape_string($conexion, $_POST['costoFinal']) * 1.00;
        $costo_compra_iva = mysqli_escape_string($conexion, $_POST['costoIva']) * 1.00;
        $costo_agregado_iva = mysqli_escape_string($conexion, $_POST['fleteIva']) * 1.00;
        $costo_total_iva = mysqli_escape_string($conexion, $_POST['costoFinalIva']) * 1.00;
        $precio = mysqli_escape_string($conexion, $_POST['precio']) * 1.00;
        $precio_iva = mysqli_escape_string($conexion, $_POST['precioIva']) * 1.00;
        $id_proveedor =mysqli_escape_string($conexion, $_POST['proveedor']);
        //$id_unidad_principal =mysqli_escape_string($conexion, $_POST['unidad']);
        $id_laboratorio = mysqli_escape_string($conexion, $_POST['laboratorio']);
	    $id_producto = mysqli_escape_string($conexion, $_POST['id_producto']);
        
        
        $sqlupdate = "";

            $sqlupdate = " UPDATE productos
											SET
											codigo = '$codigo',
											codigo_barra = '$codigo_barra',
											nombre = '$nombre',
											descripcion = '$descripcion',
											costo_compra = '$costo_compra',
											costo_agregado = '$costo_agregado',
											costo_total = '$costo_total',
											costo_compra_iva = '$costo_compra_iva',
											costo_agregado_iva = '$costo_agregado_iva',
											costo_total_iva = '$costo_total_iva',
											precio = '$precio',
											precio_iva = '$precio_iva',
											id_laboratorio = '$id_laboratorio',
											id_proveedor = '$id_proveedor'
											WHERE id = '$id_producto';
											";
       


		$resultadouser = $conexion->query($sqlupdate);
		
			if($resultadouser > 0)
			{
				echo "<script>
					alert('Modificacion exitosa');
					window.history.back();
				</script>";
			}
			else
			{
				echo "<script>
					alert('Error al modificar');
				</script>";
			}

		

    }
    if(isset($_POST['BORRAR']))
    {
        
        $SoloLectura = "readonly";
		        
		$SqlDelete = "";
		$codigo = mysqli_escape_string($conexion, $_POST['id_producto']);

        $SqlDelete = "DELETE FROM productos where id = '$codigo'";


		$resultadouser = $conexion->query($SqlDelete);
		
			if($resultadouser > 0)
			{
				

				echo "<script>
					alert('Eliminacion exitosa');
					window.location = 'index.php';
				</script>";
			}
			else
			{
				echo "<script>
                    alert('Error al eliminar');
                    window.location = 'index.php';
				</script>";
			}

		

    }



	?>


<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Form Validation | Okler Themes | Porto-Admin</title>
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
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="assets/images/logo.png" height="35" alt="Porto Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					<form action="pages-search-results.html" class="search nav-form">
						<div class="input-group input-search">
							<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
			
					<span class="separator"></span>
			
					<ul class="notifications">
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
								<i class="fa fa-tasks"></i>
								<span class="badge">3</span>
							</a>
			
							<div class="dropdown-menu notification-menu large">
								<div class="notification-title">
									<span class="pull-right label label-default">3</span>
									Tasks
								</div>
			
								<div class="content">
									<ul>
										<li>
											<p class="clearfix mb-xs">
												<span class="message pull-left">Generating Sales Report</span>
												<span class="message pull-right text-dark">60%</span>
											</p>
											<div class="progress progress-xs light">
												<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
											</div>
										</li>
			
										<li>
											<p class="clearfix mb-xs">
												<span class="message pull-left">Importing Contacts</span>
												<span class="message pull-right text-dark">98%</span>
											</p>
											<div class="progress progress-xs light">
												<div class="progress-bar" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
											</div>
										</li>
			
										<li>
											<p class="clearfix mb-xs">
												<span class="message pull-left">Uploading something big</span>
												<span class="message pull-right text-dark">33%</span>
											</p>
											<div class="progress progress-xs light mb-xs">
												<div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;"></div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
								<i class="fa fa-envelope"></i>
								<span class="badge">4</span>
							</a>
			
							<div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="pull-right label label-default">230</span>
									Messages
								</div>
			
								<div class="content">
									<ul>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="assets/images/!sample-user.jpg" alt="Joseph Doe Junior" class="img-circle" />
												</figure>
												<span class="title">Joseph Doe</span>
												<span class="message">Lorem ipsum dolor sit.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="assets/images/!sample-user.jpg" alt="Joseph Junior" class="img-circle" />
												</figure>
												<span class="title">Joseph Junior</span>
												<span class="message truncate">Truncated message. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam, nec venenatis risus. Vestibulum blandit faucibus est et malesuada. Sed interdum cursus dui nec venenatis. Pellentesque non nisi lobortis, rutrum eros ut, convallis nisi. Sed tellus turpis, dignissim sit amet tristique quis, pretium id est. Sed aliquam diam diam, sit amet faucibus tellus ultricies eu. Aliquam lacinia nibh a metus bibendum, eu commodo eros commodo. Sed commodo molestie elit, a molestie lacus porttitor id. Donec facilisis varius sapien, ac fringilla velit porttitor et. Nam tincidunt gravida dui, sed pharetra odio pharetra nec. Duis consectetur venenatis pharetra. Vestibulum egestas nisi quis elementum elementum.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="assets/images/!sample-user.jpg" alt="Joe Junior" class="img-circle" />
												</figure>
												<span class="title">Joe Junior</span>
												<span class="message">Lorem ipsum dolor sit.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<figure class="image">
													<img src="assets/images/!sample-user.jpg" alt="Joseph Junior" class="img-circle" />
												</figure>
												<span class="title">Joseph Junior</span>
												<span class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam.</span>
											</a>
										</li>
									</ul>
			
									<hr />
			
									<div class="text-right">
										<a href="#" class="view-more">View All</a>
									</div>
								</div>
							</div>
						</li>
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
								<i class="fa fa-bell"></i>
								<span class="badge">3</span>
							</a>
			
							<div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="pull-right label label-default">3</span>
									Alerts
								</div>
			
								<div class="content">
									<ul>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="fa fa-thumbs-down bg-danger"></i>
												</div>
												<span class="title">Server is Down!</span>
												<span class="message">Just now</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="fa fa-lock bg-warning"></i>
												</div>
												<span class="title">User Locked</span>
												<span class="message">15 minutes ago</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="fa fa-signal bg-success"></i>
												</div>
												<span class="title">Connection Restaured</span>
												<span class="message">10/10/2014</span>
											</a>
										</li>
									</ul>
			
									<hr />
			
									<div class="text-right">
										<a href="#" class="view-more">View All</a>
									</div>
								</div>
							</div>
						</li>
					</ul>
			
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="assets/images/!logged-user.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="assets/images/!logged-user.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
								<span class="name">John Doe Junior</span>
								<span class="role">administrator</span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fa fa-user"></i> My Profile</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="./php/salir.php"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<?php
				include('phpPage/header.php');
				?>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Form Validation</h2>
					
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
						<div class="col-md-6">
							<form id="form" action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST" class="form-horizontal">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<!-- <a href="#" class="fa fa-times"></a> -->
										</div>

										<h2 class="panel-title"><?php echo $valor; ?> - Gestion Productos</h2>
										<p class="panel-subtitle">
											Favor proporcionar la informacion solicitada para el Producto.
										</p>
									</header>
									<div class="panel-body">

                                        <div class="form-group">
											<label class="col-sm-3 control-label">Codigo <span class="required">*</span></label>
											<div class="col-sm-9">
												<input <?php echo $SoloLectura; ?> type="text" name="codigo" id="codigo" value="<?php echo $codigo ?>" class="form-control" placeholder="codigo" required/>
											</div>
                                        </div>
                                        <div class="form-group">
											<label class="col-sm-3 control-label">Codigo de Barras <span class="required">*</span></label>
											<div class="col-sm-9">
												<input <?php echo $SoloLectura; ?> type="text" name="codigoBarra" id="codigoBarra" value="<?php echo $codigo_barra ?>" class="form-control" placeholder="Codigo Barras" />
											</div>
										</div>
                                        <div class="form-group">
											<label class="col-sm-3 control-label">Nombre <span class="required">*</span></label>
											<div class="col-sm-9">
												<input <?php echo $SoloLectura; ?> type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" class="form-control" placeholder="Nombre del producto" required />
											</div>
                                        </div>
                                        
                                        <div class="table-responsive " class=".col-sm-2" >
									<table class="table table-bordered table-striped table-condensed mb-none">
										<thead>
											<tr>
                                            <th class="text-left">Valor</th>
												<th class="text-left">Costo</th>
												<th class="text-left">Costo Agregado</th>
                                                <th class="text-left">Costo Final</th>
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
                                                <input <?php echo $SoloLectura; ?>  onkeyup="CalcularCostoSin();"  type="number" min="0.000000" max="999999.00" step="0.010000" name="costo" id="costo" value="<?php echo $costo_compra ?>" class="form-control" placeholder="Costo" required/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input <?php echo $SoloLectura; ?>  onkeyup="CalcularFleteSin();" type="number" min="0.000000" max="999999.00" step="0.010000" name="flete" id="flete" value="<?php echo $costo_agregado ?>" class="form-control" placeholder="Flete, Cargos" required/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input readonly  type="number" min="0.000000" max="999999.00" step="0.010000" name="costoFinal" id="costoFinal" value="<?php echo $costo_total ?>" class="form-control" placeholder="Costo Final" required/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input <?php echo $SoloLectura; ?> onkeyup="CalcularPrecioSin();" type="number" min="0.000000" max="999999.00" step="0.010000" name="precio" id="precio" value="<?php echo $precio ?>" class="form-control" placeholder="Precio de Venta" required/>
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
                                                <input <?php echo $SoloLectura; ?> onkeyup="CalcularCostoCon();" type="number" min="0.000000" max="999999.00" step="0.010000" name="costoIva" id="costoIva" value="<?php echo $costo_compra_iva ?>" class="form-control" placeholder="Costo" required/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input <?php echo $SoloLectura; ?> onkeyup="CalcularFleteCon();" type="number" min="0.000000" max="999999.00" step="0.010000" name="fleteIva" id="fleteIva" value="<?php echo $costo_agregado_iva ?>" class="form-control" placeholder="Flete, Cargos" required/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input readonly  type="number" min="0.000000" max="999999.00" step="0.010000" name="costoFinalIva" id="costoFinalIva" value="<?php echo $costo_total_iva ?>" class="form-control" placeholder="Costo Final" required/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class=".col-sm-2">    
                                                <input <?php echo $SoloLectura; ?> onkeyup="CalcularPrecioCon();" type="number" min="0.000000" max="999999.00" step="0.010000" name="precioIva" id="precioIva" value="<?php echo $precio_iva ?>" class="form-control" placeholder="Precio de Venta" required/>
												</div>
												<input type="hidden" name="id_producto" value="<?php echo $id_producto ?>" />
                                            </td>
											</tr>
                                                    
											


										</tbody>
									</table>
								</div>

                            <br>

                                <div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Proveedor </label>
												<div class="col-md-6">

													<select class="form-control mb-md" name="proveedor" id="proveedor" >

                                                    <?php
                                            if($registrosProv>0)
                                            {
                                                while($filaprove = $resultadoProv->fetch_assoc())
                                                {
													echo "<option value='".$filaprove["id"]."' ";
													
													if($id_proveedor == $filaprove["id"] )
													{
													echo "selected='selected'";
													}
													else
													{
													echo " ";
													}
													echo " >".$filaprove['nombre']."</option>";
                                                }

                                            }
                                            ?>
													</select>
											
												</div>
											</div>

                                       
											<div class="form-group">
												<label class="col-md-3 control-label" for="inputSuccess">Laboratorio </label>
												<div class="col-md-6">

													<select class="form-control mb-md" name="laboratorio" id="laboratorio" >

                                                    <?php
                                            if($registrosLab>0)
                                            {
                                                while($filaLab = $resultadoLab->fetch_assoc())
                                                {
													echo "<option value='".$filaLab["id"]."' ";
													
													if($id_laboratorio == $filaLab["id"] )
													{
													echo "selected='selected'";
													}
													else
													{
													echo " ";
													}
													echo " >".$filaLab['nombre']."</option>";
                                                }

                                            }
                                            ?>
													</select>
											
												</div>
											</div>




									   
                       
                                        <div class="form-group">
											<label class="col-sm-3 control-label">Descripcion <span class="required">*</span></label>
											
												<div class="col-sm-9">
													<textarea class="form-control"  rows="3" id="textareaDefault" id="descripcion" name="descripcion" >
                                                    </textarea>
										</div>
									
                                    </div>
                                    <br>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-9 col-sm-offset-3">
												<button type="submit" name="<?php echo $valor; ?>" class="btn btn-primary"><?php echo $valor; ?></button>
												<button onclick="window.history.back();" class="btn btn-default">Cancelar</button>
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
			
								<ul>
									<li>
										<time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>
			
							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
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