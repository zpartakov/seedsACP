<?php
if (!defined('WEB_ROOT')
    || !isset($_GET['step']) || (int)$_GET['step'] != 1) {
	exit;
}

$errorMessage = '&nbsp;';

//on interroge la base des  clients qui commandent des produits

$sql="
SELECT * FROM tbl_customers
WHERE 
jos_user_id=".$_SESSION['uid'];
#echo "<br>SQL1<br>".$sql."<hr>"; //tests
$sql=mysql_query($sql);
if(!$sql) {
	echo "SQL error: " .mysql_error(); exit;
}
if(mysql_num_rows($sql)==0) { //the user is not registred
	echo '<meta http-equiv="refresh" content="0;URL=register.php">';
	#header("Location: register.php"); //redirect user to registration
} else { //registration ok
//mysql values
$txtShippingFirstName=utf8_encode(mysql_result($sql,0,"PersPrenom"));
$txtShippingLastName=utf8_encode(mysql_result($sql,0,"PersNom"));
$txtShippingAddress1=utf8_encode(mysql_result($sql,0,"PersAdresse"));
$txtShippingPhone=utf8_encode(mysql_result($sql,0,"PersTelephone"));
$txtShippingCity=utf8_encode(mysql_result($sql,0,"PersLocalite"));
$txtShippingPostalCode=utf8_encode(mysql_result($sql,0,"PersNPA"));
#$txtShippingState=utf8_encode(mysql_result($sql,0,"PersAdresseEmail")); //todo: replace this field with new email field
$txtEmail=utf8_encode(mysql_result($sql,0,"PersAdresseEmail")); 	
$PDDINo=utf8_encode(mysql_result($sql,0,"PersPDDDistrNo")); 	

$sqlPDD="
SELECT * FROM jos_pdds 
WHERE 
id=" .$PDDINo;

#echo "<br>SQL2<br>".$sqlPDD."<hr>"; exit; //tests
#do and check sql
$sqlPDD=mysql_query($sqlPDD);
if(!$sqlPDD) {
	echo "SQL error: " .mysql_error(); exit;
}
$PDDTexte=utf8_encode(mysql_result($sqlPDD,0,"PDDTexte")); 	
}

#echo $PDDTexte; exit;

/*
 * debut calcul date de livraison, inutilisé
 * */
 
/* initialisation des variables */
$jour=date("d");
$mois=date("m");
$annee=date("Y");
$heure=date("H");
$minutes=date("i");
$annee=date("Y");
//N  numeric representation of the day of the week (added in PHP 5.1.0)  	1 (for Monday) through 7 (for Sunday)
$jourdelasemaine=date("N");
$semaine=date("W");
$maintenant = mktime($heure, $minutes, 0, $mois, $jour, $annee);
/* tests
 * 
 * */
#$njours=-7; //tests
#$njours=-6; //tests
#$njours=-5; //tests
#$njours=-4; //tests
#$njours=-3; //tests
#$njours=-2; //tests
#$njours=-1; //tests
#$njours=1; //tests
#$njours=2; //tests
#$njours=3; //tests
#$njours=4; //tests
#$njours=5; //tests
#$njours=6; //tests
#$njours=7; //tests
#$maintenant=$maintenant+($njours*24*3600);
/*fin tests
 * */

$heure=date("H", $maintenant);
$jourdelasemaine=date("N", $maintenant);
$semaine=date("W", $maintenant);


if($jourdelasemaine==5||$jourdelasemaine==6||$jourdelasemaine==7) { //vendredi, samedi ou dimanche
	//if(preg_match('/^Sun/',$today)){
	if($jourdelasemaine==7){ //dimanche
	echo "<br>C'est dimanche, il est " .$heure ."h"; //tests
		#if($heure>5) { //tests
		if($heure>17) {
			echo "<br>Il est 17h passé"; //tests
			//commande reportée au jeudi dans 2 semaines
			$delai=2;
		} else {
			//commande pour le jeudi qui vient
			$delai=1;
		}
	} else {
			//commande pour le jeudi qui vient
			$delai=1;
	}
} else { //lundi à jeudi
		//commande reportée au jeudi dans 2 semaines
	$delai=1;
}

