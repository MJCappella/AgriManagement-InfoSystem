<?php
include_once("../../config/config.php");
$pageTitle = 'Farmers Dashboard';
$logoutButton = true;
include_once('../../includes/auth.php');
include_once('../../includes/header.php');
ensureLoggedIn(['farmer']);
?>


<?php include('../../includes/footer.php') ?>
</body>
</html>