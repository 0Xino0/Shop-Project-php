<?php 
include("C:/wamp64/www/ShopProject/bootstrap/init/includes.php");

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete']))
{

    $product_id = $_POST['delete'];

    delete($product_id,$conn);
    header("location: ../view.php");
    
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update']))
{

    $product_id = $_POST['product_id'];
    $tag_id = $_POST['tag_id'];
    $tags_id = explode(",",$tag_id);
    
    
    $stmt = $conn->prepare("SELECT img FROM shop WHERE id=$product_id ");
    $stmt->execute();
    $result = $stmt->fetch();

    $edit_name      = $_POST['edit_name'];
    $edit_price     = $_POST['edit_price'];
    $edit_caption   = $_POST['edit_caption'];
    $edit_image     = $_FILES['edit_image'];
    $edit_category  = $_POST['edit_category'];
    
    if(empty($_POST['edit_tags']))
    {
        $edit_tags = null;
    }
    else
    {
        $edit_tags = $_POST['edit_tags'];
    }
    

    if(empty($edit_image['name']))
    {
        $edit_new_img_name = $result['img'];
    }
    else
    {
        $res_edit_img = validate_image($edit_image);
        $edit_new_img_name = $res_edit_img[0];
        $edit_img_err = $res_edit_img[1];
    }

    $edit_result = validate($edit_name,$edit_price); 
    $edit_var = $edit_result[0]; 
    $edit_err = $edit_result[1];  

    if( empty($edit_img_err) && empty($edit_err[0]) && empty($edit_err[1]))
    {
        edit($product_id, $edit_var[0] , $edit_var[1] , $edit_caption ,$edit_tags,$tags_id,$edit_category, $edit_new_img_name,$conn );
        header("location: ../view.php");
    }
    else
    {
        $error = http_build_query(array(
            'id' => $product_id,
            'edit_img_err' => $edit_img_err,
            'edit_name_err' => $edit_err[0],
            'edit_price_err' => $edit_err[1]
        ));
        $url = " ../edit.php?".$error;
        header("location: " . $url);
    }    

}

if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['download']))
{
    require("fpdf/fpdf.php");

    class PDF extends FPDF 
    {
       
        function basicTable($header,$data)
        {
            $this->SetFillColor(255,0,0);
            $this->SetDrawColor(128,0,0);

            for($i=0;$i<count($header);$i++)
            {
                $this->Cell(40,10,$header[$i],1,0,'B',true);    
            }
            $this->Ln();
            
            foreach($data as $row)
            {
                $this->Cell(40,12,$row["id"],1);
                $this->Cell(40,12,$row["user_name"],1);
                $this->Cell(40,12,$row["price"],1);
                $this->Cell(40,12,$row["caption"],1);
                $this->Ln();
        
            }
        }

    }

    $pdf = new PDF();
    $header = array('#','name','price','caption');

    $result = show($conn);

    $pdf->SetFont('Arial','',9);
    $pdf->AddPage();
    $pdf->basicTable($header,$result);
    
    $pdf->Output();

}

if (isset($_POST['input']))
{
    $input = $_POST['input'];
    
    $sql = " SELECT s.user_name AS name,s.price,s.caption,s.img,GROUP_CONCAT(distinct t.tag_name) as tags_name,c.category_name,
            s.id as product_id,GROUP_CONCAT(distinct t.id) as tag_id,c.id as category_id
            FROM shop s
            JOIN pivot_tag_shop pts ON pts.product_id = s.id
            JOIN tag t ON pts.tag_id = t.id
            JOIN pivot_shop_category psc ON s.id = psc.product_id
            JOIN category c ON c.id = psc.category_id
            WHERE s.user_name LIKE '%{$input}%'
            GROUP BY s.user_name";

    $sql = $conn->prepare($sql);

    $sql->execute();
    $show = $sql->fetchAll();
    

    if(!empty($show)){
             ?>
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
                    <i class="fa-solid fa-file-pdf fa-lg my-3"><input class="btn btn-primary" type="submit" name="download"
                            id="download" value="download"></i>
                </form>
                <?php
                            foreach ($show as $row) {
                                $tags_name = explode(",", $row['tags_name']);
                            ?>
                <tr>
                    <td>
                        <img id="img1" class="img-fluid" src="assest/Images/<?php echo $row['img'] ?>" alt="Product Image">
                    </td>
                    <td class="ps-2 pt-4 "> <?php echo $row['name'] ?> </td>
                    <td class="ps-2 pt-4"> <?php echo $row['price'] ?>$ </td>
                    <td class="ps-4 pt-4">
                        <?php 
                            echo $row['category_name']; 
                        ?>
                    </td>
                    <td class="ps-2 pt-4"> <?php echo $row['caption'] ?> </td>
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
                            <input type="hidden" name="tag_id" value="<?php echo $row['tag_id'] ?>">
                            <button class="btn btn-danger" name="delete" id="delete" value="<?php echo $row['product_id']?>">
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
                                <i class="fa fa-cart-plus fa-xl" style="color: #ffffff;" aria-hidden="true"></i>
                            </button>
                        </form>
                                    
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        <?php
            }
            else
            { 
            ?>
                <h3 class='text-danger text-center mt-3'>No Data Found</h3>
            <?php 
            }  
}
?>