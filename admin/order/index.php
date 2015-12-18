<?php
require_once '../../library/config.php';
require_once '../library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content 	= 'list.php';		
		$pageTitle 	= 'Administration des commandes de plantons - Voir les commandes';
		break;

	case 'detail' :
		$content 	= 'detail.php';		
		$pageTitle 	= 'Administration des commandes de plantons - Détail';
		break;

	case 'modify' :
		modifyStatus();
		$content 	= 'modify.php';		
		$pageTitle 	= 'Administration des commandes de plantons - Modifier les commandes';
		break;
		
	case 'all' :
		$content 	= 'all.php';		
		$pageTitle 	= 'Administration des commandes de plantons - voir toutes les commandes';
		break;	

	default :
		$content 	= 'list.php';		
		$pageTitle 	= 'Administration des commandes de plantons';
}




$script    = array('order.js');

require_once '../include/template.php';
?>
