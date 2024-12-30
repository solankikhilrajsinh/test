<?php

$post_data = $_POST;
$servername="localhost";
$username="root";
$password="";
$dbname="logindb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$x = "INSERT INTO login(email,password) VALUES('".$post_data['email']."','".$post_data['password']."')";
if ($conn->query($x) === TRUE) {
    echo "New record created successfully";
} 
else {
    echo "Error: " . $x . "<br>" . $conn->error;
}
  
$x = "SELECT * FROM login";
$result = $conn->query($x);
  
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Email</th><th>Password</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["email"]."</td><td>".$row["password"]."</td></tr>";
    }             
    echo "</table>";
} 
else {
    echo "0 results";
}

?>