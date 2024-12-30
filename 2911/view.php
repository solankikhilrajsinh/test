<?php
$id = $_GET['id'];

$servername="localhost";
$username="root";
$password="";
$dbname="logindb";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql="SELECT * FROM users WHERE id='$id'";
$result = $conn->query($sql);

$user = array(); 


if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // print_r($user);
} else {    
    echo "No matching results found.";
}

?>


<title>View Profile</title>
<table border=1>
    <tr>
        <td>Id</td>
        <td><?php echo $user['id']; ?></td>
    </tr>
    <tr>
        <td>Name</td>
        <td><?php echo $user['name']; ?></td>
    </tr>
    <tr>
        <td>Qualification</td>
        <td><?php echo $user['qualification']; ?></td>
    </tr>
    <tr>
        <td>Specialization</td>
        <td><?php echo $user['specialization']; ?></td>
    </tr>
    <tr>
        <td>Phone</td>
        <td><?php echo $user['phone']; ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?php echo $user['email']; ?></td>
    </tr>
    <tr>
        <td>Gender</td>
        <td><?php echo $user['gender']; ?></td>
    </tr>
    <tr>
        <td>Password</td>
        <td><?php echo $user['password']; ?></td>
    </tr>
    <tr>
        <td>DOB</td>
        <td><?php echo date("d-m-Y",strtotime($user['dob'])); ?></td>
    </tr>
    <tr>
        <td>Hobbies</td>
        <td><?php echo $user['hobbies']; ?></td>
    </tr>
    <tr>
        <td>State</td>
        <td><?php echo $user['state']; ?></td>
    </tr>
    <tr>
        <td>Rate Us</td>
        <td><?php echo $user['rate']; ?></td>
    </tr>
    <tr>
        <td>Feedback</td>
        <td><?php echo $user['feedback']; ?></td>
    </tr>
    <tr>
        <td>Profile Image</td>
        <td><img src="uploads/<?php echo $user['profile_image']; ?>"></td>
    </tr>
    <tr>
        <td>Created Date</td>
        <td><?php echo date("d-m-Y h:i:s A",strtotime($user['created_at'])); ?></td>
    </tr>
</table>

