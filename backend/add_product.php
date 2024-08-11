<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['name'];
    $productPrice = $_POST['price'];
    $targetDir = "../image/product_image/"; // Directory where the file will be saved
    $fileName = basename($_FILES["p_image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Validate file upload
    $uploadOk = 1;
    // Check if file is an image
    $check = getimagesize($_FILES["p_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["p_image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedTypes = array("jpg", "jpeg", "png", "gif");
    if (!in_array($fileType, $allowedTypes)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Attempt to upload the file
        if (move_uploaded_file($_FILES["p_image"]["tmp_name"], $targetFilePath)) {
            // Insert form data into the database
            $productName = mysqli_real_escape_string($conn, $productName);
            $productPrice = mysqli_real_escape_string($conn, $productPrice);
            $sql = "INSERT INTO products (name, price, image) VALUES ('$productName', '$productPrice', '$fileName')";
            
            if (mysqli_query($conn, $sql)) {
                echo "The product has been uploaded successfully.";
                header('Location: ../product.php'); // Redirect after successful upload
                exit();
            } else {
                echo "Error inserting product data: " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    mysqli_close($conn);
}
?>
