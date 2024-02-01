<?php
ob_start();
session_start();
$pageTitle = 'Create New Item';
include 'init.php';
if (isset($_SESSION['user'])) {

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		// Upload Variables

		$avatarName = $_FILES['itempic']['name'];
		$avatarSize = $_FILES['itempic']['size'];
		$avatarTmp	= $_FILES['itempic']['tmp_name'];
		$avatarType = $_FILES['itempic']['type'];

		// List Of Allowed File Typed To Upload

		$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

		// Get Avatar Extension

		$ref = explode('.', $avatarName);
		$avatarExtension = strtolower(end($ref));

		$formErrors = array();

		$name 		= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$desc 		= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
		$price 		= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
		$country 	= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
		$status 	= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		$category 	= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
		$contact 	= filter_var($_POST['contact'], FILTER_SANITIZE_STRING);

		if (strlen($name) < 4) {

			$formErrors[] = 'Item Title Must Be At Least 4 Characters';
		}

		if (strlen($desc) < 10) {

			$formErrors[] = 'Item Description Must Be At Least 10 Characters';
		}

		if (strlen($country) < 2) {

			$formErrors[] = 'Item Title Must Be At Least 2 Characters';
		}

		if (empty($price)) {

			$formErrors[] = 'Item Price Cant Be Empty';
		}

		if (empty($status)) {

			$formErrors[] = 'Item Status Cant Be Empty';
		}

		if (empty($category)) {

			$formErrors[] = 'Item Category Cant Be Empty';
		}

		if (empty($contact)) {

			$formErrors[] = 'Item Contact Cant Be Empty';
		}

		if (!empty($avatarName) && !in_array($avatarExtension, $avatarAllowedExtension)) {
			$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
		}

		if (empty($avatarName)) {
			$formErrors[] = 'Avatar Is <strong>Required</strong>';
		}

		if ($avatarSize > 4194304) {
			$formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
		}

		// Check If There's No Error Proceed The Update Operation

		if (empty($formErrors)) {

			$avatar = rand(0, 10000000000) . '_' . $avatarName;

			move_uploaded_file($avatarTmp, "admin/uploads/items/" . $avatar);

			// Insert Userinfo In Database

			$stmt = $con->prepare("INSERT INTO 

					items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, picture, contact)

					VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :zpicture, :zcontact)");

			$stmt->execute(array(

				'zname' 	=> $name,
				'zdesc' 	=> $desc,
				'zprice' 	=> $price,
				'zcountry' 	=> $country,
				'zstatus' 	=> $status,
				'zcat'		=> $category,
				'zmember'	=> $_SESSION['uid'],
				'zpicture'	=> $avatar,
				'zcontact'	=> $contact

			));

			// Echo Success Message

			if ($stmt) {

				$succesMsg = 'Item Has Been Added';
			}
		}
	}

