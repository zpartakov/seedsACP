<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	default :
		$content 	= 'main.php';		
		$pageTitle 	= 'Administration des commandes de plantons - Configuration';
}

$script    = array('shop.js');

require_once '../include/template.php';
?>
