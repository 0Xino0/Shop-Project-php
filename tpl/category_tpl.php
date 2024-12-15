<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <style>
    #img1 {
        width: 100px;
        height: 100px;
    }

    #card {
        width: 100px;
        height: 100px;
    }

    #img2 {
        width: 50px;
        height: 50px;
    }
    </style>
    <title>Category</title>
</head>

<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark ">
        <a class="navbar-brand" href="view.php"><i class="fa-solid fa-shop"
                style="color: #ffffff;"></i>&nbsp;&nbsp;Home</a>
        <div class="input-group">
            <div class="form-outline">
                <input type="text" class="form-control" id="search" autocomplete="off" placeholder="Search...">
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex flex-row-reverse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto p-2 pe-5">
                <li class="nav-item">
                    <span id="cart-item" class="badge rounded-pill bg-danger"></span>
                    <a class="nav-link pt-0" href="cart.php"><i class="fas fa-shopping-cart fa-xl"></i> </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col">
                <div id="message"></div>
                <div id="result_serach">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Category</th>
                                <th scope="col">Caption</th>
                                <th scope="col">Tag</th>
                                <th scope="col">Operation</th>
                                <th scope="col">Add</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="tpl/action-view.php" method="post">
                                <i class="fa-solid fa-file-pdf fa-lg my-3"><input class="btn btn-primary" type="submit"
                                        name="download" id="download" value="download"></i>
                            </form>
                            <?php
                    $result = get_category_or_subcategory_data($category_id,$subcategory_id , $conn);

                    foreach ($result as $row) {
                        $tags_name = explode(",", $row['tags_name']);
                    ?>
                            <tr>
                                <td>
                                    <img id="img1" class="img-fluid" src="assest/Images/<?php echo $row['img'] ?>"
                                        alt="Product Image">
                                </td>
                                <td class="ps-2 pt-4 "> <?php echo $row['name'] ?> </td>
                                <td class="ps-2 pt-4"> <?php echo $row['price'] ?>$     </td>
                                <td class="ps-4 pt-4">
                                    <?php
                                       echo $row['category_name'];
                                    ?>    
                                </td>
                                <td class="ps-2 pt-4"> <?php echo $row['caption'] ?>    </td>
                                <td class="pt-4"> 
                                    <?php
                                    foreach($tags_name as $tag_name)
                                    {
                                        echo "#".$tag_name;
                                    }
                                    ?>         
                                </td>
                                <td>
                                    <form action="tpl/action-view.php" method="post">
                                        <button class="btn btn-danger" name="delete" id="delete"
                                            value="<?php echo $row['product_id']?>">
                                            Delete
                                        </button>
                                    </form>
                                    <form class="mx-2" action="edit.php?" method="get">
                                        <input type="hidden" name="product_id" id="product_id" value="<?php echo $row['product_id'] ?>">
                                        <input type="hidden" name="category_id" id="category_id" value="<?php echo $row['category_id'] ?>">
                                        <input type="hidden" name="tag_id" id="tag_id" value="<?php echo $row['tag_id'] ?>">
                                        <input class="btn btn-warning mt-2" type="submit" name="edit" id="edit" value="Edit">
                                    </form>
                                </td>
                                <td class="ps-1 pt-4" style="width: 120px;">
                                    <form action="" class="form-submit">
                                        <input type="hidden" class="product_id" value="<?= $row['product_id'] ?>">
                                        <input type="hidden" class="product_name" value="<?= $row['name'] ?>">
                                        <input type="hidden" class="product_price" value="<?= $row['price'] ?>">
                                        <button class=" ps-2 btn addToCart">
                                            <i class="fa fa-cart-plus fa-xl" style="color: #ffffff;"
                                                aria-hidden="true"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            <?php
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $(".addToCart").click(function(e) {
            e.preventDefault();
            let form = $(this).closest(".form-submit");
            let product_name = form.find(".product_name").val();
            let product_price = form.find(".product_price").val();
            $.ajax({
                url: "tpl/action-cart.php",
                method: "POST",
                data: {
                    product_name: product_name,
                    product_price: product_price
                },
                success: function(response) {
                    $("#message").html(response);
                    load_cart_item_number();
                }

            })
        });

        load_cart_item_number();

        function load_cart_item_number() {
            $.ajax({
                url: 'tpl/action-cart.php',
                method: 'get',
                data: {
                    cartItem: "cart_item"
                },
                success: function(response) {
                    $("#cart-item").html(response);
                }
            });
        }
        $("#search").keyup(function(e) {
            e.preventDefault();
            let input = $(this).val();

            if (input != null) {
                $.ajax({
                    url: "tpl/action-view.php",
                    method: "POST",
                    data: {
                        input: input
                    },
                    success: function(response) {
                        $("#result_serach").html(response);
                        $("#result_serach").css('display', 'block');
                    }
                })
            } else {
                $("#result_serach").css('display', 'none');
            }
        });

    });
    </script>

</body>

</html>