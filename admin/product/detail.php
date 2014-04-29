<?php
if (!defined('WEB_ROOT')) {
	exit;
}

// make sure a product id exists
if (isset($_GET['productId']) && $_GET['productId'] > 0) {
	$productId = $_GET['productId'];
} else {
	// redirect to index.php if product id is not present
	header('Location: index.php');
}

$sql = "SELECT cat_name, pd_name, pd_description, pd_price, pd_qty, pd_image
        FROM plantons_product pd, plantons_category cat
		WHERE pd.pd_id = $productId AND pd.cat_id = cat.cat_id";
$result = mysql_query($sql) or die('Cannot get product. ' . mysql_error());

$row = mysql_fetch_assoc($result);
extract($row);

if ($pd_image) {
	$pd_image = WEB_ROOT . 'images/product/' . $pd_image;
} else {
	$pd_image = WEB_ROOT . 'images/no-image-large.png';
}


?>
<p>&nbsp;</p>
<form action="processProduct.php?action=addProduct" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">Catégorie</td>
   <td class="content"><?php echo decoder($cat_name); ?></td>
  </tr>
  <tr> 
   <td width="150" class="label">Nom du produit</td>
   <td class="content"> <?php echo decoder($pd_name); ?></td>
  </tr>
  <tr> 
   <td width="150" class="label">Description</td>
   <td class="content"><?php echo nl2br(decoder($pd_description)); ?> </td>
  </tr>
  <tr> 
   <td width="150" height="36" class="label">Prix</td>
   <td class="content"><?php echo formater_nombre($pd_price); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Qantité en stock</td>
   <td class="content"><?php echo formater_nombre_entier($pd_qty); ?> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Image</td>
   <td class="content"><img src="<?php echo $pd_image; ?>"></td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnModifyProduct" type="button" id="btnModifyProduct" value="Enregistrer" onClick="window.location.href='index.php?view=modify&productId=<?php echo $productId; ?>';" class="box">
  &nbsp;&nbsp;
  <input name="btnBack" type="button" id="btnBack" value=" Retour " onClick="window.history.back();" class="box">
 </p>
</form>
