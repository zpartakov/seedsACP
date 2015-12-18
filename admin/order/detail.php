<a href="javascript:window.print()" title="imprime facture"><img style="position: absolute; top: 5%; right: 20%;" src="../../images/print.jpg" alt="imprime facture"></a><br/>
<div style="margin-top: -100px">
<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0) {
	header('Location: index.php');
}

$orderId = (int)$_GET['oid'];

// get ordered items
$sql = "SELECT pd_name, pd_price, od_qty
	    FROM plantons_order_item oi, plantons_product p 
		WHERE oi.pd_id = p.pd_id and oi.od_id = $orderId
		ORDER BY od_id ASC";
//echo nl2br($sql) ."<br>"; //tests

		$result = dbQuery($sql);
		while ($row = dbFetchAssoc($result)) {
			if ($row['pd_thumbnail']) {
				$row['pd_thumbnail'] = WEB_ROOT . 'images/product/' . $row['pd_thumbnail'];
			} else {
				$row['pd_thumbnail'] = WEB_ROOT . 'images/no-image-small.png';
			}
			$cartContent[] = $row;
		}
		
	$numItem = count($cartContent);
	$subTotal = 0;

	for ($i = 0; $i < $numItem; $i++) {
		extract($cartContent[$i]);
		$productUrl = "index.php?c=$cat_id&p=$pd_id";
		$subTotal += $pd_price * $ct_qty;
$produits.='
	 <tr class="content">	
	  <td>'.utf8_encode($pd_name) .'</td>
<td align="right">' .$pd_price .'</td>	  
<td align="right">' .$od_qty .'</td>	  
<td align="right">' .displayAmount($pd_price * $od_qty) .'</td>	  
	 </tr>
';
$subTotal=$subTotal+($pd_price * $od_qty);
$adresse=$PersAdresse ."<br>" .$PersNPA ." " .$PersLocalite;
$tel=$PersTelephone;
$email=$PersAdresseEmail;
$date=$od_date;
$date_livraison=$date_livraison;
	}

//date french readable
$date=preg_replace("/ .*/","",$date);
$date=explode("-",$date);
$date=$date[2]."-".$date[1]."-".$date[0];

//date livraison french readable

$date_livraison=preg_replace("/ .*/","",$date_livraison);
$date_livraison=explode("-",$date_livraison);
$date_livraison=$date_livraison[2]."-".$date_livraison[1]."-".$date_livraison[0];

//calcul pointde livraison
$pdd="SELECT * FROM jos_pdds WHERE id = '" .$PersPDDDistrNo ."'";
$pdd=mysql_query("$pdd");
$pdd=mysql_result($pdd,0,'PDDTexte'); 

$result = dbQuery($sql);
$orderedItem = array();
while ($row = dbFetchAssoc($result)) {
	$orderedItem[] = $row;
}


// get order information

$sql = "SELECT * 
			FROM plantons_order o, plantons_order_item oi, tbl_customers c, plantons_product p 
			WHERE o.od_id = '" .$orderId
			."' AND oi.od_id = o.od_id
			 AND c.jos_user_id  = o.od_shipping_user 
			 AND p.pd_id=oi.pd_id";
//echo nl2br($sql) ."<br>"; //tests

			 
$result = dbQuery($sql);
extract(dbFetchAssoc($result));

$orderStatus = array('Nouveau', 'Payé', 'Envoyé', 'Terminé', 'Supprimé');
$orderOption = '';
foreach ($orderStatus as $status) {
	$orderOption .= "<option value=\"$status\"";
	if ($status == utf8_encode($od_status)) {
		$orderOption .= " selected";
	}
	
	$orderOption .= ">$status</option>\r\n";
	
	
$adresse=$PersAdresse ."<br>" .$PersNPA ." " .$PersLocalite;
$tel=$PersTelephone;
$email=$PersAdresseEmail;
$date=$od_date;
$date_livraison=$date_livraison;
	
}
//calcul point de livraison
$pdd="SELECT * FROM jos_pdds WHERE id = '" .$PersPDDDistrNo ."'";
$pdd=mysql_query("$pdd");
$pdd=mysql_result($pdd,0,'PDDTexte'); 
#echo $pdd; exit;
?>
<p>&nbsp;</p>
<form action="" method="get" name="frmOrder" id="frmOrder">
    <table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
        <tr> 
            <td colspan="2" align="center" id="infoTableHeader">Votre commande de plantons</td>
        </tr>
        <tr> 
            <td width="150" class="label">Commande numéro</td>
            <td class="content"><?php echo $orderId; ?></td>
        </tr>
        <tr> 
            <td width="150" class="label">Date de la commande</td>
            <td class="content">
