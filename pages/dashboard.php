<?php
include_once("../config/config.php");
include_once('../includes/auth.php');
ensureLoggedIn(['farmer', 'admin', 'buyer', 'government', 'marketing']);
include_once('../includes/header.php');
?>

<h2>Dashboard</h2>

<p>This is your dashboard where you can find all the relevant information and manage your account.</p>
<form id="crop-form" role="form" class="needs-validation" novalidate enctype="multipart/form-data">
    <input type="hidden" name="action" value="add-crop">
    <div class="form-group mb-3">
        <label for="cropname">Crop Name:</label>
        <input type="text" id="cropname" name="cropname" class="form-control" required>
        <div class="invalid-feedback">
            Please enter the crop name.
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control" required></textarea>
        <div class="invalid-feedback">
            Please enter a description.
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" class="form-control" required>
        <div class="invalid-feedback">
            Please enter a price.
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="crop_image">Crop Image:</label>
        <input type="file" id="crop_image" name="crop_image" class="form-control" required>
        <div class="invalid-feedback">
            Please upload an image of the crop.
        </div>
    </div>
    <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
</form>

<div class="row">
    <div class="col-md-4 card red" id="usdCard" data-currency="USD/KES">
        <div class="value" id="usdValue">0</div>
        <div class="progress-bar">
            <div class="fill" id="usdProgress"></div>
        </div>
    </div>
    <div class="col-md-4 card blue" id="gbpCard" data-currency="GBP/KES">
        <div class="value" id="gbpValue">0</div>
        <div class="progress-bar">
            <div class="fill" id="gbpProgress"></div>
        </div>
    </div>
    <div class="col-md-4 card cyan" id="eurCard" data-currency="EUR/KES">
        <div class="value" id="eurValue">0</div>
        <div class="progress-bar">
            <div class="fill" id="eurProgress"></div>
        </div>
    </div>
    <div class="col-md-4 card green" id="cadCard" data-currency="CAD/KES">
        <div class="value" id="cadValue">0</div>
        <div class="progress-bar">
            <div class="fill" id="cadProgress"></div>
        </div>
    </div>
</div>

<h1>Product Prices Over Time</h1>
<canvas id="myChart" width="30" height="10"></canvas>
<button id="downloadBtn">Download Chart</button>

<!-- Logout Form -->
<form action="/amis-project-/pages/routes.php" method="post" class="mt-4">
    <input type="hidden" name="action" value="logout">
    <button type="submit" class="btn btn-danger">Logout</button>
</form><br />
<div class="container mt-5">
    <h2>Crop Details</h2>
    <form id="crop-info" role="form" class="needs-validation" novalidate enctype="multipart/form-data">
        <input type="hidden" name="action" value="get-crop">
        <div class="form-group">
            <label for="cropname">Crop Name:</label>
            <input type="text" id="cropname" name="cropname" value="potatoes" class="form-control" required>
        </div>
        <button type="button" class="btn btn-primary" onclick="getCropDetails()">Get Crop Details</button>
    </form>

    <div id="crop-details" class="mt-4" style="display: none;">
        <h3 id="cropname-display"></h3>
        <p id="description-display"></p>
        <p><strong>Price:</strong> $<span id="price-display"></span></p>
        <img id="image-display" src="" alt="Crop Image" class="img-fluid">
    </div>
</div>
<script src="../assets/js/jquery.min.js"></script>
<script src="../lib/graphs/chart.min.js"></script>
<script src="../lib/graphs/utils.js" type="module"></script>
<script src="../lib/graphs/chartjs-plugin-annotation@1.0.2.js"></script>
<script src="../lib/graphs/v2/chart.js" type="module"></script>

<script>
    function getCropDetails() {
        var myForm = document.getElementById('crop-info');

        $(myForm).removeClass('was-validated');

        var formData = new FormData(myForm);
        console.log(myForm);
        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData, 
            processData: false,
            contentType: false,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    console.log(data);
                    var crop = data.crop;
                    $('#cropname-display').text(crop.cropname);
                    $('#description-display').text(crop.description);
                    $('#price-display').text(crop.price);
                    $('#image-display').attr('src', crop.image_path);
                    $('#crop-details').show();
                } else {
                    alert(data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching crop details:', error);
            }
        });
    }

    function submitForm() {
        var myForm = document.getElementById('crop-form');

        if (myForm.checkValidity() === false) {
            myForm.stopPropagation();
            $(myForm).addClass('was-validated');
            return;
        }

        $(myForm).removeClass('was-validated');

        var formData = new FormData(myForm);

        $.ajax({
            url: 'http://localhost/amis-project-/pages/routes.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var responseData = JSON.parse(response);
                if (responseData.success) {
                    alert('Crop added successfully!');
                    // Optionally, reload the page or update the UI
                } else {
                    alert('Error: ' + responseData.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
    }
</script>
<?php include('../includes/footer.php'); ?>