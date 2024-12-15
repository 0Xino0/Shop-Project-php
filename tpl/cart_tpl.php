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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css
    " rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/0e706293c0.js" crossorigin="anonymous"></script>
    <title>Cart Page</title>
</head>

<body>
    <div class="container">
        <div class="row mt-3">
            <table class="table table-dark table-striped ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th class="ps-1" scope="col">Quantity</th>
                        <th scope="col">Total Price</th>
                        <th style="width: 280px;" scope="col">
                            <a href="action-cart.php?clear" class="badge rounded-pill text-bg-warning ps-3 pe-3"
                                onclick="return confirm('Are you sure want to clear your cart?');"><i
                                    class="fa-solid fa-trash fa-xs2 " style="color: #ffffff;">&nbsp; Clear all</i></a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $result = show_cart($conn);
                    $grand_total = 0;
                    foreach($result as $row)
                    {

                    ?>
                    <tr>
                        <th class="pt-1 " scope="row"><?php echo $row['id'] ?></th>
                        <input type="hidden" class="id" value="<?php echo $row['id'] ?>">
                        <td class="ps-2 pt-1 "><?php echo $row['product_name'] ?></td>
                        <td class="ps-2 pt-1 "><?php echo number_format($row['product_price'],0) ?></td>
                        <input type="hidden" class="product_price" value="<?php echo $row['product_price'] ?>">
                        <td class="ps-1 pt-1 ">
                            <input class="form-control quantity" type="number" id="quantity" name="quantity"
                                style="width: 60px; height: 30px;" value="<?php echo $row['product_quantity'] ?>">
                        </td>
                        <td><?php echo number_format($row['total_price'],0) ?></td>
                        <td>
                            <a href="tpl/action-cart.php?remove=<?= $row['id'] ?>" class="text-danger lead btn btn-danger"
                                onclick="return confirm('Are you sure want to remove this item?');"><i
                                    class="fa-solid fa-trash" style="color: #ffffff;">&nbsp;Remove</i></a>
                        </td>
                    </tr>
                    <?php
                    ?>

                    <?php $grand_total += $row['total_price'] ?>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
            <table class="table table-success table-striped ">
                <tbody>
                    <tr>
                        <td class="ps-5" style="width: 250px;"><a href="view.php" class="btn btn-info"><i
                                    class="fa-solid fa-shop" style="color: #ffffff;">&nbsp; Back To Shop</i></a></td>
                        <td class=" pe-0 text-end text-dark "><b>Grand Total :</b></td>
                        <td class="text-dark"><b id="grand_total">$<?php echo number_format($grand_total,0) ?></b></td>
                        <td style="width: 350px;"><button class="btn btn-success payment"><i
                                    class="fa-regular fa-credit-card"> Payment</i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
    $(document).ready(function() {
        $(".payment").click(function(e) {
            e.preventDefault();
            let grand_total = $("#grand_total").html();
            Swal.fire(
                'The Purchase Was Successfully',
                'Price = '+grand_total,
                'success'
            )

        });
        $(".quantity").on("change", function(e) {
            e.preventDefault();
            let el = $(this).closest('tr');


            let id = el.find(".id").val();
            let price = el.find(".product_price").val();
            let quantity = el.find(".quantity").val();
            location.reload(true);
            $.ajax({
                url: "tpl/action-cart.php",
                method: "POST",
                cache: false,
                data: {
                    id: id,
                    price: price,
                    quantity: quantity
                },
                success: function(response) {
                    console.log(response);
                }
            })
        })

    });
    </script>

</body>

</html>