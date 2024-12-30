<?php
include('db.php');
include 'helper.php';
$db = new Db();
$conn = $db->conn;
session_start();

if (!empty($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$post_data = $_POST;
$email_error = '';
$message = '';

if (!empty($post_data['email']) && !validate_email($post_data['email'])) {
    $email_error = "Invalid email address";
    $error = true;
}   


if ($post_data) {
    $error = false;

    if (empty($post_data['email'])) {
        $email_error = '*Email is required';
        $error = true;
    }


    if (!empty($post_data['email']) && !validate_email($post_data['email'])) {
        $email_error = "Invalid email address";
        $error = true;
    }
    
    

    if (!$error) {
    
        // $servername = "localhost";
        // $username = "root";
        // $password = "";
        // $dbname = "practice_one";   
        
        // $conn = new mysqli($servername, $username, $password, $dbname);
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }

        $message = $db->forgotpassword($post_data['email']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
        }

        .form-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <div class="glass-effect">
            <h2 class="text-center mb-4">Forgot Password</h2>
            <p class="text-success"><?php echo $message; ?></p> 
            <form action="forgotpassword.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter your registered email"
                        value="<?php if (isset($post_data['email'])) { echo htmlspecialchars($post_data['email']); } ?>">
                    <p class="text-danger"><?php echo $email_error; ?></p>
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100">Reset</button>
                <div class="text-center mt-3">
                    <p>Remembered your password? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </div>

    
</body>
</html>
