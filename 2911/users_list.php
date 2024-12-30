<?php
session_start();
if(empty($_SESSION['user_id'])){
    header("Location:login.php");
}
$servername="localhost";
$username="root";
$password="";
$dbname="logindb";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$all_users = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $all_users[] = $row;
    }
//     echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Gender</th><th>Password</th><th>Qualification</th><th>Specialization</th><th>Date</th><th>Feedback</th><th>Hobbies</th><th>State</th><th>Rate Us</th></tr>";
//   while($row = $result->fetch_assoc()) {
//     echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["phone"]."</td><td>".$row["email"]."</td><td>".$row["gender"]."</td><td>".$row["password"]."</td><td>".$row["qualification"]."</td><td>".$row["specialization"]."</td><td>".$row["created_at"]."</td><td>".$row["feedback"]."</td><td>".$row["hobbies"]."</td><td>".$row["state"]."</td><td>".$row["rate"]."</td></tr>";
//   }             
//   echo "</table>";
} else {
  //echo "0 results";
}

?>

<title>User List</title>
<table  border='1'>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Qualification</th>
        <th>Specialization</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Password</th>
        <th>DOB</th>
        <th>Hobbies</th>
        <th>State</th>
        <th>Rate Us</th>
        <th>Feedback</th>
        <th>Created Date</th>
        <th>Profile Image</th>
        <th>Action</th>
    </tr>
    <?php if(count($all_users) > 0){ 
        foreach($all_users as $user){
        ?>
    <tr>
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['name']; ?></td>
        <td><?php echo $user['qualification']; ?></td>
        <td><?php echo $user['specialization']; ?></td>
        <td><?php echo $user['phone']; ?></td>
        <td><?php echo $user['email']; ?></td>
        <td><?php echo $user['gender']; ?></td>
        <td><?php echo $user['password']; ?></td>
        <td><?php echo date("d-m-Y",strtotime($user['dob'])); ?></td>
        <td><?php echo $user['hobbies']; ?></td>
        <td><?php echo $user['state']; ?></td>
        <td><?php echo $user['rate']; ?></td>
        <td><?php echo $user['feedback']; ?></td>
        <td><?php echo date("d-m-Y h:i:s A",strtotime($user['created_at'])); ?></td>
        <td><img src="uploads/<?php echo $user['profile_image']; ?>"></td>
        <td><a href="view.php?id=<?php echo $user['id']; ?>" style="color: blue;">View</a><br><a href="edit.php?id=<?php echo $user['id']; ?>" style="color: blue;">Edit</a><br><a href="delete.php?id=<?php echo $user['id']; ?>" style="color: blue;">Delete</a></td>
        

    </tr>
    <?php } } ?>
</table>









<!-- 


<?php
session_start();
if(empty($_SESSION['user_id'])){
    header("Location:login.php");
}
$servername="localhost";
$username="root";
$password="";
$dbname="logindb";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$all_users = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $all_users[] = $row;
    }
//     echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Gender</th><th>Password</th><th>Qualification</th><th>Specialization</th><th>Date</th><th>Feedback</th><th>Hobbies</th><th>State</th><th>Rate Us</th></tr>";
//   while($row = $result->fetch_assoc()) {
//     echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["phone"]."</td><td>".$row["email"]."</td><td>".$row["gender"]."</td><td>".$row["password"]."</td><td>".$row["qualification"]."</td><td>".$row["specialization"]."</td><td>".$row["created_at"]."</td><td>".$row["feedback"]."</td><td>".$row["hobbies"]."</td><td>".$row["state"]."</td><td>".$row["rate"]."</td></tr>";
//   }             
//   echo "</table>";
} else {
  //echo "0 results";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-3">


<!-- <table  border='1'> -->
<div class="table-responsive">
    <table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Qualification</th>
        <th>Specialization</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Password</th>
        <th>DOB</th>
        <th>Hobbies</th>
        <th>State</th>
        <th>Rate Us</th>
        <th>Feedback</th>
        <th>Created Date</th>
        <th>Profile Image</th>
        <th>Action</th>
    </tr>
</thead>
    <?php if(count($all_users) > 0){ 
        foreach($all_users as $user){
        ?>
    <tbody>
    <tr>
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['name']; ?></td>
        <td><?php echo $user['qualification']; ?></td>
        <td><?php echo $user['specialization']; ?></td>
        <td><?php echo $user['phone']; ?></td>
        <td><?php echo $user['email']; ?></td>
        <td><?php echo $user['gender']; ?></td>
        <td><?php echo $user['password']; ?></td>
        <td><?php echo date("d-m-Y",strtotime($user['dob'])); ?></td>
        <td><?php echo $user['hobbies']; ?></td>
        <td><?php echo $user['state']; ?></td>
        <td><?php echo $user['rate']; ?></td>
        <td><?php echo $user['feedback']; ?></td>
        <td><?php echo date("d-m-Y h:i:s A",strtotime($user['created_at'])); ?></td>
        <td><img src="uploads/<?php echo $user['profile_image']; ?>"></td>
        <td><a href="view.php?id=<?php echo $user['id']; ?>" style="color: blue;">View</a><br><a href="edit.php?id=<?php echo $user['id']; ?>" style="color: blue;">Edit</a><br><a href="delete.php?id=<?php echo $user['id']; ?>" style="color: blue;">Delete</a></td>
        

    </tr>
    <?php } } ?>
        </tbody>
        </table>
        </div>
        </div>
    </body>
</html> -->
