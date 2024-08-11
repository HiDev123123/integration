<?php
include 'backend/conn.php';

if (isset($_POST['item'])) {
    $itemName = $conn->real_escape_string($_POST['item']);
    
    $sql = "SELECT price FROM products WHERE name = '$itemName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['price'];
    } else {
        echo "0";
    }
}
 