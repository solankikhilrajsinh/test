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
       
       
        
        $x = "SELECT * FROM login";
        $result = $conn->query($x);
        
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>Brand</th><th>Product</th><th>Count</th><th>Price</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["brand"]."</td><td>".$row["product"]."</td><td>".$row["count"]."</td><td>".$row["price"]."</td></tr>";
            }             
            echo "</table>";
        } 
        else {
            echo "0 results";
        }


        if(isset($_POST['upload']))
        {
            $file_name=$_FILES['image']['name'];
            $tempname=$_FILES['image']['tmp_name'];
            $folder='test/2711/images/'.$file_name;
            $query=mysqli_query($conn,"Insert into login(file)values('$file_name')");
            if(move_uploaded_file($tempname,$folder))
            {
                echo"<h2>File uploaded successfully</h2>";
            }
            else{
                echo"<h2>File not uploaded </h2>";
            }
        }   
    
?>