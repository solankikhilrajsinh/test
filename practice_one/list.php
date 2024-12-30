<?php
include('db.php');
include 'helper.php';
$db = new Db();
$conn = $db->conn;
session_start();
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
}
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "practice_one";
// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$sql = "SELECT u.*, ud.document, ud.interests, ud.country, ud.about 
        FROM users u
        LEFT JOIN user_details ud ON u.id = ud.user_id";
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



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
                                <td><?php echo isset($user['country']) ? $user['country'] : $user['country']; ?></td>
                                <td><?php echo isset($user['interests']) ? $user['interests'] : $user['interests']; ?></td>
                                <td><?php echo isset($user['about']) ? $user['about'] : $user['about']; ?></td>
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
                                    <button 
                                        class="btn btn-secondary btn-sm mb-1 toggle-status" 
                                        data-id="<?php echo $user['id']; ?>" 
                                        data-status="<?php echo $user['status'] == 1 ? 0 : 1; ?>">
                                        <?php echo $user['status'] == 1 ? 'Disable' : 'Enable'; ?>
                                    </button>
                                    <a href="view.php?id=<?php echo $user['id']; ?>" class="btn btn-info text-white btn-sm mb-1">View</a>
                                    <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-warning text-white btn-sm mb-1">Edit</a>
                                    <a href="changepassword.php?id=<?php echo $user['id']; ?>" class="btn btn-success btn-sm mb-1">Change Password</a>
                                    <button 
                                        class="btn btn-danger btn-sm mb-1 delete-user" 
                                        data-id="<?php echo $user['id']; ?>">
                                        Delete
                                    </button>
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


<div class="card-body text-center">
    <div class="modal fade" id="confirmModal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                </div>
                <div>
                    Are you sure you want to <span id="action-type"></span> this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmAction" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="responseModal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">               
                <div id="message-container"></div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
</div>



<div class="card-body text-center">
    <div class="modal fade" id="confirmModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to <span id="action-type"></span> this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmAction" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="responseModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="message-container" class="modal-body text-center"></div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

  
<script>

$(document).ready(function () {
    let userId, userStatus;
    $(".toggle-status").click(function () {
        userId = $(this).data("id");
        userStatus = $(this).data("status");

        $("#action-type").text(userStatus === 1 ? "enable" : "disable");

        $("#confirmModal").modal("show");
    });

    $("#confirmAction").click(function () {
        
        //window.location.href = `status.php?id=${userId}&status=${userStatus}`;
        const formData = {
          id: userId,
          status: userStatus,
        };
        $.ajax({
          url: 'ajax_status.php', 
          type: 'POST',
          dataType: 'json',
          data: formData, 
          success: function (response) { console.log(response);
            $("#confirmModal").modal("hide");
                const messageContainer = $("#message-container");
                if (response.status === true) {
                    $(`button[data-id='${userId}']`)
                        .data("status", userStatus === 1 ? 0 : 1)
                        .text(userStatus === 1 ? "Disable" : "Enable");
                    messageContainer.html('<div class="alert alert-success mt-3">Updated successfully!</div>');
                }else {
                    messageContainer.html('<div class="alert alert-danger mt-3">Update failed!</div>');
                }
                $("#responseModal").modal("show");
        },
        });
    });
});

$(document).ready(function () {
    let userId, actionType;
    $(".delete-user").click(function () {
        userId = $(this).data("id");
        actionType = "delete";
        $("#action-type").text(actionType);
        $("#confirmAction").text("Delete").addClass("btn-danger").removeClass("btn-primary");
        $("#confirmModal").modal("show");
    });

    $("#confirmAction").click(function () {
        if (actionType === "delete") {
            $.ajax({
                url: 'ajax_delete.php', 
                type: 'POST',
                dataType: 'json',
                data: { id: userId },
                success: function (response) {
                    $("#confirmModal").modal("hide");
                    const messageContainer = $("#message-container");

                    if (response.status === true) {
                        messageContainer.html('<div class="alert alert-success">User deleted successfully!</div>');
                        $(`button[data-id='${userId}']`).closest("tr").remove(); 
                    } else {
                        messageContainer.html('<div class="alert alert-danger">Failed to delete user!</div>');
                    }

                    $("#responseModal").modal("show");
                },
            });
        }
    });
});

</script>

    
</body>
</html>
