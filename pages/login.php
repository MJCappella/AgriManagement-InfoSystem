<?php include('../includes/header.php'); ?>
<h2>Login</h2>
<form action="/pages/dashboard.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Login</button>
</form>
<?php include('../includes/footer.php'); ?>

