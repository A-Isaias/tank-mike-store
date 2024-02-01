<?php
session_start();
include 'init.php';
?>

<?php
function getSingleValue($con, $sql, $parameters)
{
	$q = $con->prepare($sql);
	$q->execute($parameters);
	return $q->fetchColumn();
}
$myCategory = getSingleValue($con, "SELECT UserID FROM users WHERE username=?", [$_SESSION['user']]);
$allItems = getAllFrom("*", "items", "where Member_ID = {$myCategory}", "AND Approve = 1", "Item_ID");

?>
<div class="container">
	<div class="row">
		<div class="col">
			<h1 class="text-center">My Items</h1>
		</div>
	</div>

	<div class="row">
		<?php
		if (!empty($allItems)) {
			foreach ($allItems as $item) {
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
		} else {
			?>
			<div class="col-12 text-center">
				Sorry. There No Ads To Show. Create <a class="btn btn-success" href="newad.php">New Ad</a>
			</div>
		<?php
		}
		?>
	</div>
</div>

<?php include $tpl . 'footer.php'; ?>