?>

	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="text-center"><?= $pageTitle ?></h1>
			</div>
		</div>

		<div class="row mb-3">
			<div class="col">
				<div class="create-ad block">
					<div class="row">
						<div class="col-md-8">
							<form class="form-horizontal main-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
								<!-- Start Name Field -->
								<div class="input-group mb-3">
									<span class="input-group-text" id="imtemName">Name</span>
									<input type="text" class="form-control live" aria-label="" aria-describedby="" value="" pattern=".{4,}" title="This Field Require At Least 4 Characters" name="name" placeholder="Name of The Item" data-class=".live-title" onkeyup="" required>
								</div>
								<!-- End Name Field -->

								<!-- Start Description Field -->
								<div class="input-group mb-3">
									<span class="input-group-text" id="item">Description</span>
									<input type="text" class="form-control live" pattern=".{10,}" title="This Field Require At Least 10 Characters" name="description" placeholder="Description of The Item" data-class=".live-desc" aria-label="" aria-describedby="" value="" required>
								</div>
								<!-- End Description Field -->

								<!-- Start Description Field -->
								<div class="input-group mb-3">
									<span class="input-group-text" id="item">Contact</span>
									<input type="text" class="form-control" aria-label="" aria-describedby="" value="" name="contact" placeholder="Phone Number of the Item owner" required>
								</div>
								<!-- End Description Field -->

								<!-- Start Price Field -->
								<div class="input-group mb-3">
									<span class="input-group-text" id="item">Price</span>
									<input type="text" class="form-control live" aria-label="" aria-describedby="" value="" name="price" placeholder="Price of The Item" data-class=".live-price" required>
								</div>
								<!-- End Price Field -->

								<!-- Start Country Field -->
								<div class="input-group mb-3">
									<span class="input-group-text" id="item">Code</span>
									<input type="text" class="form-control live" placeholder="" data-class=".live-cod" aria-label="" aria-describedby="" value="" name="country" placeholder="Code" required>
								</div>
								<!-- End Country Field -->

								<!-- Start Status Field -->
								<div class="input-group mb-3">
									<label class="input-group-text" for="itemStatus">Status</label>
									<select class="form-select" id="itemStatus" name="status" required>
										<option value="1" selected>New</option>
										<option value="2">Like New</option>
										<option value="3">Used</option>
										<option value="4">Very Old</option>
									</select>
								</div>
								<!-- End Status Field -->

								<!-- Start Categories Field -->
								<div class="input-group mb-3">
									<label class="input-group-text" for="itemCategory">Category</label>
									<select class="form-select" id="itemCategory" name="category" required>
										<?php
										$selected = $cat['Ordering'] == '1' ? 'selected' : '';
										$cats = getAllFrom('*', 'categories', '', '', 'ID');
										foreach ($cats as $cat) {
											echo "<option value='" . $cat['ID'] . " " . $selected . "'>" . $cat['Name'] . "</option>";
										}
										?>
									</select>
								</div>
								<!-- End Categories Field -->

								<!-- Start Image Field -->
								<div class="input-group mb-3">
									<label class="input-group-text" for="imginp">Picture</label>
									<input type="file" class="form-control" id='imginp' name="itempic" class="form-control" onchange="loadFile(event)" required>
								</div>
								<!-- End Image Field -->

								<!-- Start Submit Field -->
								<div class="btn-group w-100" role="group" aria-label="Basic mixed styles example">
									<button type="reset" class="btn btn-danger">Cancel</button>
									<button type="sbutmit" class="btn btn-success confirm">Send</button>
								</div>
								<!-- End Submit Field -->
							</form>
						</div>

						<div class="col-md-4">
							<div class="card shadow-sm live-preview">
								<span class="bg-danger text-white fs-4 position-absolute mt-3 px-1 price-tag">
									$ <span class="live-price">0</span>
								</span>

								<img class="card-img-top" id="output" src="admin/uploads/default.png">

								<div class="card-body">
									<h5 class="card-title">
										<a class="h3 link-dark link-underline link-underline-opacity-0 link-underline-opacity-75-hover live-title">Title</a>
									</h5>
									<p class="card-text fs-5 live-desc">
										Description
									</p>
									<span class="text-start h4">Cod: <span class="live-cod">327</span></span>
									<a class="btn btn-success d-none d-lg-block float-end fw-bolder">Pedir</a>
									<a class="btn btn-lg d-lg-none btn-success float-end fw-bolder">Pedir</a>
								</div>
							</div>

						</div>
					</div>
					<!-- Start Loopiong Through Errors -->

					<?php
					if (!empty($formErrors)) {
						foreach ($formErrors as $error) {
					?>
							<div class="row mt-3">
								<div class="col">
									<div class="alert alert-danger"><?= $error ?></div>
								</div>
							</div>
						<?php
						}
					}
					if (isset($succesMsg)) {
						?>
						<div class="row mt-3">
							<div class="col">
								<div class="alert alert-success"><?= $succesMsg ?></div>
							</div>
						</div>
					<?php
					}
					?>
					<!-- End Loopiong Through Errors -->
				</div>

			</div>
		</div>

	</div>

	<script>
		let loadFile = function(event) {
			let output = document.getElementById('output');
			output.src = URL.createObjectURL(event.target.files[0]);
			output.onload = function() {
				URL.revokeObjectURL(output.src) // free memory
			}
		}
	</script>

<?php
} else {
	header('Location: login.php');
	exit();
}
include $tpl . 'footer.php';
ob_end_flush();
?>