//calcul de la semaine de livraison
	$semainel=$semaine+$delai;
#echo "<br>Semaine de livraison: " .$semaine ."<br>"; //tests

 $tmp = get_lundi_dimanche_from_week($semainel,$annee);
 #print $tmp[0]."<BR>"; // date du lundi
 $jeudi= $tmp[1]; // date du jeudi
 $jeudi2= $tmp[2]; // date du jeudi
 $jeudi3= $tmp[3]; // date du jeudi
 $jeudi4= $tmp[4]; // date du jeudi
 $jeudi5= $tmp[5]; // date du jeudi
 $jeudi6= $tmp[6]; // date du jeudi
 $jeudi7= $tmp[7]; // date du jeudi
 $jeudi8= $tmp[8]; // date du jeudi
 
/*
 * fin calcul date de livraison, inutilisé
 * */

/*
 * la date livraison n'est plus une date mais un VARCHAR255, statique
 * */ 
   
 //calcul des jeudis options
 $jeudi="à mon point de distribution le jeudi 7 mai";
 $jeudi2="à mon point de distribution le jeudi 14 mai";
 $jeudi3="à mon point de distribution le jeudi 21 mai";
 $jeudi4="je passe au jardin";
 $jeudi5="au marché de Plainpalais";
 $jeudi6="au marché de Rive";
 $jeudi7="au marché à Galiffe (9 mai)";
 
 
 $jeudis="
 <option>$jeudi</option>\n
 <option>$jeudi2</option>\n
 <option>$jeudi3</option>\n
 <option>$jeudi4</option>\n
 <option>$jeudi5</option>\n
 <option>$jeudi6</option>\n
 ";/*
  *  <option>$jeudi7</option>\n
 <option>$jeudi8</option>\n
 
  */
 
#echo "<br>Livraison pour le jeudi: " .$jeudi."<BR>"; //tests
#echo "<br>Livraison pour le jeudi suivant: " .$jeudi2."<BR>"; //tests
/*
 * echo "
<pre>
date " .date("D, d-m-Y h:s",$maintenant) ."
semaine " .$semaine ."
heure " .date("H",$maintenant) ."
jourdelasemaine " .$jourdelasemaine ."
semainel " .$semainel ."
jeudi " .$delai ."
</pre>";
*/
?>
<script language="JavaScript" type="text/javascript" src="library/checkout.js"></script>



<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
    <tr>
    <td>
    Si les informations ci-dessous sont incorrectes, veuillez <a href="register.php?jid=<? echo $_SESSION['uid'];?>" target="_blank">les modifier</a> puis 
    
    <? 
    echo '<a href="' .$_SERVER["PHP_SELF"] .'">recharger cette page</a></td></tr>';
    ?>
    <tr> 
        <td>Confirmation de la commande</td>
    </tr>
</table>
<?
#if((strlen(<$errorMessage)>0)&&($errorMessage<>"&nbsp;")) {
if((strlen($errorMessage)>0)&&($errorMessage!="&nbsp;")) {
	?>
<p id="errorMessage"><?php echo $errorMessage; ?></p>
<?
}




