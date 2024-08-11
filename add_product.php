<?php include('nav.php'); ?>
<main>
    <div class="container mt-5">
        <form id="form1" action="backend/add_product.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price">
            </div>
            <div class="mb-3">
                <label for="p_image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="p_image" name="p_image">
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="preview()">Preview</button>
            </div>
        </form>
    </div>
</main>

<script>
    function preview() {
        var name = document.getElementById('name').value;
        var price = parseFloat(document.getElementById('price').value);
        var file = document.getElementById('p_image').files[0];

        var preview = document.getElementById('preview');
        preview.innerHTML = "<p>Name: " + name + "</p><p>Price: " + price + "</p>";

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100px';
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    }

    function submitForm() {
        document.getElementById('form1').submit();
    }
</script>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Product Preview</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="preview"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
            </div>
        </div>
    </div>
</div>
