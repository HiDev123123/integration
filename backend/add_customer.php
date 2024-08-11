<?php
$name = $_POST['c_name'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];

include('conn.php');

$sql = "INSERT INTO `customer` (`name`, `phone`, `address`) VALUES ('$name', '$mobile', '$address')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header('Location: ../bill.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
 
?>