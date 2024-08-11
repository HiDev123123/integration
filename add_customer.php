<?php
include('nav.php');
?>
<main>
    <div class="container mt-5">
        <form id="customer_form" action="backend/add_customer.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="c_name" name="c_name">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" id="mobile" name="mobile">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="preview()"> Peview
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    function preview() {
        var name = document.getElementById('c_name').value;
        var mobile = parseInt(document.getElementById('mobile').value);
        var address = document.getElementById('address').value;

        var preview = document.getElementById('preview');
        preview.innerHTML = "<p>Name: " + name + "</p><p>Price: " + mobile + "</p> <p>"+address+"</p>";
    }

    function form1() {
            document.getElementById('customer_form').submit();
    }
</script>


<!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="preview">
                 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                <button type="submit" class="btn btn-primary" onclick="form1()">Submit</button>
            </div>
        </div>
    </div>
</div>