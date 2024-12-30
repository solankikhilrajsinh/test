<?php
$id = $_GET['id'];
$status = $_GET['status'];
$message = $error = "";
$status_updated = false;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practicedb";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$status_update_query = "UPDATE practice SET status = $status WHERE id = $id";
        
if ($conn->query($status_update_query) === true) {
    $status_updated = true;
    $message = "Status updated successfully!";
} else {
    $error = "Error updating status: " . $conn->error;
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change User Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body >
<?php include('header.php');?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">           
                    <div class="card-header bg-primary text-white text-center">
                        <h2>Status Update</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($status_updated) { ?>
                            <div class="alert alert-success text-center">
                                <strong><?php echo $message; ?></strong>
                            </div>
                        <?php } elseif (!empty($error)) { ?>
                            <div class="alert alert-danger text-center">
                                <strong><?php echo $error; ?></strong>
                            </div>
                        <?php } ?>                                                                                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
