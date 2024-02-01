<?php
ob_start();
session_start();
$pageTitle = 'Profile';
include 'init.php';
if (isset($_SESSION['user'])) {
	$getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
	$getUser->execute(array($sessionUser));
	$info = $getUser->fetch();
	$userid = $info['UserID'];
?>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="text-center">My Items</h1>
			</div>
		</div>

		<!-- Profile -->
		<div class="row pb-3">
			<div class="col-md-12">

				<div class="card" id="fDatosPers">
					<div class="card-header bg-primary text-white">
						My Information
					</div>

					<div class="card-body">
						<div class="row mb-0">
							<div class="col-sm mb-3 mb-sm-0">
								<div class="input-group mb-3">
									<span class="input-group-text" id="userName"><i class="bi bi-person-fill"></i></span>
									<input type="text" class="form-control" placeholder="Username" aria-label="userName" aria-describedby="userName" value="<?= $info['Username'] ?>" disabled="">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-text" id="emailLbl"><i class="bi bi-at"></i></span>
									<input type="email" class="form-control email" placeholder="Email" aria-label="Email" aria-describedby="emailLbl" value="<?= $info['Email'] ?>" disabled="">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-text" id="fullName"><i class="bi bi-person-vcard-fill"></i></span>
									<input type="text" class="form-control" placeholder="Full name" aria-label="fullName" aria-describedby="fullName" value="<?= $info['FullName'] ?>" disabled="">
								</div>
								<div class="input-group mb-3">
									<span class="input-group-text" id="registered"><i class="bi bi-calendar-date-fill"></i></span>
									<input type="text" class="form-control" placeholder="Reg" aria-label="registered" aria-describedby="registered" value="<?= $info['Date'] ?>" disabled="">
								</div>
							</div>

							<div class="col-sm">

								<div class="toast align-items-center text-white bg-info border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display: block;">
									<div class="d-flex">
										<div class="toast-body">
											Aviso
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class="row">
							<div class="col">
								<a href="editProfil.php" class="btn btn-outline-secondary">Edit Informations</a>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
		<!-- Profile -->

		<!-- Adds -->
		<div class="row pb-3">
			<div class="col-md-12">

				<!-- Revisar -->


				<div class="card" id="fDatosPers">
					<div class="card-header bg-primary text-white">
						My Items
					</div>

					<div class="card-body">
						<?php
						$myItems = getAllFrom("*", "items", "where Member_ID = $userid", "", "Item_ID");
						if (!empty($myItems)) {
						?>
							<div id="my-adss" class="">
								<div class="row">
									<?php
									foreach ($myItems as $item) {
									?>
										<div class="col-10 col-md-10 col-lg-4 col-xl-3 mb-3 offset-1 offset-lg-0">
											<div class="card shadow-sm">
												<?php
												if ($item['Price'] != 1) {
													$formattedPrice = '$' . number_format($item['Price'], 0, ',', '.');
												}
												?>
												<span class="bg-danger text-white fs-4 position-absolute mt-3 px-1 price-tag"> <?= $item['Price'] == 1 ? 'CONSULTAR' : $formattedPrice ?></span>
												<?php
												if (empty($item['picture'])) {
												?>
													<img class="card-img-top img-fluid" src='admin/uploads/default.png' alt='' />
												<?php
												} else {
												?>
													<img class="card-img-top" src='admin/uploads/items/<?= $item['picture'] ?>' alt='' />
												<?php
												}
												?>
												<div class="card-body">
													<h5 class="card-title">
														<a class="h3 link-dark link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
															<?= $item['Name'] ?>
														</a>
														<span class="h6">
															<?php if ($item['Approve'] == 0) { ?> <span class="badge text-bg-warning">Waiting Approval</span> <?php } ?>
														</span>
													</h5>
													<p class="card-text fs-5">
														<?= $item['Description'] ?>
													</p>
													<span class="text-start h4">Cod: <?= $item['Country_Made'] ?></span>
												</div>
											</div>
										</div>

									<?php
									}
									?>
								</div>
							</div>
						<?php
						} else {
							?>
							Sorry. There No Ads To Show. Create <a class="btn btn-success" href="newad.php">New Ad</a>
							<?php
						}
						?>

					</div>
				</div>
				<!-- Revisar -->

			</div>
		</div>

		<!-- Comments -->
		<div class="row pb-3">
			<div class="col-md-12">

				<div class="card" id="fDatosPers">
					<div class="card-header bg-primary text-white">
						Latest Comments
					</div>

					<div class="card-body">

						<div class="my-comments block">
							<div class="container">
								<div class="panel panel-primary">
									<div class="panel-heading">Latest Comments</div>
									<div class="panel-body">
										<?php
										$myComments = getAllFrom("comment", "comments", "where user_id = $userid", "", "c_id");
										if (!empty($myComments)) {
											foreach ($myComments as $comment) {
												echo '<p>' . $comment['comment'] . '</p>';
											}
										} else {
											echo 'There\'s No Comments to Show';
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- Comments -->

	</div>

<?php
} else {
	header('Location: login.php');
	exit();
}
include $tpl . 'footer.php';
ob_end_flush();
?>