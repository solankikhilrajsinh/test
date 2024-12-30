<?php
include('db.php');

$db = new Db();
$conn = $db->conn;
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "practice_one";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

if (isset($_GET['delete'])) {
    $userId = $_GET['delete']; 
    $delete_sql = "DELETE FROM users WHERE id = $userId";
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: list.php");
        exit; 
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .btn-delete:hover {
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
                <h3>Delete Account</h3>
            </div>
            <div class="card-body text-center">
                <p class="lead">Are you sure you want to delete your account?</p>
                <a href="delete.php?delete=<?php echo $_GET['id']; ?>" class="btn btn-secondary btn-delete btn-lg">Delete </a>
                <a href="list_pagination.php" class="btn btn-secondary btn-lg ms-3">Cancel</a>
            </div>
        </div>
    </div>

</body>
</html>

