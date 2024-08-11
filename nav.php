<?php
include('backend/conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Index Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>



<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">PN Services</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="add_product.php">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="product.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="add_customer.php">Add Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="customer.php">Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="bill.php">Bill</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="display_sales.php">Display Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="search.php">Display Sales</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>