<?php

	$dsn = 'mysql:host=localhost;dbname=u858210262_ariel_en_moto';
	$user = 'u858210262_ariel_en_moto';
	$pass = 'aW]F;E&?7W?';
	$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

	try {
		$con = new PDO($dsn, $user, $pass, $option);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOException $e) {
		echo 'Failed To Connect' . $e->getMessage();
	}