<?php 
               //date french readable
$date=$od_date;
$date=preg_replace("/ .*/","",$date);
$date=explode("-",$date);
$date=$date[2]."-".$date[1]."-".$date[0];
$hour=preg_replace("/.* /","",$od_date);
$hour=preg_replace("/...$/","",$hour);
$hour=preg_replace("/:/","h",$hour);
echo $date .", " .$hour; 
?>
            </td>
        </tr>
        
        <tr>
			<td width="150" class="label">Livraison</td>
			<td class="content">
			<?php
			$datel=dbFetchAssoc($result);
				echo $datel['date_livraison'];
			?>
			</td>
        </tr>
        
        <tr class="printcache"> 
            <td width="150" class="label">Dernière mise à jour</td>
            <td class="content"><?php echo $od_last_update; ?></td>
        </tr>
        <tr class="printcache"> 
            <td class="label">Statut</td>
            <td class="content"> <select name="cboOrderStatus" id="cboOrderStatus" class="box">
                    <?php echo $orderOption; ?> </select> <input name="btnModify" type="button" id="btnModify" value="Modifer le statut" class="box" onClick="modifyOrderStatus(<?php echo $orderId; ?>);"></td>
        </tr>
        
    </table>
</form>
<p>&nbsp;</p>
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
    <tr id="infoTableHeader"> 
        <td colspan="3">Produits</td>
    </tr>
    <tr align="center"> 
        <th>Produit</th>
        <th>Prix unitaire</th>
        <th>Nombre</th>
        <th>Total</th>
    </tr>
    <?php
    
echo $produits;
    
?>
    <tr class="content"> 
        <td colspan="2" align="right"><strong>Total</strong></td>
        <td align="right" colspan="2"><strong><?php echo displayAmount($subTotal); ?></strong></td>
    </tr>
   
</table>
<p>&nbsp;</p>
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
    <tr id="infoTableHeader"> 
        <td colspan="2">Client</td>
    </tr>
	<tr>                            
		<td colspan="2" align="center" id="infoTableHeader">Vos coordonnées</td>
	</tr>
    <tr> 
        <td width="150">Prénom</td>
        <td class="content"><?php echo utf8_encode($PersPrenom); ?> </td>
    </tr>
    <tr> 
        <td width="150">Nom</td>
        <td class="content"><?php echo utf8_encode($PersNom); ?> </td>
    </tr>
    <tr> 
        <td width="150">Adresse</td>
        <td class="content"><?php echo utf8_encode($adresse); ?> </td>
    </tr>
   
    <tr> 
        <td width="150">Téléphone</td>
        <td class="content"><?php echo $tel; ?> </td>
    </tr>
    
        <tr> 
        <td width="150">Email</td>
        <td class="content"><?php echo "<a href=\"mailto:".$PersAdresseEmail ."\">" .$PersAdresseEmail ."</a>" 	; ?> </td>
    </tr>

    <tr> 
        <td width="150">Livraison</td>
        <td class="content"><?php echo $pdd; ?> </td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="550" border="0"  align="center" cellpadding="5" cellspacing="1" class="detailTable">
    <tr id="infoTableHeader"> 
        <td colspan="2">Mémo</td>
    </tr>
    <tr> 
        <td colspan="2" class="label"><?php echo nl2br($od_memo); ?> </td>
    </tr>
</table>
<p>&nbsp;</p>
<p align="center"> 
    <input name="btnBack" type="button" id="btnBack" value="Retour" class="box" onClick="window.history.back();">
</p>
<p style="position: relative; top: -50px; left: 380px;" ><a href="javascript:window.print()" title="imprime facture"><img src="../../images/print.jpg" alt="imprime facture"></a>
</p>
</div>