#####################################
?>
<!--<form action="<?php echo $_SERVER['PHP_SELF']; ?>?step=2" method="post" name="frmCheckout" id="frmCheckout" onSubmit="return checkShippingAndPaymentInfo();">-->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?step=2" method="post" name="frmCheckout" id="frmCheckout">
 <input type="hidden" name="joomla_uid" value="<? echo $_SESSION['uid'] ?>">
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
        <tr class="entryTableHeader"> 
            <td colspan="2">Livraison</td>
        </tr>
        <tr> 
            <td width="150" class="label">Prénom</td>
            <td class="content"><input name="txtShippingFirstName" value="<? echo $txtShippingFirstName; ?>" type="hidden" id="txtShippingFirstName">
            <? echo $txtShippingFirstName; ?>
            </td>
        </tr>
        <tr> 
            <td width="150" class="label">Nom</td>
            <td class="content"><input name="txtShippingLastName" value="<? echo $txtShippingLastName; ?>" type="hidden" class="box" id="txtShippingLastName" size="30" maxlength="50">
            <? echo $txtShippingLastName; ?>
            </td>
        </tr>
        <tr> 
            <td width="150" class="label">Adresse</td>
            <td class="content"><input name="txtShippingAddress1" id="txtShippingAddress1" value="<? echo $txtShippingAddress1; ?>" type="hidden"><? echo nl2br($txtShippingAddress1); ?></td>
        </tr>
        <!--<tr> 
            <td width="150" class="label">Adresse 2</td>
            <td class="content"><input name="txtShippingAddress2" type="text" class="box" id="txtShippingAddress2" size="50" maxlength="100"></td>
        </tr>-->
        

        <tr> 
            <td width="150" class="label">Téléphone</td>
            <td class="content"><input name="txtShippingPhone" value="<? echo $txtShippingPhone; ?>" type="hidden" class="box" id="txtShippingPhone" size="30" maxlength="32"><? echo $txtShippingPhone; ?></td>
        </tr>

        <tr> 
            <td width="150" class="label">Commune</td>
            <td class="content"><input name="txtShippingCity" value="<? echo $txtShippingCity; ?>" type="hidden" class="box" id="txtShippingCity" size="30" maxlength="32"><? echo $txtShippingCity; ?></td>
        </tr>
        <tr> 
            <td width="150" class="label">Code Postal</td>
            <td class="content"><input name="txtShippingPostalCode" value="<? echo $txtShippingPostalCode; ?>" type="hidden" class="box" id="txtShippingPostalCode" size="10" maxlength="10"><? echo $txtShippingPostalCode; ?></td>
        </tr>
        <tr> 
            <td width="150" class="label">Email</td>
            <td class="content"><input name="txtEmail" value="<? echo $txtEmail; ?>" type="hidden" class="box" id="txtShippingState" size="30" maxlength="32"><? echo $txtEmail; ?></td>
        </tr>
             <tr> 
            <td width="150" class="label"><? echo label_where2deliver; ?></td>
            <td>
            
			<?
echo $PDDTexte;
			?>
            </td>
        </tr>
        <tr> 
            <td width="150" class="label"><? echo label_when2deliver; ?> (souhaitée)</td>
            <td class="content">
		<?
		//module de gestion des vacances radeff
		$sql="SELECT * FROM plantons_vacances";
		$sql=mysql_query($sql);
		if(!$sql) {
			echo "sql error: " .mysql_error(); 
			exit;
		}
		$vacances=mysql_result($sql,0,'actif');
		//echo "vacances: " .$vacances ."<br>"; //tests
		//on est en vacances
		if($vacances=="1") {
			$date_livraison="jeudi " .mysql_result($sql,0,'date');
			
			echo mysql_result($sql,0,'date'). '<input type="hidden" name="date2livraison" value="' .mysql_result($sql,0,'date') .'">';
		//normal	
		} else {
			echo '<select name="date2livraison">';
			echo $jeudis;
			echo '</select>';
		}				
		?>				
		</td>
        </tr>   
        <tr>
        <td valign="top">
   Message     </td>
   <td>
<textarea name="message" rows="3" cols="30"></textarea>
   <br>
<?echo label_post_remarques;?>   </td>
        </tr>
   
        
    </table>
<!--Vous pouvez modifier les quantités ou les dates. Si vous voulez annuler un article,
il suffit de mettre sa quantité à zéro.

Pour ajouter d'autres articles, retournez à la fenêtre des articles.-->


</pre>
    <p align="center"> 
        <input class="box" name="btnStep1" type="submit" id="btnStep1" value="Continuer &gt;&gt;">
    </p>
</form>
