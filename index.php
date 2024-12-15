<?php
include("C:/wamp64/www/ShopProject/bootstrap/init/includes.php");

$name_err          = (isset($_GET['name_err'])) ? $_GET['name_err'] : "";
$price_err         = (isset($_GET['price_err'])) ? $_GET['price_err'] : "";
$img_err           = (isset($_GET['img_err'])) ? $_GET['img_err'] : "";
$message           = (isset($_GET['message'])) ? $_GET['message'] : "";
$add_category_err  = (isset($_GET['add_category_err'])) ? $_GET['add_category_err'] : "";
$tags_err          = (isset($_GET['tags_err'])) ? $_GET['tags_err'] : "" ;

include("C:/wamp64/www/ShopProject/tpl/index_tpl.php");
?>