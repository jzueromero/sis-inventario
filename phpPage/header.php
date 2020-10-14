<?php
	include("php/conexion.php");
	
	$iduser = $_SESSION['id_usuario'];
	$sql = "select idusuarios, NombreC from usuarios where idusuarios = '$iduser'";

	$resultadouser = $conexion->query($sql);
	$rowuser = $resultadouser->fetch_assoc();
?>
	<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="assets/images/logo.png" height="35" alt="JSOFT Admin" />
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
			
				
			
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="assets/images/!logged-user.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="assets/images/!logged-user.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@JSOFT.com">
								<span class="name"><?php echo utf8_decode($rowuser['NombreC']); ?></span>
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
<aside id="sidebar-left" class="sidebar-left">
				
                <div class="sidebar-header">
                    <div class="sidebar-title">
                        Navigation
                    </div>
                    <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>
            
<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li class="nav-active">
										<a href="index.html">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-copy" aria-hidden="true"></i>
											<span>Usuarios</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="sis_usuarios.php">
													 Gestion usuarios
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-copy" aria-hidden="true"></i>
											<span>Almacenes</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="sis_almacenes.php">
													 Gestion Almacenes
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-copy" aria-hidden="true"></i>
											<span>Proveedores</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="sis_proveedores.php">
													 Gestion Proveedores
												</a>
											</li>
										</ul>
										<ul class="nav nav-children">
											<li>
												<a href="sis_laboratorios.php">
													 Gestion Laboratorios
												</a>
											</li>
										</ul>
									</li>

									<li class="nav-parent">
										<a>
											<i class="fa fa-copy" aria-hidden="true"></i>
											<span>Ubicaciones</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="#">
													 Gestion Ubicaciones
												</a>
											</li>
										</ul>
									</li>

									<li class="nav-parent">
										<a>
											<i class="fa fa-copy" aria-hidden="true"></i>
											<span>Inventario</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="sis_productos.php">
													 Gestion de productos
												</a>
											</li>
										</ul>
										<ul class="nav nav-children">
											<li>
												<a href="sis_unidades.php">
													 Gestion de Unidades
												</a>
											</li>
										</ul>
										<ul class="nav nav-children">
											<li>
												<a href="#">
													 Gestion de Vencimientos
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-copy" aria-hidden="true"></i>
											<span>Transaciones Inventario</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="#">
													 Entrada Producto
												</a>
											</li>
										</ul>
										<ul class="nav nav-children">
											<li>
												<a href="#">
													 Salida de producto
												</a>
											</li>
										</ul>
										<ul class="nav nav-children">
											<li>
												<a href="#">
													 Envio a otro almacen
												</a>
											</li>
										</ul>
									</li>



				
							<hr class="separator" />
				
						</div>
				
                    </div>
                    
                    </aside>