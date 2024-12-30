<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logindb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ( isset($_GET['delete'])) {
    $userId = $_GET['delete']; 
    $delete_sql = "DELETE FROM users WHERE id = $userId";
    if ($conn->query($delete_sql) === TRUE) {
        //echo "User deleted successfully!";
        header("Location: users_list.php");exit; 
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Profile</title>
    <div>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #36486b;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 455px;
            text-align:center;
        }

        label {
            font-size: 14px;
            color: #ffffff;
        }
       
    </style>
    </div>
</head>
<body>
    
    <div style="display:flex;justify-content: center;">
        <form action="delete.php" method="POST">
            <p style="color:white">Are you sure want to delete?  <a href="delete.php?delete=<?php echo $_GET['id'] ?>" style="color:white;">Delete Account</a></p>
        </form>
    </div>
    
</body>
</html>

