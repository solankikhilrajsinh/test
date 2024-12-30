<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logindb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['upload'])) {
 
    if (!empty($_FILES['image']['tmp_name'])) {
        $imageName = $_FILES['image']['name'];
        $imageData = addslashes(file_get_contents($_FILES['image']['tmp_name']));

        
        $sql = "INSERT INTO images (image_name, image_data) VALUES ('$imageName', '$imageData')";

        if ($conn->query($sql) === TRUE) {
            echo "Image uploaded successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No image selected.";
    }
    
}
?>
