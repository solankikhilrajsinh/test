<?php

$id = $_GET['id'];

$post_data = $_POST;
$message = '';
$name_error = '';
$gender_error = '';
$email_error = '';
$phone_error = '';
$dob_error = '';
$country_error = '';
$profile_error = '';
$about_error = '';
$document_error = '';
$interests_error = '';

include('db.php');
include 'helper.php';

$db = new Db();
$conn = $db->conn;

$user = $db->edit_user($id);

if ($user) {

} else {
    echo "User not found.";
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = false;

    
    if (empty($post_data['name']) || empty($post_data['phone']) || empty($post_data['gender']) || empty($post_data['email']) || empty($post_data['dob']) || empty($post_data['country']) || empty($post_data['about'])) {
        if (empty($post_data['name'])) { $name_error = "*Name is required"; }
        if (empty($post_data['phone'])) { $phone_error = "*Phone is required"; }
        if (empty($post_data['email'])) { $email_error = "*Email is required"; }
        if (empty($post_data['gender'])) { $gender_error = "*Gender is required"; }
        if (empty($post_data['dob'])) { $dob_error = "*DOB is required"; }
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

    
    $profile_image = '';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $upload_dir = 'uploads/';
        $file_name = $id . '_' . basename($_FILES['profile_image']['name']);
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

    $interests = isset($post_data['interests']) ? implode(',', $post_data['interests']) : '';


    if (!$error) {
        $result = $db->edit($id, $post_data, $profile_image, $document, $interests);

        if ($result === true) {
            if (!empty($profile_image) && !empty($user['profile_image']) && file_exists('uploads/' . $user['profile_image'])) {
                unlink('uploads/' . $user['profile_image']);
            }
            $message = "Profile updated successfully.";
        } else {
            $message = $result; 
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile</title>
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
                        <h3>Edit Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-success mb-3"><?php echo $message; ?></div>
                        <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($post_data['name']) ? $post_data['name'] : $user['name']; ?>" placeholder="Enter your full name">
                                <small class="text-danger"><?php echo $name_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number:</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($post_data['phone']) ? $post_data['phone'] : $user['phone']; ?>" placeholder="Enter your phone number">
                                <small class="text-danger"><?php echo $phone_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo isset($post_data['email']) ? $post_data['email'] : $user['email']; ?>" placeholder="Enter your email">
                                <small class="text-danger"><?php echo $email_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender:</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="male" name="gender" value="Male" 
                                        <?php echo (isset($post_data['gender']) && $post_data['gender'] == "Male") ? 'checked' : ($user['gender'] == "Male" ? 'checked' : ''); ?> required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="female" name="gender" value="Female" 
                                        <?php echo (isset($post_data['gender']) && $post_data['gender'] == "Female") ? 'checked' : ($user['gender'] == "Female" ? 'checked' : ''); ?> required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="other" name="gender" value="Other" 
                                        <?php echo (isset($post_data['gender']) && $post_data['gender'] == "Other") ? 'checked' : ($user['gender'] == "Other" ? 'checked' : ''); ?> required>
                                    <label class="form-check-label" for="other">Other</label>
                                </div>
                                <small class="text-danger"><?php echo $gender_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth:</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo isset($post_data['dob']) ? $post_data['dob'] : $user['dob'];?>">
                                <small class="text-danger"><?php echo $dob_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="country" class="form-label">Country:</label>
                                <select class="form-control" id="country" name="country" required>
                                    <option value="" disabled <?php echo empty($user['country']) && !isset($post_data['country']) ? 'selected' : ''; ?>>Select your country</option>
                                    <option value="India" <?php echo (isset($post_data['country']) && $post_data['country'] == "India") || $user['country'] == "India" ? 'selected' : ''; ?>>India</option>
                                    <option value="Japan" <?php echo (isset($post_data['country']) && $post_data['country'] == "Japan") || $user['country'] == "Japan" ? 'selected' : ''; ?>>Japan</option>
                                    <option value="USA" <?php echo (isset($post_data['country']) && $post_data['country'] == "USA") || $user['country'] == "USA" ? 'selected' : ''; ?>>USA</option>
                                    <option value="Australia" <?php echo (isset($post_data['country']) && $post_data['country'] == "Australia") || $user['country'] == "Australia" ? 'selected' : ''; ?>>Australia</option>
                                    <option value="Dubai" <?php echo (isset($post_data['country']) && $post_data['country'] == "Dubai") || $user['country'] == "Dubai" ? 'selected' : ''; ?>>Dubai</option>
                                </select>
                                <small class="text-danger"><?php echo $country_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="interests" class="form-label">Interests:</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="interest_sports" name="interests[]" value="Sports" <?php echo in_array("Sports", $user['interests']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="interest_sports">Sports</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="interest_music" name="interests[]" value="Music" <?php echo in_array("Music", $user['interests']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="interest_music">Music</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="interest_travel" name="interests[]" value="Travel" <?php echo in_array("Travel", $user['interests']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="interest_travel">Travel</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="interest_technology" name="interests[]" value="Technology" <?php echo in_array("Technology", $user['interests']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="interest_technology">Technology</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="interest_art" name="interests[]" value="Art" <?php echo in_array("Art", $user['interests']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="interest_art">Art</label>
                                </div>
                                <small class="text-danger"><?php echo $interests_error ?? ''; ?></small>
                            </div>
                            <div class="mb-3">
                                    <label for="about" class="form-label">About:</label><br>
                                    <textarea rows="4" class="form-control" id="about" name="about" placeholder="Please tell me about yourself here" value="<?php if (isset($post_data['about'])){echo $post_data['about'];} ?>"></textarea>
                                    <small class="text-danger"><?php echo $about_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="document" class="form-label">Document:</label><br>
                                <input class="form-control" type="file" id='document' name="document" >
                                <small class="text-danger"><?php echo $document_error; ?></small>
                            </div>
                            <div class="mb-3">
                                <label for="profile_image" class="form-label">Profile Image:</label><br>
                                <input class="form-control" type="file" id="profile_image" name="profile_image">
                                <small class="text-danger"><?php echo $profile_error; ?></small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
