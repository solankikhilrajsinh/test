<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logindb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, image_name, image_data FROM images";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>                  
    <title>Display Images</title>
</head>
<body>
    <h1>Uploaded Images</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h3>" . htmlspecialchars($row['image_name']) . "</h3>";
            echo "<img src='data:image/jpeg;base64," . base64_encode($row['image_data']) . "' width='300'/>";
            echo "</div><hr>";
        }
    } else {
        echo "No images found.";
    }
    ?>
    

</body>
</html>
