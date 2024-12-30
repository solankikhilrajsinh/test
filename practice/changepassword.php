<?php
$id = $_GET['id'];
$message = $error = "";
$updated_password = false;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practicedb";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM practice WHERE id='$id'";
$result = $conn->query($sql);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    $password_pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    }
    elseif (!preg_match($password_pattern, $new_password)) {
        $error = "*Password must be at least 8 characters, include an uppercase letter, a lowercase letter, a digit, and a special character.";
    }  
    
    else {
        $x = $new_password;
        $updated_password = "UPDATE practice SET password = '$x' WHERE id = '$id'";
        
        if ($conn->query($updated_password) === true) {
            $message = "Password updated successfully!";
            $updated_password = true;
        } else {
            $error = "Error updating password: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>


<body >
<?php include('header.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center"  >
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h2>Change Password</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($updated_password) { ?>
                            <div class="alert alert-success text-center">
                                <strong><?php echo $message; ?></strong>
                            </div>
                        <?php } elseif (!empty($error)) { ?>
                            <div class="alert alert-danger text-center">
                                <strong><?php echo $error; ?></strong>
                            </div>
                        <?php } ?>

                        <form action="changepassword.php?id=<?php echo $id; ?>" method="POST">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password:</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter your new password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm your new password" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary w-100">Update Password</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
