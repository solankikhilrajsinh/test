<?php
$userId = $_POST['id'];
$response = ['status' => false];
include('db.php');
$db = new Db();
$conn = $db->conn;
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "practice_one";

// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

if (isset($_POST['id'])) {
    $userId = $_POST['id']; 
    $response = $db->ajax_delete($userId);
}

echo json_encode($response);
?> 

