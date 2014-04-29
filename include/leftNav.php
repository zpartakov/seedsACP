<?php
if (!defined('WEB_ROOT')) {
	exit;
}

// get all categories
$categories = fetchCategories();

// format the categories for display
$categories = formatCategories($categories, $catId);
?>
<ul>
<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>"><h1>Toutes les catégories</h1></a></li>
<?php
foreach ($categories as $category) {
	extract($category);
	// now we have $cat_id, $cat_parent_id, $cat_name
	
	$level = ($cat_parent_id == 0) ? 1 : 2;
    $url   = $_SERVER['PHP_SELF'] . "?c=$cat_id";

	// for second level categories we print extra spaces to give
	// indentation look
	if ($level == 2) {
		$cat_name = '&nbsp; &nbsp; &raquo;&nbsp;' . $cat_name;
	}
	
	// assign id="current" for the currently selected category
	// this will highlight the category name
	$listId = '';
	if ($cat_id == $catId) {
		$listId = ' id="current"';
	}
if(!preg_match("/<!-- nondisp -->/",$cat_name)) {  //doit-on montrer la categorie?
	echo "<li" .$listId."><a href=\"" .$url."\">" .utf8_encode($cat_name) ."</a></li>";
}

}
?>
</ul>
