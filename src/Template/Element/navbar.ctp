<!-- Top menu -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href=<?php echo $this->Url->build('/', true); ?>>Bootstrap Navigation Bar With Icons</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="top-navbar-1">
            <ul class="nav navbar-nav navbar-right">
                <li id="navPerfil">
					<a href=<?php echo $this->Url->build('/usuario', true); ?>>
						<?php if ($idusuario_nav != null){  ?>
							<i class="fa fa-user"></i> <span><?php echo $nombreusuario_nav ?></span>
						<?php } else { ?>
							<i class="fa fa-user"></i> <span>Perfil</span>
						<?php } ?>
					</a>
                </li>       
                <li id="navLog">
					<?php if ($idusuario_nav != null){  ?>
						<a href=<?php echo $this->Url->build('/usuario/logout', true); ?>>							
							<i class="fa fa-sign-out"></i> <span>Cerrar Sesion</span>
						</a>
					<?php } else { ?>
						<a href=<?php echo $this->Url->build('/usuario/login', true); ?>>							
							<i class="fa fa-sign-in"></i> <span>Iniciar Sesion</span>
						</a>
					<?php } ?>
                </li>                                          
                <!--<li id="navLenguaje">
					<a href="#">
						<i class="fa fa-language"></i> <span>Lenguaje: Espanol</span>
					</a>
				</li>               -->          
            </ul>
			<ul class="nav navbar-nav navbar-center">
				<li id="navComunidad">
					<a href=<?php echo $this->Url->build('/comunidad', true); ?>>
						<i class="fa fa-map-signs"></i> <span>Comunidad</span>
					</a>
				</li>
				<li id="navTek">
					<a href=<?php echo $this->Url->build('/tek', true); ?>>
						<i class="fa fa-book"></i> <span>TEK</span>
					</a>
				</li>
				<li id="navProductos">
					<a href=<?php echo $this->Url->build('/producto', true); ?>>
						<i class="fa fa-list"></i> <span>Productos</span>
					</a>
				</li>
				<li id="navSocial">
					<a href=<?php echo $this->Url->build('/social', true); ?>>
						<i class="fa fa-users"></i> <span>Social</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>