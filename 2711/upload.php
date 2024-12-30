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

    // include('login.php');
    if(isset($_POST['submit']))
    {
        $file_name=$_FILES['image']['name'];
        $tempname=$_FILES['image']['tmp_name'];
        $folder='test/images/'.$file_name;
        $query=mysqli_query($conn,"Insert into upload(file)values('$file_name')");
        if(move_uploaded_file($tempname,$folder))
        {
            echo"<h2>File uploaded successfully</h2>";
        }
        else{
            echo"<h2>File not uploaded </h2>";
        }
    }   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <div>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #b3b9b1;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 455px;
        }

        label {
            font-size: 14px;
            color: #131212;
        }
        h2 {
            text-align: center;
            color: #1a1818;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }


        button {
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        button[type="Submit"] {
            background-color: #28a745;
        }
        button[type="Choose File"] {
            background-color: #727274;
        }
   
    </style>
    </div>
</head>
<body>
    <h2>Document</h2>
    <div style="display:flex;justify-content: center;">
    <form method="POST"enctype="multipart/form-data">
        <input type="file" name="image"/>
        <br/><br/>
        <button type="submit" name="submit">Submit<button>
    </form>
    <?php
        $res=mysqli_query($conn,"SELECT * FROM upload");
        while($row=mysqli_fetch_assoc($res)){
    ?>
    <div>
        <img src="Images<?php echo $row['file']?>" />
        <?php }?>
    </div>
</body>
</html>
