<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title><?php getTitle() ?></title>
	<link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css" />
	<link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css" />
	<link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css" />
	<link rel="stylesheet" href="<?php echo $css ?>front.css" />

	<style>
		.col-sm-6.col-md-3 {
			min-height: 530px !important;
		}
	</style>
</head>

<body>
	<div class="upper-bar">
		<div class="container">
			<?php
			if (isset($_SESSION['user'])) {
			?>
				<img class="my-image img-circle" src="admin/uploads/avatars/<?php echo $sessionAvatar ?>" alt="" />
				<div class="btn-group my-info">
					<span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<?php echo $sessionUser ?>
						<span class="caret"></span>
					</span>
					<ul class="dropdown-menu">
						<li><a href="profile.php">Mi Perfil</a></li>
						<li><a href="newad.php">Nuevo Item</a></li>
						<li><a href="myItems.php">Mis Items</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div>

			<?php

			} else {
			?>
				<a href="login.php">
					<span class="pull-right">Login/Signup</span>
				</a>
			<?php } ?>
		</div>
	</div>
	<nav class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"><i class="fa fa-home" aria-hidden="true"></i> <?php echo lang('HOME_ADMIN') ?></a>
				<a class="btn btn-success active" role="button" href="https://api.whatsapp.com/send?phone=3364338670&text=Hola%21%20Quería%20consultar%20sobre%20los%20tanques%20para%20radiadores" target="_blank" style="margin-top: 7px;"><i class="fa fa-cel" aria-hidden="true"></i>CONSULTAR POR WhatsApp</a>
			</div>
			<div class="collapse navbar-collapse" id="app-nav">
				<ul class="nav navbar-nav navbar-right">
					<?php
					$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC");
					foreach ($allCats as $cat) {
						echo
						'<li>
					<a href="categories.php?pageid=' . $cat['ID'] . '">
						' . $cat['Name'] . '
					</a>
				</li>';
					}
					?>
					<li>
						<a href="https://api.whatsapp.com/send?phone=3364338670" target="_blank" style="color: white">Consultas 3364338670</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>