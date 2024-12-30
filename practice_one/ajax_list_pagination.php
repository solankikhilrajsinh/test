<?php

include('db.php');
$db = new Db();
$conn = $db->conn;

$users_per_page = isset($_GET['length']) ? (int)$_GET['length'] : 5;
$current_page = isset($_GET['start']) ? (int)$_GET['start'] / $users_per_page + 1 : 1;
$offset = ($current_page - 1) * $users_per_page;

$search_value = isset($_GET['search']['value']) ? $conn->real_escape_string($_GET['search']['value']) : '';


$search_condition = '';
if (!empty($search_value)) {
    $search_condition = "
        WHERE users.name LIKE '%$search_value%'
        OR users.email LIKE '%$search_value%'
        OR user_details.country LIKE '%$search_value%'
        OR user_details.interests LIKE '%$search_value%'
    ";
}


$total_users_query = "
    SELECT COUNT(*) AS total 
    FROM users 
    LEFT JOIN user_details ON users.id = user_details.user_id
    $search_condition
";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total'];


$users_query = "
    SELECT users.*, user_details.country, user_details.interests, user_details.about, user_details.document
    FROM users 
    LEFT JOIN user_details ON users.id = user_details.user_id
    $search_condition
    LIMIT $offset, $users_per_page
";
$users_result = $conn->query($users_query);

$users = [];
while ($user = $users_result->fetch_assoc()) {
    $status_button = $user['status'] == 1 
        ? '<button class="btn btn-secondary btn-sm mb-1 toggle-status" data-id="' . $user['id'] . '" data-status="0">Disable</button>': '<button class="btn btn-secondary btn-sm mb-1 toggle-status" data-id="' . $user['id'] . '" data-status="1">Enable</button>';

    $action_buttons = '
        ' . $status_button . '
        <a href="view.php?id=' . $user['id'] . '" class="btn btn-info text-white btn-sm mb-1">View</a>
        <a href="edit.php?id=' . $user['id'] . '" class="btn btn-warning text-white btn-sm mb-1">Edit</a>
        <a href="changepassword.php?id=' . $user['id'] . '" class="btn btn-success btn-sm mb-1">Change Password</a>
        <button class="btn btn-danger btn-sm mb-1 delete-user" data-id="' . $user['id'] . '">Delete</button>';

    $users[] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'phone' => $user['phone'],
        'email' => $user['email'],
        'gender' => $user['gender'],
        'dob' => isset($user['dob']) ? date("d-m-Y", strtotime($user['dob'])) : '',
        'created_at' => isset($user['created_at']) ? date("d-m-Y h:i:s A", strtotime($user['created_at'])) : '',
        'country' => isset($user['country']) ? $user['country'] : '',
        'interests' => isset($user['interests']) ? $user['interests'] : '',
        'about' => isset($user['about']) ? $user['about'] : '',
        'password' => isset($user['password']) ? $user['password'] : '',
        'document' => isset($user['document']) && $user['document'] ? ''. $user['document'] : '',
        'profile_image' => isset($user['profile_image']) && $user['profile_image'] ? ''. $user['profile_image'] : '',
        'action' => $action_buttons
    ]; 
}

$response = [
    'draw' => isset($_GET['draw']) ? (int)$_GET['draw'] : 1,
    'recordsTotal' => $total_users,
    'recordsFiltered' => $total_users,
    'data' => $users
];

echo json_encode($response);

?>
