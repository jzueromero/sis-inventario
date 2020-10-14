<?php
	include("php/conexion.php");
	session_start();
	if(!isset($_SESSION['id_usuario']))
	{
		header("Location: pages-signin.php");
    }
    $valor = "CREAR";
    $almacencodigo = "";
    $nombre = "";
    $lugar = "";
    $Requerido = "";
    $SoloLectura = "";

    if(isset($_GET['opcion']))
    {
        if($_GET['opcion'] == "BORRAR")
        {
            $SoloLectura = "readonly";
		        
        }

         $valor= $_GET['opcion'];
         $codigo = $_GET['codigo'];

         $sql = "SELECT  * from almacen 
						where idalmacen = '$codigo' ";

		$resultado = $conexion->query($sql);
		$rows = $resultado->num_rows;
		if($rows>0)
		{
			$row = $resultado->fetch_assoc();
            $almacencodigo = $row["codigo_almacen"];
            $nombre = $row["nombre_almacen"];
            $lugar = $row["lugar_almacen"];

		}

    }

    if(isset($_POST['CREAR']) || isset($_POST['nuevo']) )
    {
        
        $Requerido = "required";
		$nombre = mysqli_escape_string($conexion, $_POST['almacennombre']);
		$lugar = mysqli_escape_string($conexion, $_POST['almacenlugar']);
		$almacencodigo = mysqli_escape_string($conexion, $_POST['almacencodigo']);
       
		       

			$sqlusuario = "INSERT INTO almacen(nombre_almacen,codigo_almacen, lugar_almacen ) 
                        values('$nombre', '$almacencodigo', '$lugar')";

			$resultadousuario = $conexion->query($sqlusuario);
			if($resultadousuario > 0)
			{
				echo "<script>
					alert('Registro exitoso');
					window.location = 'index.php';
				</script>";
			}
			else
			{
                echo $sqlusuario;
                echo "<script>
					alert('Error al registrar');
					window.location = 'index.php';
				</script>";
			}

    }

    if(isset($_POST['EDITAR']))
    {

		$nombre = mysqli_escape_string($conexion, $_POST['almacennombre']);
		$lugar = mysqli_escape_string($conexion, $_POST['almacenlugar']);
        $almacencodigo = mysqli_escape_string($conexion, $_POST['almacencodigo']);
                
         $sqluser = "update  almacen set nombre_almacen = '$nombre', lugar_almacen = '$lugar', codigo_almacen = '$almacencodigo'  where idalmacen = '$codigo'";
        

		$resultadouser = $conexion->query($sqluser);
		
			if($resultadouser > 0)
			{
				echo "<script>
					alert('Modificacion exitosa');
					window.location = 'index.php';
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
		        
        $sqluser = "";
        if($codigo != 1)
        {
                    $sqluser = "DELETE FROM almacen where idalmacen = '$codigo'";
        }
        else
        {
            echo "<script>
            alert('No puede eliminarse al Almacen general');
            window.location = 'index.php';
            </script>";
            return;

        }


		$resultadouser = $conexion->query($sqluser);
		
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

		<title>Gestion Almacenes</title>
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
						<h2>Gestion Almacen</h2>
					
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

										<h2 class="panel-title"><?php echo $valor; ?> - Gestion Almacen</h2>
										<p class="panel-subtitle">
											Favor proporcionar la informacion solicitada para el almacen.
										</p>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Codigo <span class="required">*</span></label>
											<div class="col-sm-9">
												<input <?php echo $SoloLectura; ?> type="text" value="<?php echo $almacencodigo; ?> " name="almacencodigo" class="form-control" placeholder="eg.: A00X" required/>
											</div>
										</div>
                                        <div class="form-group">
											<label class="col-sm-3 control-label">Nombre <span class="required">*</span></label>
											<div class="col-sm-9">
												<input <?php echo $SoloLectura; ?> type="text" name="almacennombre" value="<?php echo $nombre ?>" class="form-control" placeholder="eg.: Almacen tienda uno" required/>
											</div>
										</div>
                                        <div class="form-group">
											<label class="col-sm-3 control-label">Lugar <span class="required">*</span></label>
											<div class="col-sm-9">
												<input <?php echo $SoloLectura; ?> type="text" name="almacenlugar" value="<?php echo $lugar ?>" class="form-control" placeholder="eg.: San Miguel, SV" required/>
											</div>
										</div>

									</div>
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