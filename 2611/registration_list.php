<?php
$servername="localhost";
$username="root";
$password="";
$dbname="logindb";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Gender</th><th>Password</th><th>Qualification</th><th>Specialization</th><th>Date</th><th>Feedback</th><th>Hobbies</th><th>State</th><th>Rate Us</th></tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["phone"]."</td><td>".$row["email"]."</td><td>".$row["gender"]."</td><td>".$row["password"]."</td><td>".$row["qualification"]."</td><td>".$row["specialization"]."</td><td>".$row["created_at"]."</td><td>".$row["feedback"]."</td><td>".$row["hobbies"]."</td><td>".$row["state"]."</td><td>".$row["rate"]."</td></tr>";
  }             
  echo "</table>";
} else {
  echo "0 results";
}

?>