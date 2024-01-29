<?php
    ob_start();
    session_start();
    $pageTitle = 'Tank-Store';
    include 'init.php';
?>

<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-md-6">
            <form class="form-inline mb-2" action="index.php" method="GET">
                <div class="form-group">
                    <input type="text" class="form-control" name="search" placeholder="Ingrese marca o modelo">
                </div>
                <button type="submit" class="btn btn-primary ml-2">Buscar</button>
                <a href="index.php" class="btn btn-info ml-2">Mostrar Todos</a>
            </form>
        </div>
    </div>
    <div style="margin-top: 20px;"></div>
    <div class="row">
    <?php
    // Verificar si se ha enviado una búsqueda
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Construir la condición de búsqueda en la consulta SQL
    $condition = !empty($search) ? "WHERE Name LIKE '%$search%'" : 'WHERE Approve = 1';

    $allItems = getAllFrom('*', 'items', $condition, '', 'Item_ID');
    $count = 0; // Variable para llevar el conteo de tarjetas en la fila

    foreach ($allItems as $item) {
		echo '<div class="col-sm-12 col-md-6 col-lg-3">';
        echo '<div class="thumbnail item-box height-match">';
        
        // // Modificación para mostrar "CONSULTAR" cuando el precio es 1
        // if ($item['Price'] == 1) {
        //     echo '<span class="price-tag">CONSULTAR</span>';
        // } else {
        //     // Formatear el precio con un punto en los separadores de miles
        //     $formattedPrice = '$' . number_format($item['Price'], 0, ',', '.');
        //     echo '<span class="price-tag">' . $formattedPrice . '</span>';
        // }
            
        // Modificación para mostrar "CONSULTAR" cuando el precio es 1
        if ($item['Price'] == 1) {
            echo '<span class="price-tag" style="font-size: 24px; background-color: rgba(255, 0, 0, 1);">CONSULTAR</span>';
        } else {
            // Formatear el precio con un punto en los separadores de miles
            $formattedPrice = '$' . number_format($item['Price'], 0, ',', '.');
            echo '<span class="price-tag" style="font-size: 24px; background-color: rgba(255, 0, 0, 1);">' . $formattedPrice . '</span>';
        }

        // Agregar un pequeño espacio debajo del precio
        echo '<div style="margin-bottom: 30px;"></div>';

        if (empty($item['picture'])) {
            echo "<img style='width:100%;height:auto;' src='admin/uploads/default.png' alt='' />";
        } else {
            echo "<img style='width:100%;height:auto;' src='admin/uploads/items/" . $item['picture'] . "' alt='' />";
        }
        
        echo '<div class="caption">';
        echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'" style="color: black">' . $item['Name'] .'</a></h3>';
        echo "<p style='overflow-wrap: normal;overflow: hidden;'>". $item['Description'] . '</p>';
                
        // // Código y Botón de WhatsApp en la misma fila
        // echo '<div class="item-buttons" style="display: flex; justify-content: space-between; align-items: center;">';
        // echo '<span class="cod-label" style="font-size: 18px; font-weight: bold;">Cod: ' . $item['Country_Made'] . '</span>';
        // echo '<a href="https://wa.me/3364338670?text=Hola!%20Me%20gustaría%20consultar%20sobre%20el%20tanque%20Cod:%20' . $item['Country_Made'] . ',%20' . $item['Name'] . '" target="_blank" class="btn btn-success" style="margin-left: auto;">Pedir</a>';
        // Código y Botón de WhatsApp en la misma fila
        echo '<div class="item-buttons" style="display: flex; justify-content: space-between; align-items: center;">';
        echo '<span class="cod-label" style="font-size: 24px; font-weight: bold;">Cod: ' . $item['Country_Made'] . '</span>';
        echo '<a href="https://wa.me/3364338670?text=Hola!%20Me%20gustaría%20consultar%20sobre%20el%20tanque%20Cod:%20' . $item['Country_Made'] . ',%20' . $item['Name'] . '" target="_blank" class="btn btn-success" style="font-size: 24px; margin-left: auto;">Pedir</a>';
        
        echo '</div>';
        
        echo '</div>';
        echo '</div>';
        echo '</div>'; // Cierre del col-sm-6 col-md-3

        $count++; // Incrementa el conteo de tarjetas en la fila

        // Abre una nueva fila después de cada 4 tarjetas
        if ($count % 4 == 0) {
            echo '</div><div class="row">';
        }
    }

    // Cierra el div de la última fila
    echo '</div>';
    ?>
    </div>
    <div style="margin-bottom: 20px;"></div>
</div>

<?php
    include $tpl . 'footer.php'; 
    ob_end_flush();
?>
