<?php
ob_start();
session_start();
$pageTitle = 'Tank-Store';
include 'init.php';
?>

<main class="container py-3">
	<div class="row">
		<?php
		// Verificar si se ha enviado una búsqueda
		$search = isset($_GET['search']) ? $_GET['search'] : '';

		// Construir la condición de búsqueda en la consulta SQL
		$condition = !empty($search) ? "WHERE Name LIKE '%$search%'" : 'WHERE Approve = 1';

		$allItems = getAllFrom('*', 'items', $condition, '', 'Item_ID');

		// Contar el número de resultados de la búsqueda
		$resultCount = count($allItems);

		if ($resultCount == 0 && !empty($search)) {
			// Si no se encontraron resultados y se realizó una búsqueda
			?>
			<div class="col-12">
				<div class="alert alert-warning" role="alert">
					Lo siento, no se encontraron resultados. ¡Pero puedes consultarnos aquí!
					<br>
					<a class="btn btn-success my-2" href="https://wa.me/3364338670?text=Hola!%20Quisiera%20consultar%20por%20un%20tanque%20de%20radiador" target="_blank">Consultar por WhatsApp</a>
				</div>
			</div>
		<?php
		}
		else {
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
			}
			?>
	</div>
</main>

<?php
include $tpl . 'footer.php';
ob_end_flush();
?>