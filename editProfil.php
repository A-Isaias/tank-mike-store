<?php

session_start();
include 'init.php';

// Get the User ID from Session
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
function getSingleValue($con, $sql, $parameters)
{
	$q = $con->prepare($sql);
	$q->execute($parameters);
	return $q->fetchColumn();
}
$userid = getSingleValue($con, "SELECT UserID FROM users WHERE username=?", [$_SESSION['user']]);

// Select All Data Depend On This ID

$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

// Execute Query

$stmt->execute(array($userid));

// Fetch The Data

$row = $stmt->fetch();

// The Row Count

$count = $stmt->rowCount();

// If There's Such ID Show The Form

if ($count > 0) { ?>

	<h1 class="text-center">Edit My Information</h1>

	<div class="container">

		<form class="form-horizontal" action="UpdateProfile.php" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="userid" value="<?= $userid ?>" />
			<div class="row mb-0">
				<div class="col-sm mb-3 mb-sm-0">
					<div class="input-group input-group-lg mb-3">
						<span class="input-group-text" id="userName"><i class="bi bi-person-fill"></i></span>
						<input type="text" class="form-control" placeholder="Username" aria-label="userName" aria-describedby="userName" value="<?= $row['Username'] ?>" >
					</div>
					<div class="input-group input-group-lg mb-3">
						<span class="input-group-text" id="userName"><i class="bi bi-key"></i></span>
						<input type="password" class="form-control" name="newpassword" placeholder="Leave Blank If You Dont Want To Change" autocomplete="new-password" aria-label="userName" aria-describedby="userName" >
						<!-- <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change" /> -->
						<input type="hidden" name="oldpassword" value="<?= $row['Password'] ?>" />
					</div>
					<div class="input-group input-group-lg mb-3">
						<span class="input-group-text" id="emailLbl"><i class="bi bi-at"></i></span>
						<input type="email" class="form-control email" placeholder="Email" aria-label="Email" aria-describedby="emailLbl" value="<?= $row['Email'] ?>" >
					</div>
					<div class="input-group input-group-lg mb-3">
						<span class="input-group-text" id="fullName"><i class="bi bi-person-vcard-fill"></i></span>
						<input type="text" class="form-control" placeholder="Full name" aria-label="fullName" aria-describedby="fullName" value="<?= $row['FullName'] ?>" >
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col">
					<a href="editProfil.php" class="btn btn-lg btn-primary">Save</a>
				</div>
			</div>
		</form>

	</div>

	<?php } ?>


	<?php include $tpl . 'footer.php'; ?>