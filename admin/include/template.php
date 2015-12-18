<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$self = WEB_ROOT . 'admin/index.php';
?>
<html>
<head>
<title><?php echo $pageTitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo WEB_ROOT;?>admin/include/admin.css" rel="stylesheet" type="text/css">
<!--<link href="<?php echo WEB_ROOT;?>admin/include/print.css" rel="stylesheet" type="text/css"> -->

<link href="<?php echo WEB_ROOT;?>admin/include/print.css" rel="stylesheet" type="text/css" media="print">
<script language="JavaScript" type="text/javascript" src="<?php echo WEB_ROOT;?>library/common.js"></script>
<?php
$n = count($script);
for ($i = 0; $i < $n; $i++) {
	if ($script[$i] != '') {
		echo '<script language="JavaScript" type="text/javascript" src="' . WEB_ROOT. 'admin/library/' . $script[$i]. '"></script>';
	}
}
?>
</head>
<body>

<table border="0" align="center" cellpadding="0" cellspacing="1">
<div  class="menu"> 
 <tr>
	 <td class="printonly">
<br>
Les Jardins de Cocagne<br>
C.P. 245<br>
CH-1233 Bernex<br>
Tél. au jardin 022 756 34 45<br>
Cocagne@Cocagne.ch<br>
www.cocagne.ch
	 </td>
    <td>
    <img style="width: 250px; vertical-align: top" src="http://www.les-jardins-de-cocagne.ch/images/JaCoLogo1.gif">
    &nbsp;
    <img class="printcache" style="width: 100px" src="/plantons/images/planton.jpg" alt="Accueil commande de plantons">
    </td>
  </tr>
  <tr class="printonly" style="height: 50px">
  <td>
  &nbsp;</td>
  </tr>
  <tr>
    <td width="150" valign="top" class="navArea"><p>&nbsp;</p>
      <a href="<?php echo WEB_ROOT; ?>admin/" class="leftnav">Accueil</a> 
      <a href="<?php echo WEB_ROOT; ?>admin/message/" class="leftnav">Message d'accueil</a> 
	  <a href="<?php echo WEB_ROOT; ?>admin/category/" class="leftnav">Gestion des groupes d'articles</a>
	  <a href="<?php echo WEB_ROOT; ?>admin/product/" class="leftnav">Gestion des articles</a> 
	  <a href="<?php echo WEB_ROOT; ?>admin/order/" class="leftnav">Commandes</a> 
	  <a href="<?php echo WEB_ROOT; ?>admin/order/index.php?view=all" class="leftnav">Toutes les commandes</a> 
	  <a href="<?php echo WEB_ROOT; ?>admin/config/" class="leftnav">Configuration</a> 
	  <a href="<?php echo WEB_ROOT; ?>admin/user/" class="leftnav">Administrateurs</a> 
	  <a href="<?php echo WEB_ROOT; ?>admin/vacances/" class="leftnav">Vacances</a> 
	  <!--<a href="<?php echo WEB_ROOT; ?>" class="leftnav" target="_blank">Magasin</a> -->
	  <a href="<?php echo $self; ?>?logout" class="leftnav">Logout</a>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="" valign="top" class="contentArea"><table width="100%" border="0" cellspacing="0" cellpadding="20">
        <tr>
        <tr>
			<td class="printcache">
				<form action="../search.php" method="GET">
					<input type="text" name="cherche" value="" onChange="submit()"><input type="submit" value="chercher">
				</form>
			</td>
		</tr>
  </div>

          <td>
</div>
			  
<?php
require_once $content;	 
?>


          </td>
        </tr>
      </table></td>
  </tr>
</table>

<p>&nbsp;</p>
<div class="cacher">

<p align="center">Copyright &copy; 2005 - <?php echo date('Y'); ?> <a href="http://www.phpwebcommerce.com"> www.phpwebcommerce.com</a>
<br><a style="font-size: 1em; color: #666666;" href="mailto:radeff@akademia.ch">modified: Fred Radeff</a></p>
</div>

</body>
</html>
