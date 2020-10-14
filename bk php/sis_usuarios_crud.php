<?php
	include("php/conexion.php");
	session_start();
	if(!isset($_SESSION['id_usuario']))
	{
		header("Location: pages-signin.php");
    }
    $valor = "CREAR";
    $nombre = "";
    $correo = "";
    $usuario = "";
    $password = "";
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

         $sql = "SELECT  * from usuarios 
						where idusuarios = $codigo ";

		$resultado = $conexion->query($sql);
		$rows = $resultado->num_rows;
		if($rows>0)
		{
			$row = $resultado->fetch_assoc();
            $nombre = $row["NombreC"];
            $correo = $row["Correo"];
            $usuario = $row["usuario"];

		}

    }

    if(isset($_POST['CREAR']))
    {
        
        $Requerido = "required";
		$nombre = mysqli_escape_string($conexion, $_POST['fullname']);
		$correo = mysqli_escape_string($conexion, $_POST['email']);
		$usuario = mysqli_escape_string($conexion, $_POST['usuario']);
        $password = mysqli_escape_string($conexion, $_POST['password']);
        $password2 = mysqli_escape_string($conexion, $_POST['password2']);
        
       
		$sqluser = "select usuario * from usuarios where NombreC = ". $usuario;
		
        $password_encrtada = sha1($password);
        
		$resultadouser = $conexion->query($sqluser);
		$filas = $resultadouser->num_rows;
		if($filas > 0)
		{
			echo "<script>
					alert('El usuario ya existe');
					window.location = 'index.php';
				</script>";
		}
		else 
		{
			$sqlusuario = "INSERT INTO usuarios(NombreC,Correo, usuario, password) 
						values('$nombre', '$correo', '$usuario',  '$password_encrtada')";

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
				echo "<script>
					alert('Error al registrar');
					window.location = 'index.php';
				</script>";
			}

		}

    }

    if(isset($_POST['EDITAR']))
    {
        

		$nombre = mysqli_escape_string($conexion, $_POST['fullname']);
		$correo = mysqli_escape_string($conexion, $_POST['email']);
		$usuario = mysqli_escape_string($conexion, $_POST['usuario']);
        $password = mysqli_escape_string($conexion, $_POST['password']);
        $password2 = mysqli_escape_string($conexion, $_POST['password2']);
        
        if($password != $password2)
        {
            echo "<script>
                    alert('los password no coinciden');
                    </script>";
                    return;
        }
        
        $sqluser = "";
        if(empty( $password) )
        {
            $sqluser = "update  usuarios set NombreC = '$nombre', Correo = '$correo', usuario = '$usuario' where idusuarios = '$codigo'";
        }
        else
        {
            $password_encrtada = sha1($password);
            $sqluser = "update  usuarios set NombreC = '$nombre', Correo = '$correo', usuario = '$usuario', password = '$password_encrtada' where idusuarios = '$codigo'";
        }


		$resultadouser = $conexion->query($sqluser);
		
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
					alert('Error al registrar');
				</script>";
			}

		

    }
    if(isset($_POST['BORRAR']))
    {
        
        $SoloLectura = "readonly";
		        
        $sqluser = "";
        if($codigo != 3)
        {
                    $sqluser = "DELETE FROM usuarios where idusuarios = '$codigo'";
        }
        else
        {
            echo "<script>
            alert('No puede eliminarse al administrador');
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

										<h2 class="panel-title"><?php echo $valor; ?> - Gestion Usuario</h2>
										<p class="panel-subtitle">
											Favor proporcionar la informacion solicitada para el usuario.
										</p>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Nombres <span class="required">*</span></label>
											<div class="col-sm-9">
												<input <?php echo $SoloLectura; ?> type="text" value="<?php echo $nombre; ?> " name="fullname" class="form-control" placeholder="eg.: John Smith" required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Email <span class="required">*</span></label>
											<div class="col-sm-9">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-envelope"></i>
													</span>
													<input <?php echo $SoloLectura; ?> value="<?php echo $correo ?>" type="email" name="email" class="form-control" placeholder="eg.: email@email.com" required/>
												</div>
											</div>
											<div class="col-sm-9">

											</div>
                                        </div>
                                        <div class="form-group">
											<label class="col-sm-3 control-label">Usuario <span class="required">*</span></label>
											<div class="col-sm-9">
												<input <?php echo $SoloLectura; ?> type="text" name="usuario" value="<?php echo $usuario ?>" class="form-control" placeholder="eg.: cajero_jhon" required/>
											</div>
										</div>
                                        <div class="form-group">
											<label class="col-sm-3 control-label">Password <span class="required">*</span></label>
											<div class="col-sm-9">
												<input <?php echo $SoloLectura; ?> type="password" name="password" value="<?php echo $password; ?>" class="form-control" placeholder="Password" <?php echo $Requerido; ?> />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Confirmar <span class="required">*</span></label>
											<div class="col-sm-9">
												<input  <?php echo $SoloLectura; ?> type="password" name="password2" class="form-control" placeholder="Confirmar Password"  <?php echo $Requerido; ?> />
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