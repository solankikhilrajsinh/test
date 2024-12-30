<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practicedb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM practice";
$result = $conn->query($sql);
$all_users_count = $result->num_rows;

$sql = "SELECT * FROM practice WHERE id='".$_SESSION['user_id']."'";
$result = $conn->query($sql);

$user = array();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Dashboard Page</title>

    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #6c757d, #343a40);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }
        @keyframes blink-colors {
            0% { color: blue; }
            25% { color: white; }
            50% { color: green; }
            75% { color: yellow; }
            100% { color: red; }
        }

        
        .blinking-text {
            animation: blink-colors 4s linear infinite; 
            font-weight: bold;
        }
    </style>

</head>
<body>

    <?php include('header.php');?>
    <div class="container mt-4">
        <div class="welcome-banner">
            <h1 class="blinking-text">Welcome, <?php echo $user['name']; ?>!</h1>
            <p> Explore your travel stats, plan new trips, and more!</p>
            <p class="lead">Total Users: <strong><?php echo $all_users_count; ?></strong></p>
        </div>
    </div>

    
    <!-- <div class="container main-content mt-3">
        <h1 class="display-4 text-primary">Welcome to the Dashboard</h1>
        <p class="lead">Total Users: <strong><?php //echo $all_users_count; ?></strong></p>
    </div> -->
</body>
</html>
