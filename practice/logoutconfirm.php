<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .btn-logout:hover {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }
    </style>

</head>
<body class="bg-light">
<?php include('header.php'); ?>

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow-lg" style="max-width: 500px; width: 100%;">
        <div class="card-header text-center bg-danger text-white">
            <h3>Logout Account</h3>
        </div>
        <div class="card-body text-center">
            <p class="lead">Are you sure you want to log out of your account?</p>
          
            <a href="logout.php?logout=true" class="btn btn-secondary btn-lg btn-logout">Yes</a>
            
            <a href="dashboard.php" class="btn btn-secondary btn-lg ms-3">No</a>
        </div>
    </div>
</div>

</body>
</html>
