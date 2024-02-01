<?php
session_start();
include 'init.php';

if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
	$category = intval($_GET['pageid']);
	$allItems = getAllFrom("*", "items", "where Cat_ID = {$category}", "AND Approve = 1", "Item_ID");

	function getSingleValue($con, $sql, $parameters)
	{
		$q = $con->prepare($sql);
		$q->execute($parameters);
		return $q->fetchColumn();
	}

	$myCategory = getSingleValue($con, "SELECT Name FROM categories WHERE id=?", [$category]);
?>

	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="text-center"><?= $myCategory ?></h1>
			</div>
		</div>

		<div class="row">
			<?php
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
								<a class="h3 link-dark link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="items.php?itemid=<?= $item['Item_ID'] ?>"><?= $item['Name'] ?></a>
							</h5>
							<p class="card-text fs-5">
								<?= $item['Description'] ?>
							</p>
							<span class="text-start h4">Cod: <?= $item['Country_Made'] ?></span>
							<a class="btn btn-success d-none d-lg-block float-end fw-bolder" href="https://wa.me/3364338670?text=Hola!%20Me%20gustaría%20consultar%20sobre%20el%20tanque%20Cod:%20<?= $item['Country_Made'] ?>,%20<?= $item['Name'] ?>" target="_blank">Pedir</a>
							<a class="btn btn-lg d-lg-none btn-success float-end fw-bolder" href="https://wa.me/3364338670?text=Hola!%20Me%20gustaría%20consultar%20sobre%20el%20tanque%20Cod:%20<?= $item['Country_Made'] ?>,%20<?= $item['Name'] ?>" target="_blank">Pedir</a>
						</div>
					</div>
				</div>
			<?php
			}
			?>
		</div>

	<?php
} else {
	?>
		<div class="row">
			<div class="col">
				You Must Add Page ID
			</div>
		</div>
	<?php
}
	?>
	</div>

	<?php include $tpl . 'footer.php'; ?>