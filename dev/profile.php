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
	<h1 class="text-center">My Profile</h1>
	<div class="information block">
		<div class="container">

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
										<span class="input-group-text" id="emailLbl">@</span>
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
							<div id="my-ads" class="my-ads block">
								<?php
									echo '<div class="row">';
									foreach ($myItems as $item) {
										echo '<div class="col-sm-6 col-md-3">';
										echo '<div class="thumbnail item-box">';
										if ($item['Approve'] == 0) {
											echo '<span class="approve-status">Waiting Approval</span>';
										}
										echo '<span class="price-tag">$' . $item['Price'] . '</span>';
										echo '<img class="img-responsive" src="img.png" alt="" />';
										echo '<div class="caption">';
										echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
										echo '<p>' . $item['Description'] . '</p>';
										echo '<div class="date">' . $item['Add_Date'] . '</div>';
										echo '</div>';
										echo '</div>';
										echo '</div>';
									}
									echo '</div>';
								?>
							</div>
							<?php
							} else {
								echo 'Sorry There\' No Ads To Show, Create <a href="newad.php">New Ad</a>';
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
	</div>



<?php
} else {
	header('Location: login.php');
	exit();
}
include $tpl . 'footer.php';
ob_end_flush();
?>