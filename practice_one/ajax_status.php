<?php
$id = $_POST['id'];
$status = $_POST['status'];
include('db.php');
$db = new Db();


if (isset($id) && isset($status)) {
    $response = $db->ajax_status($id, $status);
} else {
    $response = ['status' => false, 'message' => 'Invalid data provided.'];
}
echo json_encode($response);
?>



