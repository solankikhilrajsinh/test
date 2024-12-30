<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practicedb";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM practice";
$result = $conn->query($sql);
$all_users = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_users[] = $row;
    }
}
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .table img {
            max-width: 70px; 
            height: auto;
        }
        
    </style>
    
</head>

<body>
<?php include('header.php'); ?>
    <!-- <div class="container my-3">
    <div class="container my-2">
    <div class="text-end mb-4">
        <a href="dashboard.php" class="btn btn-dark btn-sm">Go to Dashboard</a>
    </div>
    </div> -->

</div>
  
<div class="container my-3">
    <div class="container my-2">
    <div class="text-end mb-4">
        <a href="addnewuser.php" class="btn btn-dark btn-sm">Add new user</a>
    </div>
    

    
    <div class="container my-2">
        <h1 class="text-center mb-4">User List</h1>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Created Date</th>
                        <th>Country</th>
                        <th>Interests</th>
                        <th>About</th>
                        <th>Password</th>
                        <th>Document</th>
                        <th>Profile Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($all_users) > 0) {
                        foreach ($all_users as $user) { ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['phone']; ?></td>
                                <td><?php echo $user['gender']; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($user['dob'])); ?></td>
                                <td><?php echo date("d-m-Y h:i:s A", strtotime($user['created_at'])); ?></td>
                                <td><?php echo $user['country']; ?></td>
                                <td><?php echo $user['interests']; ?></td>
                                <td><?php echo $user['about']; ?></td>
                                <td><?php echo $user['password']; ?></td>
                                <td>
                                    <?php if($user['document'] !='' && file_exists('uploads/'.$user['document'])){ ?>
                                    <a target="_blank" href="uploads/<?php echo $user['document']; ?>">View Document</a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($user['profile_image'] !='' && file_exists('uploads/'.$user['profile_image'])){ ?>
                                        <img src="uploads/<?php echo $user['profile_image']; ?>">
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="status.php?id=<?php echo $user['id']; ?>&status=<?php echo $user['status'] == 1 ? 0:1; ?>" class="btn btn-secondary btn-sm mb-1"><?php echo $user['status'] == 1 ? 'Disable':'Enable'; ?></a>
                                    <a href="view.php?id=<?php echo $user['id']; ?>" class="btn btn-info text-white btn-sm mb-1">View</a>
                                    <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-warning text-white btn-sm mb-1">Edit</a>
                                    <a href="changepassword.php?id=<?php echo $user['id']; ?>" class="btn btn-success btn-sm mb-1">Change Password</a>
                                    <a href="delete.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm mb-1">Delete</a>
                                </td>
                            </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="10" class="text-center">No users found</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
</body>

</html>
