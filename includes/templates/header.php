<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>
		<?php getTitle() ?>
	</title>

	<meta name="keywords" content="tanques, radiadores, autos, vehiculos, automoviles, coches, camionetas">

	<!-- Primary Meta Tags -->
	<title>Tank Store</title>
	<meta name="title" content="Tank Store" />
	<meta name="description" content="Venta de Tanques para radiadores" />

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://grupolatin.net/arielisaias/tank_store/" />
	<meta property="og:title" content="Tank Store" />
	<meta property="og:description" content="Venta de Tanques para radiadores" />
	<meta property="og:image" content="https://grupolatin.net/arielisaias/tank_store/admin/uploads/thumbnail.jpg" />

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image" />
	<meta property="twitter:url" content="https://grupolatin.net/arielisaias/tank_store/" />
	<meta property="twitter:title" content="Tank Store" />
	<meta property="twitter:description" content="Venta de Tanques para radiadores" />
	<meta property="twitter:image" content="https://grupolatin.net/arielisaias/tank_store/admin/uploads/thumbnail.jpg" />

	<link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css?v=<?= LIB_VERSION ?>" />
	<link rel="stylesheet" href="<?php echo $css ?>bootstrap-icons-1.11.3/font/bootstrap-icons.min.css?v=<?= LIB_VERSION ?>">
	<!-- <link rel="stylesheet" href="< ?php echo $css ?>font-awesome.min.css" /> -->
	<link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css?v=<?= LIB_VERSION ?>" />
	<!-- <link rel="stylesheet" href="< ?php echo $css ?>jquery.selectBoxIt.css" /> -->
	<link rel="stylesheet" href="<?php echo $css ?>front.css?v=<?= LIB_VERSION ?>" />
	<link rel="stylesheet" href="<?php echo $css ?>index.css?v=<?= LIB_VERSION ?>" />

	<style>
		.col-sm-6.col-md-3 {
			min-height: 530px !important;
		}
	</style>
</head>

<body>
	<header class="sticky-top">
		<nav class="navbar navbar-expand-lg p-0 bg-white" data-bs-theme="light">
			<div class="container">

				<?php
				if (isset($_SESSION['user'])) {
				?>
					<a class="navbar-brand p-0" href="profile.php">
						<img class="d-inline-block align-text-top my-image rounded-circle" height="36px" src="admin/uploads/avatars/<?php echo $sessionAvatar ?>" alt="" />
					</a>
				<?php
				}
				?>

				<!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUserMenu" aria-controls="navbarUserMenu" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button> -->

				<!-- <div class="collapse navbar-collapse" id="navbarUserMenu"> -->
					<ul class="navbar-nav me-auto">
						<?php
						if (isset($_SESSION['user'])) {
						?>
							<li class="nav-item dropdown" data-bs-theme="ligh">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<?php echo $sessionUser ?>
								</a>
								<ul class="dropdown-menu">
									<li><a class="dropdown-item" href="profile.php">Mi Perfil</a></li>
									<li><a class="dropdown-item" href="newad.php">Nuevo Item</a></li>
									<li><a class="dropdown-item" href="myItems.php">Mis Items</a></li>
									<li>
										<hr class="dropdown-divider">
									</li>
									<li><a class="dropdown-item" href="logout.php">Logout</a></li>
								</ul>
							</li>

						<?php
						} else {
						?>
							<li class="nav-item">
								<a class="nav-link" href="login.php">
									Login/Signup
								</a>
							</li>
						<?php } ?>
					</ul>
					<div class="d-flex" role="search">
							<a class="btn btn-small btn-success" href="https://api.whatsapp.com/send?phone=3364338670&text=Hola%21%20Quería%20consultar%20sobre%20los%20tanques%20para%20radiadores" target="_blank">Consultas <i class="bi bi-whatsapp"></i> 3364338670</a>
					</div>
				<!-- </div> -->


			</div>
		</nav>
		<nav class="navbar navbar-expand-lg bg-dark border-bottom" data-bs-theme="dark">
			<div class="container">
				
				<a class="navbar-brand" href="index.php">
					<i class="bi bi-house"></i>
					<?php echo lang('HOME_ADMIN') ?>
				</a>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse my-2 my-lg-0" id="navbarSupportedContent">

					<form class="d-flex m-0" action="index.php" method="GET" role="search">
						<div class="input-group">
							<input class="form-control" type="text" name="search" placeholder="Ingrese marca o modelo" aria-label="Search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
							<?php
							if (isset($_GET['search']))
							{
								?>
								<button class="btn btn-outline-secondary" type="button" data-href="<?= $_SERVER['PHP_SELF'] ?>" id="search-reset"><i class="bi bi-x-circle-fill text-primary"></i></button>
							<?php } ?>
							<button class="btn btn-outline-warning" type="submit">Buscar</button>
						</div>
					</form>

					<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						<!-- <li class="nav-item">
							<a class="btn btn-small btn-success active" role="button" href="https://api.whatsapp.com/send?phone=3364338670&text=Hola%21%20Quería%20consultar%20sobre%20los%20tanques%20para%20radiadores" target="_blank" style="margin-top: 7px;"><i class="fa fa-cel" aria-hidden="true"></i>CONSULTAR POR
						WhatsApp</a>
						</li> -->
						
						<?php
						$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC");
						foreach ($allCats as $cat) {
							?>
							<li class="nav-item">
								<a class="nav-link" href="categories.php?pageid=<?= $cat['ID'] ?>">
									<?= $cat['Name'] ?>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</nav>

	</header>