<?php
session_start();
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    unset($_SESSION['user_id']); 
    header("Location: login.php"); 
    exit();
}

header("Location: logoutconfirm.php");
exit();
?>



