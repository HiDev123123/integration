<?php
session_start();
include('nav.php');
include('backend/conn.php');

// Initialize phone number variable and modal flag
$phone = '';
$showModal = false;

if (isset($_POST['mobile'])) {
    // Sanitize and validate the phone number
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    
    // Prepare SQL query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM customer WHERE phone = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Phone number exists, store it in session and redirect
        $_SESSION['phone'] = $mobile;
        header("Location: bill.php"); // Redirect to receive.php
        exit();
    } else {
        // Phone number does not exist, show modal for adding a new customer
        $phone = $mobile;
        $showModal = true;
    }
}
?>

<div class="container m-5">
    <form method="POST">
        <div class="mb-3">
            <label for="mobile" class="form-label">Customer Mobile Number</label>
            <input type="number" class="form-control" id="mobile" name="mobile" value="<?php echo htmlspecialchars($phone); ?>" required>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>   

    <?php if ($showModal) : ?>
        <!-- Modal for adding a new customer -->
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="customer_form" action="backend/add_customer.php" method="POST">
                            <div class="mb-3">
                                <label for="c_name" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="c_name" name="c_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="mobile_modal" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile_modal" name="mobile" value="<?php echo htmlspecialchars($phone); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary" onclick="preview()">Preview</button>
                            </div>
                        </form>
                        <div id="preview" class="mt-3"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Function to preview the entered customer details
            function preview() {
                var name = document.getElementById('c_name').value;
                var mobile = document.getElementById('mobile_modal').value;
                var address = document.getElementById('address').value;

                var preview = document.getElementById('preview');
                preview.innerHTML = `
                    <p><strong>Name:</strong> ${name}</p>
                    <p><strong>Mobile Number:</strong> ${mobile}</p>
                    <p><strong>Address:</strong> ${address}</p>
                `;
            }

            // Function to submit the form
            function submitForm() {
                document.getElementById('customer_form').submit();
            }

            // Automatically show the modal if phone does not exist
            document.addEventListener('DOMContentLoaded', function() {
                <?php if ($showModal) : ?>
                    var addCustomerModal = new bootstrap.Modal(document.getElementById('addCustomerModal'));
                    addCustomerModal.show();
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
