<?php

include('conn.php');
$id = $_POST['id'];


$sql = "DELETE FROM products WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    header('location: ../product.php');
}

?>