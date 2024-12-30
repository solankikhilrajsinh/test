

<?php
    session_start();
    // if(empty($_SESSION['user_id'])){
    //     header("Location:login.php");
    // }
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="logindb";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // include('login.php');
    $post_data = $_POST;
    $product_error='';
    $brand_error='';
    $count_error='';
    $price_error='';
    $image_error='';
    if($post_data)
    {
        if (empty($post_data['product']) || empty($post_data['brand']) || empty($post_data['count'])|| empty($post_data['price']) || empty($post_data['image'])){
            if(empty($post_data['product'])){
                $product_error.='*Product is required';
            }
            if(empty($post_data['brand'])){
                $brand_error.='*Brand is required';
            }
            if(empty($post_data['count'])){
                $count_error.='*Count is required';
            }
            if(empty($post_data['price'])){
                $price_error.='*Price is required';
            }
            if(empty($post_data['image'])){
                $image_error.='*Product Image is required';
            }
        
        }
        else{
            if(isset($_POST['submit']))
            {

            
                $brand = isset($post_data['brand']) ? $post_data['brand'] : '';
                $product = isset($post_data['product']) ? $post_data['product'] : '';
                $count = isset($post_data['count']) ? $post_data['count'] : '';
                $price = isset($post_data['price']) ? $post_data['price'] : '';
                $x = "INSERT INTO product (brand, count, product, price) VALUES ('$brand', '$count', '$product', '$price')";
                
            
                if ($conn->query($x) === TRUE) {
                    echo "New record created successfully";
                } 
                else {
                    echo "Error: " . $x . "<br>" . $conn->error;
                }
                
                $x = "SELECT * FROM product";
                $result = $conn->query($x);
                
                

                if(isset($_POST['upload']))
                {
                    $file_name=$_FILES['image']['name'];
                    $tempname=$_FILES['image']['tmp_name'];
                    $folder='test/images/'.$file_name;
                    $query=mysqli_query($conn,"Insert into dashboard(file)values('$file_name')");
                    if(move_uploaded_file($tmp_name,$images))
                    {
                        echo"<h2>File uploaded successfully</h2>";
                    }
                    else{
                        echo"<h2>File not uploaded </h2>";
                    }
                } 
            }  
        }
?>
<?php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <div>
        <style>
            form {
            background-color: #b3b9b1;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 100%;
            height:100%;
            }
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                margin: 0;
                padding: 0;
                align-items: center;
                height: 100vh;
            }
            h1 {
                text-align: center;
                color: #1a1818;
            }
            label {
                font-size: 14px;
                color: #131212;
            }
            .form-control {
                /* width: 100%; */
                padding: 10px;
                margin: 8px 0;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .error_text{
                color:red;
            }

            .product-category {
                margin-bottom: 30px;
                color: #333;
            }

            button {
                color: white;
                padding: 10px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-top: 10px;
            }
            
            button[type="submit"] {
                background-color: #28a745;
            }
            
          
        
        </style>
</head>
<body>
    <h1>Product Page</h1>
    <!-- <a href="logout.php" style="background-color: #FF0000; color: white; padding: 10px; border-radius: 4px; text-decoration: none; position: absolute; top: 20px; right: 20px;">Logout</a>
    <a href="users_list.php" style="background-color: #8; color: white; padding: 10px; border-radius: 4px; text-decoration: none;position: absolute;top: 20px;right: 100px;">List</a>     -->
    <div>    
        <form action="product.php" method="POST">

                <!-- <h3>Select Product </h3> -->
                <label for="product">Product</label><br><br>
                <select id="product" name="product" onchange="updateOptions()">
                    <option value="" disabled selected>Choose a Category</option>
                    <option value="mobile" <?php if(!empty($post_data['product']) && $post_data['product']=="Mobile"){ echo 'selected="selected"';} ?>>Mobile</option>
                    <option value="tv" <?php if(!empty($post_data['product']) && $post_data['product']=="TV"){ echo 'selected="selected"';} ?>>TV</option>
                    <option value="laptop" <?php if(!empty($post_data['product']) && $post_data['product']=="Laptop"){ echo 'selected="selected"';} ?>>Laptop</option>
                </select><br>
                <p class="error_text"><?php echo $product_error; ?></p><br>

                <label for="brand">Brand:</label><br>
                <input class="form-control" type="brand" id="brand" name="brand" placeholder="Please enter brand name" value="<?php if(isset($post_data['brand'])){ echo $post_data['brand']; } ?>" ><br>
                <p class="error_text"><?php echo $brand_error; ?></p><br>

                <label for="count">Count:</label><br>
                <input class="form-control" type="count" id="count" name="count" placeholder="Please enter no. of models" value="<?php if(isset($post_data['count'])){ echo $post_data['count']; } ?>"><br>
                <p class="error_text"><?php echo $count_error; ?></p><br>

                <label for="price">Price:</label><br>
                <input class="form-control" type="price" id="price" name="price" placeholder="Please enter Price" value="<?php if(isset($post_data['price'])){ echo $post_data['price']; } ?>" ><br>
                <p class="error_text"><?php echo $price_error; ?></p><br>

                <label for="image">Product Image:</label><br><br>
                <form method="POST"enctype="multipart/form-data">
                    <input type="file" id="image"name="image" value="<?php if(isset($post_data['image'])){ echo $post_data['image']; } ?>">
                    <p class="error_text"><?php echo $image_error;?></p>
                    
                    <button type="submit" name="submit" >Submit</button>
                </form>
                
                <?php
                    $res=mysqli_query($conn,"SELECT * FROM product");
                    while($row=mysqli_fetch_assoc($res)){
                ?>
                <div>
                    <img src="Images<?php echo $row['file']?>" />
                    <?php }?></div>
        </form>
        
    </div>
</body>
</html>  



