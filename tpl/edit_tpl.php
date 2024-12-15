<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <link rel="stylesheet" href="assest/css/style_edit.css">
    <title>Edit Page</title>
</head>

<body>
    <div class="container">
        <div class="row mt-3">
            <form action="tpl/action-view.php" method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="card text-dark bg-light mb-3">
                    <div class="card-header  ">
                        <h2 class="text-center text-light bg-warning d-flex justify-content-center p-3 rounded">
                            Edit Product</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-outline mb-3">
                            <label class="form-label" for="edit_name">Name</label>
                            <input class="form-control <?php echo (!empty($edit_name_err)) ? "is-invalid" : "" ?>"
                                type="text" name="edit_name" id="edit_name" value="<?php echo $edit_name ?>">
                            <span><?php echo $edit_name_err ?></span>

                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label" for="edit_price">Price</label>
                            <input class="form-control <?php echo (!empty($edit_price_err)) ? "is-invalid" : "" ?> "
                                type="text" name="edit_price" id="edit_price" value="<?php echo $edit_price ?>">
                            <span><?php echo $edit_price_err ?></span>
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label" for="category">Category</label>
                            <select class="form-control" name="edit_category" id="edit_category">
                                <option value="<?php echo $category_id ?>">
                                    <?php echo $edit_category ?></option>
                                <?php 
                                    $result = sidebar_category($conn);

                                    foreach($result as $row){
                                        $cat_id = $row['id'];
                                        $res_subcat = sidebar_subcategory($cat_id,$conn);
                                ?>
                                <optgroup label="<?php echo $row['category_name'] ?>">
                                    <?php 
                                        foreach($res_subcat as $sub_cat){
                                        ?>


                                    <option value="<?php echo $sub_cat['id']?>">
                                        <?php echo $sub_cat['category_name']?></option>
                                    <?php
                                        }
                                        ?>
                                </optgroup>
                                <?php 
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label" for="edit_price">Tag</label>
                            <div id="edit_tag_box" class="my-2 border rounded bg-white p-2">
                            <?php 
                                    $edit_tag = explode(",", $edit_tag);
                                    // var_dump($edit_tag);
                                    // exit;
                                    
                                    foreach($edit_tag as $tag)
                                    {
                                        
                                    ?>
                                    <span><?php echo "#".$tag ?></span>
                                    <?php
                                    }
                                    ?>
                            </div>
                            <select name="edit_tags[]" id="edit_tags" multiple>
                                <?php 
                                $show_tags = show_tag($conn);
                                // var_dump($show_tags);
                                // exit;

                                foreach($show_tags as $items)
                                {
                                ?>
                                <option value="<?php echo $items['id'] ?>"><?php echo $items['tag_name'] ?></option>
                                <?php 
                                } 
                                ?>
                            </select>
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label" for="edit_caption">Caption</label>
                            <textarea class="form-control" name="edit_caption" id="edit_caption" cols="30"
                                rows="5"><?php echo $edit_caption ?></textarea>
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label" for="edit_image">Image</label>
                            <img class="form-control" style="width: 100px; height:100px;"
                                src="assest/Images/<?php echo $edit_image ?>" alt="">
                            <input class="form-control mt-2" type="file" name="edit_image" id="edit_image">
                            <span><?php echo $edit_img_err ?></span>
                        </div>
                        <br>
                        <div>
                            <button class="btn btn-success" name="update" id="update">Update</button>
                            <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id ?>">
                            <input type="hidden" name="tag_id" id="tag_id" value="<?php echo $tag_id ?>">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
    new MultiSelectTag('edit_tags') // id
    </script>
</body>

</html>