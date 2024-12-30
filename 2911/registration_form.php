<?php
date_default_timezone_set('Asia/Kolkata');
$post_data = $_POST;
$message='';
$name_error='';
$gender_error='';
$qualification_error='';
$specialization_error='';
$phone_error='';
$email_error='';
$password_error='';
$dob_error='';
$hobbies_error='';
$state_error='';
$rate_error='';
$feedback_error='';


// if($post_data['full_name'] == ''){
//   echo '<script>alert("Name field is required");location.href="registration_form.html";</script>';
//   exit()
// }
// if($post_data['phone_number'] == ''){
//   echo '<script>alert("Phone Number field is required");location.href="registration_form.html";</script>';
//   exit();
// }
// if($post_data['email'] == ''){
//   echo '<script>alert("Email field is required");location.href="registration_form.html";</script>';
//   exit();
// }
// if($post_data['gender'] == ''){
//   echo '<script>alert("Gender field is required");location.href="registration_form.html";</script>';
//   exit();
// }
// if($post_data['password'] == ''){
//   echo '<script>alert("Password field is required");location.href="registration_form.html";</script>';
//   exit();
// }
// if($post_data['qualification'] == ''){
//   echo '<script>alert("Qualification field is required");location.href="registration_form.html";</script>';
//   exit();
// }
// if($post_data['specialization'] == ''){
//   echo '<script>alert("Specialization field is required");location.href="registration_form.html";</script>';
//   exit();
// }
// if($post_data['created_at'] == ''){
//   echo '<script>alert("Date field is required");location.href="registration_form.html";</script>';
//   exit();
// }
// if($post_data['feedback'] == ''){
//   echo '<script>alert("Feedback field is required");location.href="registration_form.html";</script>';
//   exit();
// }
// if($post_data['hobbies'] == ''){
//   echo '<script>alert("Hobbies field is required");location.href="registration_form.html";</script>';
//   exit();
// }
// if($post_data['state'] == ''){
//   echo '<script>alert("State field is required");location.href="registration_form.html";</script>';
//   exit();
// }
// if($post_data['rate'] == ''){
//   echo '<script>alert("Rate Us field is required");location.href="registration_form.html";</script>';
//   exit();
// }

