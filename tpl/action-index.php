<?php
include("C:/wamp64/www/ShopProject/bootstrap/init/includes.php"); 


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add']))
{   

    $category_name = $_POST['category'];
    $user_name     = $_POST['user_name'];
    $price         = $_POST['price'];
    $caption       = $_POST['caption'];
    $img           = $_FILES['image'];
    $tags          = $_POST['tags'];

    $tags_err = "";
    
    //validate tag
    if(empty($tags))
    {
        $tags_err = "Please select tags";
    }
    else
    {
        $tags_err = "";
    }

    // validate image 
    $res_img = validate_image($img);

    $new_img_name = $res_img[0];
    $img_err = $res_img[1];

    // validate name and price
    $result = validate($user_name,$price);

    $var = $result[0]; 
    $err = $result[1];  

    if(empty($img_err) && empty($err[0]) && empty($err[1]) && empty($tags_err))
    {
        // insert data into shop table
        insert($var[0] , $var[1] , $caption , $new_img_name,$conn );

        // get category_id and product_id from database
        $result_id = require_pivot_shop_category($category_name , $user_name,$conn);
        $category_id = $result_id[0];
        $product_id = $result_id[1];

        // insert id of product and category into pivot table
        insert_pivot_shop_category($product_id,$category_id,$conn);

        // insert id of product and tags into pivot table
        foreach($tags as $tag_id)
        {
            insert_pivot_shop_tag($product_id,$tag_id,$conn);
        }
        


        $message = "Add Product To Shop";
        $message_succcess = http_build_query(array(
            'message' => $message,
        ));
        $url = " ../index.php?".$message_succcess;
        header("location: " . $url);

    }
    else
    {
        $error = http_build_query(array(
            'img_err' => $img_err,
            'name_err' => $err[0],
            'price_err' => $err[1],
            'tags_err' => $tags_err
        ));
        $url = " ../index.php?".$error;
        header("location: " . $url);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cat_submit'])) 
{
    $category_name = $_POST['add_category'];
    $exist_category = $_POST['exist_category'];

    $query = "SELECT category_name FROM category WHERE category_name = '$category_name'";
    $query = $conn->prepare($query);
    $query->execute();

    $res = $query->fetch(PDO::FETCH_ASSOC);

    $cat_name = $res['category_name'] ?? "";
    
    if(empty($cat_name))
    {
        if(empty($exist_category) && !empty($category_name))
        {
            add_category($category_name,$conn); // add category to category table
            header("Location: ../index.php");
        }
        elseif (!empty($category_name) && !empty($exist_category)) 
        {
            $res_get_id = get_id_category($exist_category,$conn);  // get id of category table by exist category
            $cat_id = $res_get_id['id'];
            
            add_subcategory($category_name , $cat_id,$conn);   //  add subcategory into category table
            header("Location: ../index.php");
        }
        elseif(empty($category_name))
        {
            // send error message to the index page
            $add_category_err = "you must enter a category";

            $err = http_build_query(array(
                'add_category_err' => $add_category_err
            ));
            $url = " ../index.php?".$err;
            header("Location:".$url);
        }

    }
    else{

        // send error message to the index page
        $add_category_err = "please enter a diferent category name";

        $err = http_build_query(array(
            'add_category_err' => $add_category_err
        ));
        $url = " ../index.php?".$err;
        header("Location:".$url);
    }

}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tag']))
{
    
    $tag_name = $_POST['tag'];

    $check_tag = "SELECT tag_name FROM tag WHERE tag_name = '$tag_name'";
    $check_tag = $conn->prepare($check_tag);
    $check_tag->execute();

    $res = $check_tag->fetch(PDO::FETCH_ASSOC);

    $tag = $res['tag_name'] ?? "";


    if(!empty($tag))
    {
        $err = "this tag name exists in tag list";
        $returnData = array(
            'status' => 0,
            'err' => $err
        );
        echo json_encode($returnData);
    }
    else
    {
        $add_tag = "INSERT INTO tag (tag_name) VALUES (:tag_name)";
        $add_tag = $conn->prepare($add_tag);
        $add_tag->bindParam(':tag_name', $tag_name);
        $add_tag->execute();
        
        
        ?>
        <?php ob_start() ?>
        <label class="form-label" for="tag">Tag</label>
        <select class="form-control" name="tags[]" id="tags" multiple>
        <?php 
            $tags = show_tag($conn);
            foreach($tags as $items)
            {  
            ?>
            <option value="<?php echo $items['id'] ?>"><?php echo $items['tag_name'] ?></option>
            <?php
            } 
            ?>
        </select>
        <span class="text-danger"><?php echo !empty($tags_err) ? $tags_err : "" ?></span>
        <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
        <script>
        new MultiSelectTag('tags') // id
        </script>
        <?php $htmlCode = ob_get_clean();
        
        $err = "";

        $returnData = array(
            'status' => 1,
            'err' => $err,
            'htmlCode' => $htmlCode
        );

        echo json_encode($returnData);
        
        ?>        
    
    <?php 
    }
}
?>