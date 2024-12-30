<?php
include('db.php');
include 'helper.php';
$db = new Db();
$conn = $db->conn;
$id = $_GET['id'];

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "practice_one";
// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$user = $db->view($id);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php include('header.php'); ?>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h2>User Profile</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row" class="w-25">ID</th>
                            <td><?php echo $user['id']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Name</th>
                            <td><?php echo $user['name']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Phone</th>
                            <td><?php echo $user['phone']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td><?php echo $user['email']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Gender</th>
                            <td><?php echo $user['gender']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">DOB</th>
                            <td><?php echo date("d-m-Y", strtotime($user['dob'])); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Created Date</th>
                            <td><?php echo date("d-m-Y h:i:s A", strtotime($user['created_at'])); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Country</th>
                            <td><?php echo $user['country']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Interests</th>
                            <td><?php echo $user['interests']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">About</th>
                            <td><?php echo $user['about']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Password</th>
                            <td><?php echo $user['password']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Document</td>
                            <td>
                                <?php if($user['document'] !='' && file_exists('uploads/'.$user['document'])){ ?>
                                <a target="_blank" href="uploads/<?php echo $user['document']; ?>">View Document</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Profile Image</td>
                            <td><img src="uploads/<?php echo $user['profile_image']; ?>"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-warning text-white">Edit Profile</a>
                    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>
