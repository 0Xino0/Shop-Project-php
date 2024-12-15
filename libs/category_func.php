<?php 

function add_category ($category_name,$conn)
{
    $cat_id = 0;

    $add_category = "INSERT INTO category (category_name,cat_id) VALUES (:category_name , :cat_id)";
    $add_category = $conn->prepare($add_category);

    $add_category->bindParam(":category_name", $category_name);
    $add_category->bindParam(":cat_id", $cat_id);

    $add_category->execute();
}

function get_id_category ($category_name,$conn)
{

    $get_id = "SELECT id FROM category WHERE category_name = '$category_name' ";
    $get_id = $conn->prepare($get_id);
    $get_id->execute();

    $result = $get_id->fetch();
    return $result;
}

function add_subcategory ($subcategory_name , $cat_id,$conn)
{
    $category_name = $subcategory_name;

    $insert_subcategory = "INSERT INTO category (category_name,cat_id) VALUES (:category_name,:cat_id)";
    $insert_subcategory = $conn->prepare($insert_subcategory);

    $insert_subcategory->bindParam(":category_name" , $category_name);
    $insert_subcategory->bindParam(":cat_id" , $cat_id);

    $insert_subcategory->execute();
}

function sidebar_category ($conn)
{
    $show = "SELECT * FROM `category` WHERE `cat_id` = 0 ";
    $show = $conn->prepare($show);
    $show->execute();

    $result = $show->fetchAll();

    return $result;
}

function sidebar_subcategory ($cat_id,$conn)
{
    $sql = "SELECT * FROM `category` WHERE `cat_id` = $cat_id";
    $sql = $conn->prepare($sql);
    $sql->execute();

    $res_subcat = $sql->fetchAll();
    return $res_subcat;

}

function show_category ($cat_id,$conn)
{
    $show =" SELECT s.user_name AS name,s.price,s.caption,s.img,GROUP_CONCAT(distinct t.tag_name) as tags_name,c.category_name,
            s.id as product_id,GROUP_CONCAT(distinct t.id) as tag_id,c.id as category_id
            FROM shop s
            JOIN pivot_tag_shop pts ON pts.product_id = s.id
            JOIN tag t ON pts.tag_id = t.id
            JOIN pivot_shop_category psc ON s.id = psc.product_id
            JOIN category c ON c.id = psc.category_id
            WHERE c.cat_id = $cat_id
            GROUP BY s.id";

    $show = $conn->prepare($show);
    $show->execute();

    $result = $show->fetchAll();
    return $result;
}

function show_subcategory ($id,$conn)
{
    $show =" SELECT s.user_name AS name,s.price,s.caption,s.img,GROUP_CONCAT(distinct t.tag_name) as tags_name,c.category_name,
            s.id as product_id,GROUP_CONCAT(distinct t.id) as tag_id,c.id as category_id
            FROM shop s
            JOIN pivot_tag_shop pts ON pts.product_id = s.id
            JOIN tag t ON pts.tag_id = t.id
            JOIN pivot_shop_category psc ON s.id = psc.product_id
            JOIN category c ON c.id = psc.category_id
            WHERE c.id = $id
            GROUP BY s.id";

    $show = $conn->prepare($show);
    $show->execute();

    $result = $show->fetchAll();
    return $result;
}

function get_category_or_subcategory_data($category_id, $subcategory_id, $conn)
{
    if (!empty($category_id))
    {
        return show_category($category_id, $conn);
    }
    else
    {
        return show_subcategory($subcategory_id, $conn);
    }
}



?>