<?php

	function lang($phrase) {

		static $lang = array(

			// Navbar Links

			'HOME_ADMIN' 	=> 'Inicio',
			'CATEGORIES' 	=> 'Categorias',
			'ITEMS' 		=> 'Items',
			'MEMBERS' 		=> 'Miembros',
			'FEEDBACKS'		=> 'Feedbacks',
			'STATISTICS' 	=> 'Estadisticas',
			'LOGS' 			=> 'Registros',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => ''
		);

		return $lang[$phrase];

	}
