<?php 
include("C:/wamp64/www/ShopProject/bootstrap/init/includes.php");

if(isset($_POST['product_id']))
{
  

  $product_id = $_POST['product_id'];
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price']; 
  $product_quantity = 1;
  $total_price = $product_price * $product_quantity;

  $stmt = $conn->prepare("SELECT product_id FROM cart WHERE product_id=$product_id");
  $stmt->execute();

  $res = $stmt->fetch(PDO::FETCH_ASSOC);

  $id = $res['product_id'] ?? "" ;
  

  if(!$id)
  {
    $query = $conn->prepare("INSERT INTO cart (product_id, product_name, product_price, product_quantity, total_price) VALUES (:product_id, :product_name, :product_price, :product_quantity, :total_price)");
    $query->bindParam(':product_id', $product_id);
    $query->bindParam(':product_name', $product_name);
    $query->bindParam(':product_price', $product_price);
    $query->bindParam(':product_quantity', $product_quantity);
    $query->bindParam(':total_price', $total_price);

    $query->execute();

    echo '<div class="alert alert-success alert-dismissible mt-2">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Item added to your cart!</strong>
          </div>';

  }
  else
  {
    echo '<div class="alert alert-danger alert-dismissible mt-2">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Item already added to your cart!</strong>
          </div>';
  }

}

if(isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') 
{
  
  $stmt = $conn->query("SELECT * FROM cart");  
  $rows = $stmt->rowCount();
  
  echo $rows;
}

if(isset($_GET['remove']))
{ 
  

  $id = $_GET['remove'];

  $stmt = "DELETE FROM cart WHERE id='$id'";
  $stmt = $conn->prepare($stmt);
  $stmt->execute();
  header("location: ../cart.php");
  
}

if(isset($_GET['clear']))
{
  

  $stmt = "DELETE FROM cart ";
  $stmt = $conn->prepare($stmt);
  $stmt->execute();

  header("location: ../cart.php");
}

if(isset($_POST['quantity']))
{

  $product_quantity = $_POST['quantity'];
  $id = $_POST['id'];
  $product_price = $_POST['price'];

  $total_price = $product_quantity * $product_price;

  $stmt = "UPDATE cart SET product_quantity=:product_quantity, total_price=:total_price WHERE id=$id";
  $stmt = $conn->prepare($stmt);
  $stmt->bindParam(':product_quantity',$product_quantity);
  $stmt->bindParam(':total_price',$total_price);


  $stmt->execute();

}
?>