<?php 
include("C:/wamp64/www/ShopProject/bootstrap/init/includes.php");

$category_id = (isset($_GET['btn_category'])) ? $_GET['sidebar_category'] : "";
$subcategory_id = (isset($_GET['btn_subcategory'])) ? $_GET['sidebar_subcategory'] : "";

include("C:/wamp64/www/ShopProject/tpl/category_tpl.php");
?>