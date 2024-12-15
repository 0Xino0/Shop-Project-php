<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
    <script src="https://kit.fontawesome.com/0e706293c0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <title>Add Product</title>
</head>

<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-9">
                <form action="tpl/action-index.php" id="form_product" method="post" autocomplete="off"
                    enctype="multipart/form-data">
                    <div class="card text-dark bg-light mb-3">
                        <div class="card-header  ">
                            <h2 class="text-center text-light bg-primary d-flex justify-content-center p-3 rounded">
                                Add Product</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-outline mb-3">
                                <label class="form-label" for="user_name">Name</label>
                                <input class="form-control <?php echo (!empty($name_err)) ? "is-invalid" : "" ?>"
                                    type="text" name="user_name" id="user_name">
                                <span class="text-danger" id="name_err"><?php echo $name_err ?></span>
                            </div>
                            <div class="form-outline mb-3">
                                <label class="form-label" for="price">Price</label>
                                <input class="form-control <?php echo (!empty($price_err)) ? "is-invalid" : "" ?> "
                                    type="text" name="price" id="price">
                                <span class="text-danger" id="price_err"><?php echo $price_err ?></span>
                            </div>
                            <div class="form-outline mb-3">
                                <label class="form-label" for="category">Category</label>
                                <select class="form-control" name="category" id="category">
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
                                        <option value="<?php echo $sub_cat['category_name']?>">
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
                                <label class="form-label" for="caption">Caption</label>
                                <textarea class="form-control" name="caption" id="caption" cols="30"
                                    rows="5"></textarea>
                            </div>
                            <div id="tag-box" class="form-outline mb-3">
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
                            </div>
                            <div class="form-outline mb-3">
                                <label class="form-label" for="image">Image</label>
                                <input class="form-control <?php echo (!empty($img_err)) ? "is-invalid" : "" ?>"
                                    type="file" name="image" id="image">
                                <span class="text-danger" id="img_err"><?php echo $img_err ?></span>
                            </div>
                            <br>
                            <div>
                                <input class="btn btn-primary submit" type="submit" name="add" id="add" value="Add">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="<?php echo !empty(($message)) ? "alert alert-success alert-dismissible mt-2" : "d-none" ?>">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>
                        <?php echo $message ?>
                    </strong>
                </div>
            </div>

            <div class="col">
                <div class="my-5">
                    <a class="text-decoration-none btn btn-warning" href="view.php">
                        <i class="fa-solid fa-shop">&nbsp;Go To Shop</i>
                    </a>
                </div>
                <form action="tpl/action-index" id="form_cat" method="post">
                    <div class="card mt-5 ">
                        <div class="card-header">
                            <h2 class="text-center">Add Category</h2>
                        </div>
                        <div class="card-body form-outline">
                            <label class="form-label" id="add_cat" for="add_category">Add Category</label>
                            <input class="form-control <?php echo (!empty($add_category_err)) ? "is-invalid" : "" ?>"
                                type="text" name="add_category" id="add_category" autocomplete="off">
                            <span class="text-danger" id="add_category_err"><?php echo $add_category_err ?></span>
                            <div>
                                <label class="form-label" id="label_exist" for="exist_category">Exist Category</label>
                                <select class="form-control" name="exist_category" id="exist_category">
                                    <option value="">---No Selected---</option>
                                    <?php
                                $exist_category = sidebar_category($conn);
                                foreach ($exist_category as $row) 
                                {
                                    ?>
                                    <option value="<?php echo $row['category_name'] ?>">
                                        <?php echo $row['category_name']?></option>
                                    <?php
                                }
                                ?>
                                </select>
                            </div>
                            <input class="btn btn-success mt-4 submit" type="submit" name="cat_submit" id="cat_submit">
                        </div>
                    </div>
                </form>
                <form action="" method="post" id="form_tag">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h2 class="text-center">Add Tag</h2>
                        </div>
                        <div class="card-body">
                            <label class="form-label" for="add_tag">Add Tag</label>
                            <input autocomplete="off" class="form-control" type="text" name="add_tag" id="add_tag">
                            <span class="text-danger" id="add_tag_err"></span>
                            <div>
                                <input class="btn btn-success mt-3" type="button" name="tag_submit" id="tag_submit" value="Submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script>
    new MultiSelectTag('tags') // id
    </script>
    <script>
    $(document).ready(function() {
        $('#form_product').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        $('#form_cat').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
                
            }
        });

        $('#tag_submit').on('click',function(e){
        let form_tag = $(this).closest('#form_tag');
        let tag =form_tag.find('#add_tag').val();

        if(tag == '')
        {
            form_tag.find('#add_tag_err').text('Please enter a tag name');
        }
        else
        {
            $.ajax({
                url : 'tpl/action-index.php',
                method : 'POST',
                dataType : 'json',
                data : { tag : tag },
                success : function(data){
                    if(data.status == 0)
                    {
                        form_tag.find('#add_tag_err').text(data.err);
                        $('#add_tag').val('');
                    }
                    else
                    {
                        $('#tag-box').html(data.htmlCode);
                        $('#add_tag').val('');
                        form_tag.find('#add_tag_err').text('');
                    }
        
                }
            })
        }
        });
    })
    </script>
</body>

</html>