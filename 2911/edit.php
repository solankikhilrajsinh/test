<?php
$message='';
$name_error='';
$gender_error='';
$qualification_error='';
$specialization_error='';
$phone_error='';
$dob_error='';
$email_error='';
$hobbies_error='';
$state_error='';
$rate_error='';
$feedback_error='';
$profile_error='';

$servername = "localhost";
$user = "root";
$password = "";
$dbname = "logindb";

$conn = new mysqli($servername, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])){
    $userId = $_GET['id']; 
    $sql = "SELECT * FROM users WHERE id = $userId";
    $result = $conn->query($sql);
}


if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user['hobbies'] = explode(',',$user['hobbies']);
    //  print_r($user);exit;
} else {
    echo "User not found!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //echo '<pre>'; print_r($_POST);print_r($_FILES['profile_image']);exit;
    $name = $_POST['name'];
    $qualification = $_POST['qualification'];
    $specialization = $_POST['specialization'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dob=$_POST['dob'];
    $feedback = $_POST['feedback'];
    $state=$_POST['state'];
    $rate_us=$_POST['rate'];
    $hobbies = implode(',',$_POST['hobbies']);
    $profile_image='';
    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error']==0){
        move_uploaded_file($_FILES['profile_image']['tmp_name'], 'uploads/'.$_FILES['profile_image']['name']);
        $profile_image = ",profile_image='".$_FILES['profile_image']['name']."'";
    }
    "User ID: " . $userId; 


    $update_sql = "UPDATE users SET name = '$name', qualification = '$qualification', specialization = '$specialization', phone = '$phone', email = '$email', gender = '$gender',hobbies = '$hobbies', state = '$state',dob='$dob', rate = '$rate_us',feedback = '$feedback'".$profile_image." WHERE id = $userId ";

    if ($conn->query($update_sql) === TRUE) {
        echo "User updated successfully!";
        header("Location: users_list.php"); 
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>





<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile </title>
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

        button[type="update"] {
            background-color: #28a745;
        }

        /* button[type="reset"] {
            background-color: #dc3545;
        }    

        button[type="reset"]:hover {
            background-color: #c82333;
        } */

        textarea {
            resize: none; 
        }
        
    </style>
    </div>
</head>
<body>
    <h2>Edit Profile </h2>

    <div style="display:flex;justify-content: center;">
        
        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
            <div style="margin-bottom: 30px;color: red;"><?php  echo $message; ?></div>
            <label for="name">Full Name:</label><br>
            <input class="form-control" type="text" name="name" value="<?php echo $user['name']; ?>">
            <p class="error_text"><?php echo $name_error; ?></p><br>

            <label for="gender">Gender:</label><br>
            <input type="radio" id="male" name="gender" value="Male" <?php if($user['gender'] == 'Male'){echo 'checked';} ?>>
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="Female" <?php if($user['gender'] == 'Female'){echo 'checked';} ?> >
            <label for="female">Female</label>
            <input type="radio" id="other" name="gender" value="Other" <?php if($user['gender'] == 'Other'){echo 'checked';} ?> >
            <label for="other">Other</label>
            <p class="error_text"><?php echo $gender_error; ?></p><br>
    
            <label for="name">Qualification:</label><br>
            <input type="radio" id="B.Tech" name="qualification" value="B.Tech" <?php if($user['qualification'] == 'B.Tech'){echo 'checked';} ?>>
            <label for="B.Tech">B.Tech</label>
            <input type="radio" id="BCA" name="qualification" value="BCA" <?php if($user['qualification'] == 'BCA'){echo 'checked';} ?>>
            <label for="BCA">BCA</label>
            <input type="radio" id="M.Tech" name="qualification" value="M.Tech" <?php if($user['qualification'] == 'M.Tech'){echo 'checked';} ?>>
            <label for="M.Tech">M.Tech</label>
            <input type="radio" id="MCA" name="qualification" value="MCA" <?php if($user['qualification'] == 'MCA'){echo 'checked';} ?>>
            <label for="MCA">MCA</label>
            <input type="radio" id="other" name="qualification" value="other"<?php if($user['qualification'] == 'Other'){echo 'checked';} ?>>
            <label for="other">Other</label>
            <p class="error_text"><?php echo $qualification_error; ?></p><br>
    
            <label for="name">Specialization:</label><br>
            <input type="radio" id="CSE" name="specialization" value="CSE" <?php if($user['specialization'] == 'CSE'){echo 'checked';} ?>>
            <label for="CSE">CSE</label>
            <input type="radio" id="AI/ML" name="specialization" value="AI/ML" <?php if($user['specialization'] == 'AI/ML'){echo 'checked';} ?>>
            <label for="AI/ML">AI/ML</label>
            <input type="radio" id="CyberSecurity" name="specialization" value="CyberSecurity"<?php if($user['specialization'] == 'CyberSecurity'){echo 'checked';} ?>>
            <label for="CyberSecurity">CyberSecurity</label>
            <input type="radio" id="Cloud Computing" name="specialization" value="Cloud Computing" <?php if($user['specialization'] == 'Cloud Computing'){echo 'checked';}  ?>>
            <label for="Cloud Computing">Cloud Computing</label>
            <input type="radio" id="Other" name="specialization" value="Other"<?php if($user['specialization'] == 'Other'){echo 'checked';}  ?>>
            <label for="Other">Other</label>
            <p class="error_text"><?php echo $specialization_error; ?></p><br>
    
            <label for="phone">Phone Number:</label><br>
            <input class="form-control" type="tel" name="phone" value="<?php echo $user['phone']; ?>">
            <p class="error_text"><?php echo $phone_error; ?></p><br>
    
            <label for="email">Email:</label><br>
            <input class="form-control" type="email" name="email" value="<?php echo $user['email']; ?>">
            <p class="error_text"><?php echo $email_error; ?></p><br>
    
            <!-- <label for="date">DOB:</label><br>
            <input class="form-control" type="date" id="created_at" name="created_at" >
            <p class="error_text"><?php echo $created_at_error; ?></p><br> -->

            <label for="date">DOB:</label><br>
            <input class="form-control" type="date" id="dob" name="dob" value="<?php echo $user['dob']; ?>"; 
            <p class="error_text"><?php echo $dob_error; ?></p><br>

            <label for="hobbies">Hobbies:</label><br>
            <input type="checkbox" id="technology" name="hobbies[]" value="Technology" <?php if(!empty($user['hobbies']) && in_array('Technology',$user['hobbies'])){ echo 'checked';} ?>>
            <label for="Technology">Technology</label>
            <input type="checkbox" id="sports" name="hobbies[]" value="Sports" <?php if(!empty($user['hobbies']) && in_array('Sports',$user['hobbies'])){ echo 'checked';} ?>>
            <label for="Sports">Sports</label>
            <input type="checkbox" id="music" name="hobbies[]" value="Music" <?php if(!empty($user['hobbies']) && in_array('Music',$user['hobbies'])){ echo 'checked';} ?>>
            <label for="Music">Music</label>
            <input type="checkbox" id="travel" name="hobbies[]" value="Travel" <?php if(!empty($user['hobbies']) && in_array('Travel',$user['hobbies'])){ echo 'checked';} ?>>
            <label for="Travel">Travel</label>
            <input type="checkbox" id="art" name="hobbies[]" value="Art" <?php if(!empty($user['hobbies']) && in_array('Art',$user['hobbies'])){ echo 'checked';} ?> >
            <label for="Art">Art</label>
            <p class="error_text"><?php echo $hobbies_error; ?></p><br>

           

            <label for="state">State:</label><br>
            <select class="form-control" id="state" name="state" >
                <option value="" disabled selected>Select your state</option>
                <option value="Gujarat" <?php if ($user['state'] == 'Gujarat') echo 'selected'; ?>>Gujarat</option>
                <option value="Karnataka" <?php if ($user['state'] == 'Karnataka') echo 'selected'; ?>>Karnataka</option>
                <option value="Tamilnadu" <?php if ($user['state'] == 'Tamilnadu') echo 'selected'; ?>>Tamilnadu</option>
                <option value="Delhi" <?php if ($user['state'] == 'Delhi') echo 'selected'; ?>>Delhi</option>
                <option value="Maharashtra" <?php if ($user['state'] == 'Maharashtra') echo 'selected';?>>Maharashtra</option>
                <option value="MadhyaPradesh" <?php if ($user['state'] == 'MadhyaPradesh') echo 'selected'; ?>>MadhyaPradesh</option>
                <option value="Chandigarh" <?php if ($user['state'] == 'Chandigarh') echo 'selected'; ?>>Chandigarh</option>
                <option value="HimachalPradesh" <?php if ($user['state'] == 'HimachalPradesh') echo 'selected'; ?>>HimachalPradesh</option>
                <option value="Rajasthan" <?php if ($user['state'] == 'Rajasthan') echo 'selected'; ?>>Rajasthan</option>
                <option value="Bihar" <?php if ($user['state'] == 'Bihar') echo 'selected'; ?>>Bihar</option>
            </select>
            <p class="error_text"><?php echo $state_error; ?></p><br> 
            

            <label for="rate">Rate Us:</label><br>
            <select class="form-control" id="rate" name="rate" >
                <option value="" disabled selected>Select your rating</option>
                <option value="0" <?php if ($user['rate'] == '0') echo 'selected'; ?> >0</option>
                <option value="1" <?php if ($user['rate'] == '1') echo 'selected'; ?> >1</option>
                <option value="2" <?php if ($user['rate'] == '2') echo 'selected'; ?>>2</option>
                <option value="3" <?php if ($user['rate'] == '3') echo 'selected'; ?> >3</option>
                <option value="4" <?php if ($user['rate'] == '4') echo 'selected'; ?> >4</option>
                <option value="5" <?php if ($user['rate'] == '5') echo 'selected'; ?> >5</option>
                <option value="6" <?php if ($user['rate'] == '6') echo 'selected'; ?> >6</option>
                <option value="7" <?php if ($user['rate'] == '7') echo 'selected'; ?> >7</option>
                <option value="8" <?php if ($user['rate'] == '8') echo 'selected'; ?> >8</option>
                <option value="9" <?php if ($user['rate'] == '9') echo 'selected'; ?> >9</option>
                <option value="10"<?php if ($user['rate'] == '10') echo 'selected';?>>10</option>
            </select>
            <p class="error_text"><?php echo $rate_error; ?></p><br>
            
            <label for ="feedback">Feedback:</label><br>
            <textarea rows="4" class="form-control" id="feedback" name="feedback" ><?php echo($user['feedback']);?></textarea>
            <p class="error_text"><?php echo $feedback_error; ?></p>

            <label for="profile_image">Profile Image:</label><br>
            <input class="form-control" type="file" id='profile_image' name="profile_image">
            <p class="error_text"><?php echo $profile_error; ?></p><br>
            
            <button type="update" name="update">Update</button>
    
            <!-- <button type="reset">Reset</button> -->
    
        </form>
    </div>
    
</body>
</html>




