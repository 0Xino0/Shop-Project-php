<?php 

function show_cart($conn)
{
    $show = " SELECT * FROM `cart` ";
    $show = $conn->prepare($show);

    $show->execute();
    $result = $show->fetchAll();
    
    return $result;
}

?>