if($post_data){
    
if (empty($post_data['full_name']) || empty($post_data['phone_number']) || empty($post_data['email']) || empty($post_data['gender']) || empty($post_data['password']) || empty($post_data['qualification']) || empty($post_data['specialization']) || empty($post_data['dob']) || empty($post_data['feedback']) || empty($post_data['hobbies']) || empty($post_data['state']) || empty($post_data['rate'])){
  //$message ="All fields must be filled out!";

    // $message = '<ul>';
    if (empty($post_data['full_name'])){
        $name_error ='*Name is required';
    }
    if(empty($post_data['gender']))
    {
        $gender_error.='*Gender is required';
    }
    if(empty($post_data['qualification']))
    {
        $qualification_error.='*Qualification is required';
    }
    if(empty($post_data['specialization']))
    {
        $specialization_error.='*Specialization is required';
    }
    if (empty($post_data['phone_number'])){
        $phone_error .='*Phone is required';
    }
    if (empty($post_data['email'])){
        $email_error .='*Email is required';
    }
    if (empty($post_data['password'])){
        $password_error .='*Password is required';
    }
    if (empty($post_data['dob'])){
        $dob_error .='*DOB is required';
    }
    if (empty($post_data['hobbies'])){
        $hobbies_error .='*Hobbies is required';
    }
    if (empty($post_data['state'])){
        $state_error .='*State is required';
    }
    if (empty($post_data['rate'])){
        $rate_error .='*Rate Us is required';
    }
    if (empty($post_data['feedback'])){
        $feedback_error .='*Feedback is required';
    }
   
    // $message .= '<ul>';

    // $required_fields = [
    //     'full_name' => 'Name is required',
    //     'gender' => 'Gender is required',
    //     'qualification' => 'Qualification is required',
    //     'specialization' => 'Specialization is required',
    //     'phone_number' => 'Phone is required',
    //     'email' => 'Email is required',
    //     'password' => 'Password is required',
    //     'created_at' => 'Date is required',
    //     'hobbies' => 'Hobbies are required',
    //     'state' => 'State is required',
    //     'rate' => 'Rate Us is required',
    //     'feedback' => 'Feedback is required',
    // ];
    
    // $message = '<ul>';
    // foreach ($required_fields as $field => $error_message) {
    //     if (empty($post_data[$field])) {
    //         $message .= "<li>$error_message</li>";
    //     }
    // }
    // $message .= '</ul>';
    
}else{
  $servername="localhost";
  $username="root";
  $password="";
  $dbname="logindb";
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

    $email_check_sql = "SELECT * FROM users WHERE email = '".$post_data['email']."'";
    $email_check_result = $conn->query($email_check_sql);
    
    if ($email_check_result->num_rows > 0) {
       $email_error = '*Email is already taken';
    }else{
      
        //echo "db connected successfully";
        // $states = implode(',',$post_data['state']);
        $hobbies = implode(',',$post_data['hobbies']);

        $sql = "INSERT INTO users (name, phone, email, gender, password,qualification,specialization, dob,feedback,hobbies,state,rate,created_at)
        VALUES ('".$post_data['full_name']."', '".$post_data['phone_number']."','".$post_data['email']."','".$post_data['gender']."','".$post_data['password']."','".$post_data['qualification']."','".$post_data['specialization']."','".date("Y-m-d H:i:s",strtotime($post_data['dob']))."','".$post_data['feedback']."', '".$hobbies."','".$post_data['state']."','".$post_data['rate']."','".date("Y-m-d")."')";

        
        
        // print_r($post_data);exit;
        //echo $post_data['full_name'];

        if ($conn->query($sql) === TRUE) {
            $message = "New record created successfully";
            header("Location:login.php");
            $post_data = '';
            
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<?php
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Registration Form </title>
    <div>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            /* display: flex;
            justify-content: center; */
            align-items: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #1a1818;
        }

        form {
            background-color: #36486b;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 455px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        .error_text{
            color:red;
        }

        input[type="radio"] {
            margin-right: 5px;
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

        button:hover {
            opacity: 0.9;
            background-color: #218838
        } 

        button[type="register"] {
            background-color: #28a745;
        }

        button[type="reset"] {
            background-color: #dc3545;
        }    

        button[type="reset"]:hover {
            background-color: #c82333;
        }

        textarea {
            resize: none; 
        }
        
    </style>
    </div>
</head>
<body>
    <h2>Registration Form </h2>

    <div style="display:flex;justify-content: center;">
        
        <form action="registration_form.php" method="POST">
            <div style="margin-bottom: 30px;color: red;"><?php  echo $message; ?></div>
            <label for="name">Full Name:</label><br>
            <input class="form-control" type="text" id="full_name" name="full_name" placeholder="Please enter your Name here" value="<?php if(isset($post_data['full_name'])){ echo $post_data['full_name']; } ?>">
            <p class="error_text"><?php echo $name_error; ?></p><br>

            <label for="gender">Gender:</label><br>
            <input type="radio" id="male" name="gender" value="Male" <?php if(!empty($post_data['gender']) && $post_data['gender']=="Male"){ echo 'checked';} ?>>
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="Female" <?php if(!empty($post_data['gender']) && $post_data['gender']=="Female"){ echo 'checked';} ?> >
            <label for="female">Female</label>
            <input type="radio" id="other" name="gender" value="Other" <?php if(!empty($post_data['gender']) && $post_data['gender']=="Other"){ echo 'checked';} ?> >
            <label for="other">Other</label>
            <p class="error_text"><?php echo $gender_error; ?></p><br>
    
            <label for="name">Qualification:</label><br>
            <input type="radio" id="B.Tech" name="qualification" value="B.Tech" <?php if(!empty($post_data['qualification']) && $post_data['qualification']=="B.Tech"){ echo 'checked';} ?>>
            <label for="B.Tech">B.Tech</label>
            <input type="radio" id="BCA" name="qualification" value="BCA" <?php if(!empty($post_data['qualification']) && $post_data['qualification']=="BCA"){ echo 'checked';} ?>>
            <label for="BCA">BCA</label>
            <input type="radio" id="M.Tech" name="qualification" value="M.Tech" <?php if(!empty($post_data['qualification']) && $post_data['qualification']=="M.Tech"){ echo 'checked';} ?>>
            <label for="M.Tech">M.Tech</label>
            <input type="radio" id="MCA" name="qualification" value="MCA" <?php if(!empty($post_data['qualification']) && $post_data['qualification']=="MCA"){ echo 'checked';} ?>>
            <label for="MCA">MCA</label>
            <input type="radio" id="other" name="qualification" value="other"<?php if(!empty($post_data['qualification']) && $post_data['qualification']=="Other"){ echo 'checked';} ?>>
            <label for="other">Other</label>
            <p class="error_text"><?php echo $qualification_error; ?></p><br>
    
            <label for="name">Specialization:</label><br>
            <input type="radio" id="CSE" name="specialization" value="CSE" <?php if(!empty($post_data['specialization']) && $post_data['specialization']=="CSE"){ echo 'checked';} ?>>
            <label for="CSE">CSE</label>
            <input type="radio" id="AI/ML" name="specialization" value="AI/ML" <?php if(!empty($post_data['specialization']) && $post_data['specialization']=="AI/ML"){ echo 'checked';} ?>>
            <label for="AI/ML">AI/ML</label>
            <input type="radio" id="CyberSecurity" name="specialization" value="CyberSecurity"<?php if(!empty($post_data['specialization']) && $post_data['specialization']=="CyberSecurity"){ echo 'checked';} ?>>
            <label for="CyberSecurity">CyberSecurity</label>
            <input type="radio" id="Cloud Computing" name="specialization" value="Cloud Computing" <?php if(!empty($post_data['specialization']) && $post_data['specialization']=="Cloud Computing"){ echo 'checked';} ?>>
            <label for="Cloud Computing">Cloud Computing</label>
            <input type="radio" id="other" name="specialization" value="other"<?php if(!empty($post_data['specialization']) && $post_data['specialization']=="other"){ echo 'checked';} ?>>
            <label for="other">Other</label>
            <p class="error_text"><?php echo $specialization_error; ?></p><br>
    
            <label for="phone">Phone Number:</label><br>
            <input class="form-control" type="tel" id="phone_number" name="phone_number" placeholder="Please enter your Phone number here" value="<?php if(isset($post_data['phone_number'])){ echo $post_data['phone_number']; } ?>">
            <p class="error_text"><?php echo $phone_error; ?></p><br>
    
            <label for="email">Email:</label><br>
            <input class="form-control" type="email" id="email" name="email" placeholder="Please enter your Email here" value="<?php if(isset($post_data['email'])){ echo $post_data['email']; } ?>">
            <p class="error_text"><?php echo $email_error; ?></p><br>
    
            <label for="password">Password:</label><br>
            <input class="form-control" type="password" id="password" name="password" placeholder="Please enter your Password here" value="<?php if(isset($post_data['password'])){ echo $post_data['password']; } ?>">
            <p class="error_text"><?php echo $password_error; ?></p><br>
    
            <label for="date">DOB:</label><br>
            <input class="form-control" type="date" id="dob" name="dob" >
            <p class="error_text"><?php echo $dob_error; ?></p><br>

            <label for="hobbies">Hobbies:</label><br>
            <input type="checkbox" id="technology" name="hobbies[]" value="Technology" <?php if(!empty($post_data['hobbies']) && in_array('Technology',$post_data['hobbies'])){ echo 'checked';} ?>>
            <label for="Technology">Technology</label>
            <input type="checkbox" id="sports" name="hobbies[]" value="Sports" <?php if(!empty($post_data['hobbies']) && in_array('Sports',$post_data['hobbies'])){ echo 'checked';} ?>>
            <label for="Sports">Sports</label>
            <input type="checkbox" id="music" name="hobbies[]" value="Music" <?php if(!empty($post_data['hobbies']) && in_array('Music',$post_data['hobbies'])){ echo 'checked';} ?>>
            <label for="Music">Music</label>
            <input type="checkbox" id="travel" name="hobbies[]" value="Travel" <?php if(!empty($post_data['hobbies']) && in_array('Travel',$post_data['hobbies'])){ echo 'checked';} ?>>
            <label for="Travel">Travel</label>
            <input type="checkbox" id="art" name="hobbies[]" value="Art" <?php if(!empty($post_data['hobbies']) && in_array('Art',$post_data['hobbies'])){ echo 'checked';} ?> >
            <label for="Art">Art</label>
            <p class="error_text"><?php echo $hobbies_error; ?></p><br>

            <!-- <label for="state">State:</label><br>
            <input type="checkbox" id="gujarat" name="state[]" value="Gujarat"required>
            <label for="Gujarat">Gujarat</label>
            <input type="checkbox" id="karnataka" name="state[]" value="Karnataka">
            <label for="Karnataka">Karnataka</label>
            <input type="checkbox" id="tamilnadu" name="state[]" value="Tamilnadu">
            <label for="Tamilnadu">Tamilnadu</label>
            <input type="checkbox" id="delhi" name="state[]" value="Delhi">
            <label for="Delhi">Travel</Delhi>
            <input type="checkbox" id="maharashtra" name="state[]" value="Maharashtra">
            <label for="Maharashtra">Maharashtra</label><br><br> -->

            <label for="state">State:</label><br>
            <select class="form-control" id="state" name="state" >
                <option value="" disabled selected>Select your state</option>
                <option value="Gujarat" <?php if(!empty($post_data['state']) && $post_data['state']=="Gujarat"){ echo 'selected="selected"';} ?>>Gujarat</option>
                <option value="Karnataka" <?php if(!empty($post_data['state']) && $post_data['state']=="Karnataka"){ echo 'selected="selected"';} ?>>Karnataka</option>
                <option value="Tamilnadu" <?php if(!empty($post_data['state']) && $post_data['state']=="Tamilnadu"){ echo 'selected="selected"';} ?>>Tamilnadu</option>
                <option value="Delhi" <?php if(!empty($post_data['state']) && $post_data['state']=="Delhi"){ echo 'selected="selected"';} ?>>Delhi</option>
                <option value="Maharashtra" <?php if(!empty($post_data['state']) && $post_data['state']=="Maharashtra"){ echo 'selected="selected"';} ?>>Maharashtra</option>
                <option value="MadhyaPradesh" <?php if(!empty($post_data['state']) && $post_data['state']=="MadhyaPradesh"){ echo 'selected="selected"';} ?>>MadhyaPradesh</option>
                <option value="Chandigarh" <?php if(!empty($post_data['state']) && $post_data['state']=="Chandigarh"){ echo 'selected="selected"';} ?>>Chandigarh</option>
                <option value="HimachalPradesh" <?php if(!empty($post_data['state']) && $post_data['state']=="HimachalPradesh"){ echo 'selected="selected"';} ?>>HimachalPradesh</option>
                <option value="Rajasthan" <?php if(!empty($post_data['state']) && $post_data['state']=="Rajasthan"){ echo 'selected="selected"';} ?>>Rajasthan</option>
                <option value="Bihar" <?php if(!empty($post_data['state']) && $post_data['state']=="Bihar"){ echo 'selected="selected"';} ?>>Bihar</option>
            </select>
            <p class="error_text"><?php echo $state_error; ?></p><br> 
            

            <label for="rate">Rate Us:</label><br>
            <select class="form-control" id="rate" name="rate" >
                <option value="" disabled selected>Select your rating</option>
                <option value="0" <?php if(!empty($post_data['rate']) && $post_data['rate']==0){ echo 'selected="selected"';} ?> >0</option>
                <option value="1" <?php if(!empty($post_data['rate']) && $post_data['rate']==1){ echo 'selected="selected"';} ?> >1</option>
                <option value="2" <?php if(!empty($post_data['rate']) && $post_data['rate']==2){ echo 'selected="selected"';} ?>>2</option>
                <option value="3" <?php if(!empty($post_data['rate']) && $post_data['rate']==3){ echo 'selected="selected"';} ?> >3</option>
                <option value="4" <?php if(!empty($post_data['rate']) && $post_data['rate']==4){ echo 'selected="selected"';} ?> >4</option>
                <option value="5" <?php if(!empty($post_data['rate']) && $post_data['rate']==5){ echo 'selected="selected"';} ?> >5</option>
                <option value="6" <?php if(!empty($post_data['rate']) && $post_data['rate']==6){ echo 'selected="selected"';} ?> >6</option>
                <option value="7" <?php if(!empty($post_data['rate']) && $post_data['rate']==7){ echo 'selected="selected"';} ?> >7</option>
                <option value="8" <?php if(!empty($post_data['rate']) && $post_data['rate']==8){ echo 'selected="selected"';} ?> >8</option>
                <option value="9" <?php if(!empty($post_data['rate']) && $post_data['rate']==9){ echo 'selected="selected"';} ?> >9</option>
                <option value="10" <?php if(!empty($post_data['rate']) && $post_data['rate']==10){ echo 'selected="selected"';} ?>>10</option>
            </select>
            <p class="error_text"><?php echo $rate_error; ?></p><br>
            
            <label for ="feedback">Feedback:</label><br>
            <textarea rows="4" class="form-control" id="feedback" name="feedback"  placeholder="Please give your Feedback here" ></textarea>
            <p class="error_text"><?php echo $feedback_error; ?></p><br>

           

            
            <button type="register" name="register">Register</button>
    
            <button type="reset">Reset</button>
    
        </form>
    </div>
    
</body>
</html>
