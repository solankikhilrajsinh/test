
<?php
    session_start();
    if(empty($_SESSION['user_id'])){
        header("Location:login.php");
    }
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="logindb";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);exit;
    }

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $all_users_count = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Page</title>
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
            h1,h3 {
                text-align: center;
                color: #1a1818;
            }
        
        </style>
</head>
<body>
    <h1>Dashboard Page</h1>
    <a href="logout.php" style="background-color: #FF0000; color: white; padding: 10px; border-radius: 4px; text-decoration: none; position: absolute; top: 20px; right: 20px;">Logout</a>
    <a href="users_list.php" style="background-color: #84ACFA; color: white; padding: 10px; border-radius: 4px; text-decoration: none;position: absolute;top: 20px;right: 100px;">List</a>    
        
        <h3>Total No. Of Users: <?php echo $all_users_count; ?> </h3>
</body>
</html>  
