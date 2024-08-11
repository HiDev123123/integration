<?php
include('conn.php');

$name = $_POST['name']; 
$price = $_POST['price'];
$id = $_POST['id'];


$sql = "UPDATE products SET name = '$name', price = '$price' WHERE id = '$id'";
$result = mysqli_query($conn, $sql);    

if ($result) {
    header('location: ../product.php');
}


?>