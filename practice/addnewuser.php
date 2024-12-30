<?php
$post_data = $_POST;
date_default_timezone_set('Asia/Kolkata');
$message = '';
$name_error = '';
$gender_error = '';
$email_error = '';
$password_error = '';
$phone_error = '';
$dob_error = '';
$profile_error = '';
$country_error='';
$document_error='';
$interests_error='';



function validate_mobile($phone) {
    $pattern = "/^[6-9][0-9]{9}$/";
    return preg_match($pattern, $phone);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validate_password($password) {
    $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    return preg_match($pattern, $password);
}

if ($post_data) {
    // echo '<pre>';print_r($post_data);exit; to check particular block of code
    $error = false;

    if (empty($post_data['name']) || empty($post_data['phone']) || empty($post_data['gender']) || empty($post_data['email']) || empty($post_data['password']) || empty($post_data['dob']) ) {
        if (empty($post_data['name'])) { $name_error = "*Name is required"; }
        if (empty($post_data['phone'])) { $phone_error = "*Phone is required"; }
        if (empty($post_data['email'])) { $email_error = "*Email is required"; }
        if (empty($post_data['gender'])) { $gender_error = "*Gender is required"; }
        if (empty($post_data['dob'])) { $dob_error = "*DOB is required"; }
        if (empty($post_data['password'])) { $password_error = "*Password is required"; }
        $error = true;
    }
   
    if (!empty($post_data['phone']) && !validate_mobile($post_data['phone'])) {
        $phone_error = "Invalid mobile number";
        $error = true;
    }

    if (!empty($post_data['email']) && !validate_email($post_data['email'])) {
        $email_error = "Invalid email address";
        $error = true;
    }

    if (!empty($post_data['password']) && !validate_password($post_data['password'])) {
        $password_error = "*Password must be at least 8 characters, include an uppercase letter, a lowercase letter, a digit, and a special character.";
        $error = true;
    }

    $profile_image = '';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['profile_image']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            $profile_image = $file_name;
        } else {
            $profile_error = "Failed to upload the profile image.";
            $error = true;
        }
    }

    $document = '';
    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['document']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
            $document = $file_name;
        } else {
            $document_error = "Failed to upload the document.";
            $error = true;
        }
    }

  

    if (!$error) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "practicedb";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $phone_check_sql = "SELECT * FROM practice WHERE phone = '" . $post_data['phone'] . "'";
        $phone_check_result = $conn->query($phone_check_sql);
        if ($phone_check_result->num_rows > 0) {
            $phone_error = '*Phone number already exists';
            $error = true;
        }

        $email_check_sql = "SELECT * FROM practice WHERE email = '" . $post_data['email'] . "'";
        $email_check_result = $conn->query($email_check_sql);
        if ($email_check_result->num_rows > 0) {
            $email_error = '*Email already exists';
            $error = true;
        }
        
        if (!$error) {
            $interests = implode(',',$post_data['interests']);
            $sql = "INSERT INTO practice (name, phone, email, gender, password, dob, created_at, profile_image, country, document, interests)
                    VALUES ('" . $post_data['name'] . "', '" . $post_data['phone'] . "', '" . $post_data['email'] . "', '" . $post_data['gender'] . "', '" . $post_data['password'] . "', '" . date("Y-m-d", strtotime($post_data['dob'])) . "', '" . date("Y-m-d H:i:s") . "', '" . $profile_image . "','" . $post_data['country'] . "','" . $document . "','".$interests."')";

            if ($conn->query($sql) === TRUE) {
                $message = "Added Successfully";
                header("Location: list.php");
                exit();
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<?php include('header.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Add New User</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-success mb-3"><?php echo $message; ?></div>
                        <form action="addnewuser.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" value="<?php if (isset($post_data['name'])) { echo $post_data['name']; } ?>">
                                <small class="text-danger"><?php echo $name_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number:</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value="<?php if (isset($post_data['phone'])) { echo $post_data['phone']; } ?>">
                                <small class="text-danger"><?php echo $phone_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php if (isset($post_data['email'])) { echo $post_data['email']; } ?>">
                                <small class="text-danger"><?php echo $email_error; ?></small>
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
                                <label for="dob" class="form-label">Date of Birth:</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="<?php if (isset($post_data['dob'])) { echo $post_data['dob']; } ?>">
                                <small class="text-danger"><?php echo $dob_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="country" class="form-label">Country:</label>
                                <select class="form-control" id="country" name="country">
                                    <option value="" disabled selected>Select your country</option>
                                    <option value="India" <?php if (isset($post_data['country']) && $post_data['country'] == "India") { echo 'selected'; } ?>>India</option>
                                    <option value="Japan" <?php if (isset($post_data['country']) && $post_data['country'] == "Japan") { echo 'selected'; } ?>>Japan</option>
                                    <option value="USA" <?php if (isset($post_data['country']) && $post_data['country'] == "USA") { echo 'selected'; } ?>>USA</option>
                                    <option value="Australia" <?php if (isset($post_data['country']) && $post_data['country'] == "Australia") { echo 'selected'; } ?>>Australia</option>
                                    <option value="Dubai" <?php if (isset($post_data['country']) && $post_data['country'] == "Dubai") { echo 'selected'; } ?>>Dubai</option>
                                </select>
                                <small class="text-danger"><?php echo $country_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="interests">Interests:</label><br>
                                <input type="checkbox" id="technology" name="interests[]" value="Technology" <?php if(!empty($post_data['interests']) && in_array('Technology',$post_data['interests'])){ echo 'checked';} ?>>
                                <label for="Technology">Technology</label>

                                <input type="checkbox" id="sports" name="interests[]" value="Sports" <?php if(!empty($post_data['interests']) && in_array('Sports',$post_data['interests'])){ echo 'checked';} ?>>
                                <label for="Sports">Sports</label>

                                <input type="checkbox" id="music" name="interests[]" value="Music" <?php if(!empty($post_data['interests']) && in_array('Music',$post_data['interests'])){ echo 'checked';} ?>>
                                <label for="Music">Music</label>

                                <input type="checkbox" id="travel" name="interests[]" value="Travel" <?php if(!empty($post_data['interests']) && in_array('Travel',$post_data['interests'])){ echo 'checked';} ?>>
                                <label for="Travel">Travel</label>

                                <input type="checkbox" id="art" name="interests[]" value="Art" <?php if(!empty($post_data['interests']) && in_array('Art',$post_data['interests'])){ echo 'checked';} ?>>
                                <label for="Art">Art</label>

                                <small class="text-danger"><?php echo $interests_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" value="<?php if (isset($post_data['password'])) { echo $post_data['password']; } ?>">
                                <small class="text-danger"><?php echo $password_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="document" class="form-label">Document:</label><br>
                                <input class="form-control" type="file" id='document' name="document">
                                <small class="text-danger"><?php echo $document_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="profile_image" class="form-label">Profile Image:</label><br>
                                <input class="form-control" type="file" id="profile_image" name="profile_image">
                                <small class="text-danger"><?php echo $profile_error; ?></small>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
