<?php 
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "dbShop";

try
{
    $conn = new PDO("mysql:host=$servername;dbname=$db_name" , $username , $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection established";

}
catch(Exception $e)
{
    echo "Error: " . $e->getMessage();
}
?>