<?php

session_start();
if(!empty($_SESSION['user_id'])){
    header("Location:dashboard.php");
}
$post_data = $_POST;
$email_error='';
$password_error='';
if($post_data)
{
    if(empty($post_data['email']) || empty($post_data['password']))
    {
        if (empty($post_data['email'])){
            $email_error ='*Email is required';
        }
        if (empty($post_data['password'])){
            $password_error ='*Password is required';
        }
    }else{
        $servername="localhost";
        $username="root";
        $password="";
        $dbname="logindb";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM users WHERE email='".$post_data['email']."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row['password'] == $post_data['password']){

                $_SESSION['user_id'] = $row['id'];
                // $_SESSION['user_email'] = $row['email'];
                // $_SESSION['user_password']=$row['password'];

                header("Location:dashboard.php");

                exit;
                
            }else{
                $password_error = "Invalid Password.";
            }
        }else{
            $email_error = "Email ID is not exists.";
        } 
    }
?>
<?php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
        h2 {
            text-align: center;
            color: #1a1818;
        }
        .error_text{
            color:red;
        }

        form {
            background-color: #36486b;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 455px;
        }

        label {
            font-size: 14px;
            color: #ffffff;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .login-button {
            background-color: #28a745;
        }
        .register-link {
            text-align: center;
            margin-top: 10px;
        }
  
        
    </style>
    </div>
</head>
<body>
    <h2>Login Form</h2>
    <div style="display:flex;justify-content: center;">
        <form action="login.php" method="POST">

            <label for="email">Email:</label><br>
            <input class="form-control" type="email" id="email" name="email" placeholder="username"  value="<?php if(isset($post_data['email'])){ echo $post_data['email']; } ?>"><br>
            <p class="error_text"><?php echo $email_error; ?></p><br>

            <label for="password">Password:</label><br>
            <input class="form-control" type="password" id="password" name="password" placeholder="password" value="<?php if(isset($post_data['password'])){ echo $post_data['password']; } ?>"><br>
            <p class="error_text"><?php echo $password_error; ?></p><br>

            <button class="login-button" type="submit" name="login">Login</button><br>

            <div class="register-link">
                <p style="color:white">Don't have an account?  <a href="registration_form.php" style="color:white;">Register here</a></p>
            </div>
        </form>
    </div>
    
</body>
</html>


