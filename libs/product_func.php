<?php 

function insert($user_name,$price,$caption,$new_img_name,$conn)
{

    $insert = "INSERT INTO shop (user_name,price,caption,img) VALUES (:user_name , :price , :caption , :new_img_name) ";
    $insert = $conn->prepare($insert);

    $insert->bindParam(":user_name",$user_name);
    $insert->bindParam(":price",$price);
    $insert->bindParam(":caption",$caption);
    $insert->bindParam(":new_img_name",$new_img_name);

    $insert->execute();


}

function test_input($data,)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function show($conn)
{

    $show = "SELECT s.user_name AS name,s.price,s.caption,s.img,GROUP_CONCAT(distinct t.tag_name) as tags_name,c.category_name,
            s.id as product_id,GROUP_CONCAT(distinct t.id) as tag_id,c.id as category_id
            FROM shop s
            JOIN pivot_tag_shop pts ON pts.product_id = s.id
            JOIN tag t ON pts.tag_id = t.id
            JOIN pivot_shop_category psc ON s.id = psc.product_id
            JOIN category c ON c.id = psc.category_id
            GROUP BY s.id";
    $show = $conn->prepare($show);

    $show->execute();
    $result = $show->fetchAll();
    
    return $result;

}

function delete($product_id ,$conn )
{

    $delete_product = "DELETE FROM shop WHERE id = $product_id";
    $delete_product = $conn->prepare($delete_product);
    $delete_product->execute();

    $delete_pivot_product = "DELETE FROM pivot_shop_category WHERE product_id = $product_id";
    $delete_pivot_product = $conn->prepare($delete_pivot_product);
    $delete_pivot_product->execute();

    $delete_pivot_tag = "DELETE FROM pivot_tag_shop WHERE product_id = $product_id";
    $delete_pivot_tag = $conn->prepare($delete_pivot_tag);
    $delete_pivot_tag->execute();

    $delete_cart = "DELETE FROM cart WHERE product_id = $product_id";
    $delete_cart = $conn->prepare($delete_cart);
    $delete_cart->execute();

}

function require_pivot_shop_category ($category_name , $user_name,$conn)
{
    $query = "SELECT id FROM category WHERE category_name = '$category_name'";
    $query = $conn->prepare($query);
    $query->execute();

    $result_category = $query->fetch();
    $category_id = $result_category['id'];

    $shop_query = "SELECT id FROM shop WHERE user_name = '$user_name'";
    $shop_query = $conn->prepare($shop_query);
    $shop_query->execute();

    $result_shop = $shop_query->fetch();
    $product_id = $result_shop['id'];

    $result = array($category_id , $product_id);
    return $result;
}

function insert_pivot_shop_category ($product_id, $category_id,$conn)
{
    $query_pivot = "INSERT INTO `pivot_shop_category` (`product_id`, `category_id`) VALUES (:product_id, :category_id)";
    $query_pivot = $conn->prepare($query_pivot);
    
    $query_pivot->bindParam(":product_id", $product_id);
    $query_pivot->bindParam(":category_id", $category_id);

    $query_pivot->execute();

}

function insert_tag ($tag_name,$conn)
{
    $sql = "INSERT INTO tag (tag_name) VALUES (:tag_name)";
    $sql = $conn->prepare($sql);

    $sql->bindParam(':tag_name', $tag_name);
    $sql->execute();

}

function require_pivot_shop_tag ($tag_name,$conn)
{
    $sql = "SELECT id FROM tag WHERE tag_name='$tag_name'";
    $sql = $conn->prepare($sql);
    $sql->execute();

    $result = $sql->fetch();
    $tag_id = $result['id'];

    return $tag_id;
}

function insert_pivot_shop_tag ($product_id , $tag_id,$conn)
{
    $sql = "INSERT INTO pivot_tag_shop (product_id, tag_id) VALUES (:product_id, :tag_id)";
    $sql = $conn->prepare($sql);

    $sql->bindParam(':product_id',$product_id);
    $sql->bindParam(':tag_id',$tag_id);

    $sql->execute();
}

function show_tag ($conn)
{
    $query = "SELECT * FROM tag ";
    $query = $conn->prepare($query);

    $query->execute();
    $result = $query->fetchAll();
    return $result;
}


?>