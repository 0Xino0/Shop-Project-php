<?php
include("C:/wamp64/www/ShopProject/bootstrap/init/includes.php");

$edit_name_err = (isset($_GET['edit_name_err'])) ? $_GET['edit_name_err'] : "";
$edit_price_err = (isset($_GET['edit_price_err'])) ? $_GET['edit_price_err'] : "";
$edit_img_err = (isset($_GET['edit_img_err'])) ? $_GET['edit_img_err'] : "";

$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : "" ;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : "" ;
$tag_id = isset($_GET['tag_id']) ? $_GET['tag_id'] : "" ;


$result = show_edit($product_id,$conn);

$edit_name        = $result['name'];
$edit_price       = $result['price'];
$edit_category    = $result['category_name'];
$edit_caption     = $result['caption'];
$edit_image       = $result['img'];
$edit_tag         = $result['tags_name'];
$edit_tag_id      = $result['tag_id'];
$edit_category_id = $result['category_id'];

// var_dump($edit_tag_id);
// exit;





include("C:/wamp64/www/ShopProject/tpl/edit_tpl.php");
?>