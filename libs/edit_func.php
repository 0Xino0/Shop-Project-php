<?php 

function edit($product_id_edit, $edit_name , $edit_price , $edit_caption ,$edit_tags,$tags_id,$edit_category, $edit_image,$conn)
{
    $product_id  = $product_id_edit;
    $category_id = $edit_category;


    $edit_product = "UPDATE shop 
                    SET user_name=:edit_name , price=:edit_price , caption=:edit_caption , img=:edit_image  
                    WHERE id=$product_id";
    $edit_product = $conn->prepare($edit_product);

    $edit_product->bindParam(":edit_name",$edit_name);
    $edit_product->bindParam(":edit_price",$edit_price);
    $edit_product->bindParam(":edit_caption",$edit_caption);
    $edit_product->bindParam(":edit_image",$edit_image);

    $edit_product->execute();

    if(!empty($edit_tags))
    {
        foreach($tags_id as $tag_id)
        {
            $delet_tags = "DELETE FROM pivot_tag_shop
                            WHERE tag_id = $tag_id";
            $delet_tags = $conn->prepare($delet_tags);
            $delet_tags->execute();                
        }

        foreach($edit_tags as $edit_tag)
        {
            $insert_tag = "INSERT INTO pivot_tag_shop (product_id, tag_id) 
                            VALUES ($product_id, $edit_tag)";
            $insert_tag = $conn->prepare($insert_tag);
            $insert_tag->execute();                   
        }
        
    }

    $edit_shop_category = "UPDATE pivot_shop_category
    SET category_id = :category_id
    WHERE product_id = $product_id";

    $edit_shop_category = $conn->prepare($edit_shop_category);

    $edit_shop_category->bindParam(":category_id",$category_id);
    $edit_shop_category->execute();

}

function show_edit($edit_product_id,$conn)
{
    $id = $edit_product_id;

    $show = " SELECT s.user_name AS name,s.price,s.caption,s.img,GROUP_CONCAT(distinct t.tag_name) as tags_name,c.category_name,
            s.id as product_id,GROUP_CONCAT(distinct t.id) as tag_id,c.id as category_id
            FROM shop s
            JOIN pivot_tag_shop pts ON pts.product_id = s.id
            JOIN tag t ON pts.tag_id = t.id
            JOIN pivot_shop_category psc ON s.id = psc.product_id
            JOIN category c ON c.id = psc.category_id
            WHERE s.id = $id
            GROUP BY s.id ";

    $show = $conn->prepare($show);

    $show->execute();
    $result = $show->fetch();
    
    return $result;

}

?>