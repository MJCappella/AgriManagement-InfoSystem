<?php 
include_once("../config/config.php");
include('../includes/header.php'); 
include_once('../includes/auth.php');
ensureLoggedIn();
?>

<h2>Dashboard</h2>

<p>This is your dashboard where you can find all the relevant information and manage your account.</p>

<div class="row">   
    <div class="col-md-4 card red" id="usdCard" data-currency="USD/KES">
        <div class="value" id="usdValue">0</div>
        <div class="progress-bar"><div class="fill" id="usdProgress"></div></div>
    </div>
    <div class="col-md-4 card blue" id="gbpCard" data-currency="GBP/KES">
        <div class="value" id="gbpValue">0</div>
        <div class="progress-bar"><div class="fill" id="gbpProgress"></div></div>
    </div>
    <div class="col-md-4 card green" id="cadCard" data-currency="CAD/KES">
        <div class="value" id="cadValue">0</div>
        <div class="progress-bar"><div class="fill" id="cadProgress"></div></div>
    </div>
</div>

<h1>Product Prices Over Time</h1>
<canvas id="myChart" width="30" height="10"></canvas>
<button id="downloadBtn">Download Chart</button>

<!-- Logout Form -->
<form action="/amis-project-/pages/routes.php" method="post" class="mt-4">
    <input type="hidden" name="action" value="logout">
    <button type="submit" class="btn btn-danger">Logout</button>
</form><br/>
<script src="../lib/graphs/chart.min.js"></script>
<script src="../lib/graphs/v2/chart.js"></script>
<?php include('../includes/footer.php'); ?>
