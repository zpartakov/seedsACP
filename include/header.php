<?php
if (!defined('WEB_ROOT')) {
	exit;
}


require_once 'admin/library/functions.php';



// set the default page title
if(!isset($pageTitle)){
$pageTitle = $shopConfig['name'] ." - " .SITE_NAME;
}
// if a product id is set add the product name
// to the page title but if the product id is not
// present check if a category id exist in the query string
// and add the category name to the page title
if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
	$pdId = (int)$_GET['p'];
	$sql = "SELECT pd_name
			FROM plantons_product
			WHERE pd_id = $pdId";
	
	$result    = dbQuery($sql);
	$row       = dbFetchAssoc($result);
	$pageTitle = $row['pd_name'];
	
} else if (isset($_GET['c']) && (int)$_GET['c'] > 0) {
	$catId = (int)$_GET['c'];
	$sql = "SELECT cat_name
	        FROM plantons_category
			WHERE cat_id = $catId";

    $result    = dbQuery($sql);
	$row       = dbFetchAssoc($result);
	$pageTitle = $row['cat_name'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Plantons: <?php echo decoder($pageTitle); ?></title>
  <link href="/plantons/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="include/shop.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="library/common.js"></script>
</head>
<BODY>

<NOSCRIPT><h1>Vous devez activer JavaScript!</h1><br></NOSCRIPT>
<div id="scrollable">
<table align="center"><tr><td>
<a href="/cms/" title="Retour à la page d'accueil"><img style="width: 150px; padding-bottom: 30px;" src="<?php echo LOGO; ?>" alt="Retour à la page d'accueil"></a>
&nbsp;
<a href="/plantons/" title="Accueil commande de plantons">
<img style="width: 100px" src="/plantons/images/gif/plantont_poussant.gif" alt="Accueil commande de plantons">
</a>
<br>
<span style="padding-left: 30px; font-style: italic"><? echo SITE_NAME; ?></span>
</td></tr></table>
<?php 
if(!isset($_SESSION['uid'])){
	echo "<div style=\"font-size: 1.5em; margin-left: 30%; margin-right: 30%; padding: 2em; background-color: lightyellow\">";
	echo "Vous devez vous connecter avec votre identifiant et votre mot de passe sur le site";
	//echo '<br><a href="' .HOME_SITE.'">Retour au site</a>';
	echo '<br><a href="' .HOME_SITE.'cms/login-logout">Se connecter</a>';
	echo "</div>";
	require_once 'footer.php';
	
	exit; 
}
if($_SESSION['uid']) {
?>
<div class="chercher">
<form action="index.php" method="GET">chercher:&nbsp;<input type="text" name="cherche" value="" onChange="submit()"></form>
</div> 
<?php 
}
?>