<?php
include('db.php');
include 'helper.php';
$db = new Db();
$conn = $db->conn;
session_start();

if (!empty($_SESSION['user_id'])) {
    header("Location: dashboard.php");
}
$post_data = $_POST;
$email_error = '';
$password_error = '';
$name_error='';
$gender_error='';
$phone_error='';
$dob_error='';
$message='';


if ($post_data) {
    $error = false;
    if (empty($post_data['email']) || empty($post_data['password'])) {
        if (empty($post_data['email'])) {
            $email_error = '*Email is required';
        }
        if (empty($post_data['password'])) {
            $password_error = '*Password is required';
        }
        $error = true;
    }
    
    if (!empty($post_data['email']) && !validate_email($post_data['email'])) {
        $email_error = "Invalid email address";
        $error = true;
    }
    
    if(!$error){
        // $servername = "localhost";
        // $username = "root";
        // $password = "";
        // $dbname = "practicedb";
        // $conn = new mysqli($servername, $username, $password, $dbname);
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }

        if (!empty($post_data['email']) && !validate_email($post_data['email'])) {
            $email_error = "Invalid email address";
            $error = true;
        }  
        
        $sql = "SELECT * FROM practice WHERE email='" . $post_data['email'] . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['password'] == $post_data['password']) {
                $_SESSION['user_id'] = $row['id'];
                header("Location: dashboard.php");
                exit;
            } else {
                $password_error = "Invalid Password.";
            }
        } else {
            $email_error = "Email ID does not exist.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            max-width: 600px;
        }
    </style>
</head>

<body>
   
    <div class="container form-container">
        <div class="glass-effect">
            <h2 class="text-center mb-4">Registration Form</h2>
            <div class="text-danger mb-3"><?php echo $message; ?></div>
            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" value="<?php if (isset($post_data['name'])) { echo $post_data['name']; } ?>">
                    <small class="text-danger"><?php echo $name_error; ?></small>
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender:</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="male" name="gender" value="Male" <?php if (!empty($post_data['gender']) && $post_data['gender'] == "Male") { echo 'checked'; } ?>>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="female" name="gender" value="Female" <?php if (!empty($post_data['gender']) && $post_data['gender'] == "Female") { echo 'checked'; } ?>>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="other" name="gender" value="Other" <?php if (!empty($post_data['gender']) && $post_data['gender'] == "Other") { echo 'checked'; } ?>>
                        <label class="form-check-label" for="other">Other</label>
                    </div><br>
                    <small class="text-danger"><?php echo $gender_error; ?></small>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value="<?php if (isset($post_data['phone'])) { echo $post_data['phone']; } ?>">
                    <small class="text-danger"><?php echo $phone_error; ?></small>
                </div>
                
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth:</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="<?php if (isset($post_data['dob'])) { echo $post_data['dob']; } ?>">
                    <small class="text-danger"><?php echo $dob_error; ?></small>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php if (isset($post_data['email'])) { echo $post_data['email']; } ?>">
                    <small class="text-danger"><?php echo $email_error; ?></small>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                    <small class="text-danger"><?php echo $password_error; ?></small>
                </div>

                <button type="submit" class="btn btn-primary w-100">Register</button>

                <div class="text-center mt-3">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
