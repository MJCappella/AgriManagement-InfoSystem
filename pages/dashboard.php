<?php include('../includes/header.php'); ?>
<h2>Dashboard</h2>
<p>Welcome, <?php echo htmlspecialchars($_POST['username']); ?>!</p>
<p>This is your dashboard where you can find all the relevant information and manage your account.</p>

<h1>Product Prices Over Time</h1>
    <canvas id="myChart" width="400" height="300"></canvas>
    <button id="downloadBtn">Download Chart</button>
    <script src="../lib/graphs/chartjs/chart.min.js"></script>
    <script src="../lib/graphs/chartjs/v2/chart.js"></script>
<?php include('../includes/footer.php'); ?>

