<?
#echo phpinfo();
require_once '../../library/config.php';
require_once '../library/functions.php';
/*move a rank product
 * 
 * 
DROP TABLE IF EXISTS `plantons_product_rank`;
CREATE TABLE IF NOT EXISTS `plantons_product_rank` (
  `pd_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO plantons_product_rank
(SELECT pd_id, cat_id FROM plantons_product ORDER BY cat_id, pd_name);
ALTER TABLE `plantons_product_rank` ADD `rank` INT( 12 ) NOT NULL AUTO_INCREMENT ,
ADD PRIMARY KEY ( `rank` );
ALTER TABLE `plantons_product_rank` CHANGE `rank` `rank` INT( 12 ) NOT NULL;
ALTER TABLE `plantons_product_rank` DROP PRIMARY KEY;
 * 
 * OLD
 * create the table
 * 
DROP TABLE IF EXISTS `plantons_product_rank`;
CREATE TABLE IF NOT EXISTS `plantons_product_rank` (
  `pd_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `rank` int(3) NOT NULL,
  PRIMARY KEY (`pd_id`),
  UNIQUE KEY `pd_id` (`pd_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
* 
* update the table
TRUNCATE TABLE `plantons_product_rank`;
INSERT INTO plantons_product_rank
(SELECT pd_id, cat_id, pd_id FROM plantons_product)
 * */
$id=$_GET["id"];
$rank=$_GET["rang"];
$catid=$_GET["catid"];
$sens=$_GET["sens"];

#echo "Deplacer id " .$id ." rang: " .$rank ." catid: " .$catid ." sens: " .$sens; 


$sql="SELECT * FROM plantons_product p, plantons_product_rank r WHERE p.cat_id=".$catid ." AND p.pd_id=r.pd_id";
#echo $sql; exit;

if($sens=="up"){
	$preced= "SELECT * FROM plantons_product_rank WHERE rank < " .$rank ." AND cat_id = ".$catid ." ORDER BY rank DESC LIMIT 0,1";
	#echo $preced; exit;
	$preced=mysql_query($preced);
	$precedid=mysql_result($preced,0,'pd_id');
	$precedrang=mysql_result($preced,0,'rank');
	#echo "<br>id preced" .$precedid ." rang preced: " .$precedrang ."<br>"; 
	
	//on ajoute 2 a tous les rangs superieurs
	$sql="UPDATE plantons_product_rank SET rank = rank + 2 WHERE rank > " .$rank ." AND cat_id = " .$catid;
	#echo $sql; exit;
	$do=mysql_query($sql); 
	if(!$do) {
		echo mysql_error($do); exit;
	}

	//on deplace le précédent devant
	$do=mysql_query("UPDATE plantons_product_rank SET rank = " .$precedrang ."+1 WHERE pd_id = ".$precedid); 
	if(!$do) {
		echo mysql_error($do); exit;
	}

	//on monte
	$do=mysql_query("UPDATE plantons_product_rank SET rank = " .$precedrang ." WHERE pd_id = " .$id); 
	if(!$do) {
		echo mysql_error($do); exit;
	}

	header("Location: " .$_SERVER["HTTP_REFERER"]);

//descendre
} elseif($sens=="down"){

	$suivant= "SELECT * FROM plantons_product_rank WHERE rank > " .$rank ." AND cat_id = ".$catid ." ORDER BY rank ASC LIMIT 0,1";
	$suivant=mysql_query($suivant);
	$suivantid=mysql_result($suivant,0,'pd_id');
	$suivantrang=mysql_result($suivant,0,'rank');
	#echo "<br>id suivant" .$suivantid ." rang suivant: " .$suivantrang ."<br>";

	//on ajoute 1 a tous les rangs superieurs au suivant
	$do=mysql_query("UPDATE plantons_product_rank SET rank = rank + 1 WHERE rank > " .$suivantrang ." AND cat_id = " .$catid); 
	if(!$do) {
		echo mysql_error($do); exit;
	}
	//on monte
	$do=mysql_query("UPDATE plantons_product_rank SET rank = " .$suivantrang ." WHERE pd_id = " .$id); 
	if(!$do) {
		echo mysql_error($do); exit;
	}

	//on deplace le suivant derriere
	$do=mysql_query("UPDATE plantons_product_rank SET rank = " .$rank ." WHERE pd_id = ".$suivantid); 
	if(!$do) {
		echo mysql_error($do); exit;
	}


	header("Location: " .$_SERVER["HTTP_REFERER"]);


}else{
	echo "sens indefini!"; exit;
}

?>
