<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manager";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['loggedIn']) || empty($_SESSION['Email'])) {
    header("Location: ManagerLogin.php");
    exit();
}

function displayProducts($conn)
{
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Product Information</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Product Code</th><th>Product Name</th><th>Size</th><th>Color</th><th>Price</th><th>Product Image</th><th>Action</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['ProductCode'] . "</td>";
            echo "<td>" . $row['ProductName'] . "</td>";
            echo "<td>" . $row['Size'] . "</td>";
            echo "<td>" . $row['Color'] . "</td>";
            echo "<td>" . $row['Price'] . "</td>";
            echo "<td><img src='" . $row['ProductImage'] . "' height='100' width='100'></td>";
            echo "<td><a href='?delete=" . $row['ProductCode'] . "'>Delete</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No products found.";
    }
}


if (isset($_GET['delete'])) {
    $deleteCode = $_GET['delete'];
    $deleteSql = "DELETE FROM products WHERE ProductCode='$deleteCode'";

    if ($conn->query($deleteSql) === TRUE) {
        echo "Product deleted successfully.";
    } else {
        echo "Error deleting product: " . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $ProductCode = $_POST['product_code'];
    $ProductName = $_POST['product_name'];
    $Size = $_POST['size'];
    $Color = $_POST['color'];
    $Price = $_POST['price'];

    
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["product_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

 
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

 
    if ($_FILES["product_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG & PNG files are allowed.";
        $uploadOk = 0;
    }

  
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    
    } else {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
            echo "The file ". basename( $_FILES["product_image"]["name"]). " has been uploaded.";

            
            $insertSql = "INSERT INTO products (ProductCode, ProductName, Size, Color, Price, ProductImage) 
                          VALUES ('$ProductCode', '$ProductName', '$Size', '$Color', '$Price', '$targetFile')";

            if ($conn->query($insertSql) === TRUE) {
                echo "Product added successfully.";
            } else {
                echo "Error adding product: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Product Information</title>
    <style>
        
        body {
            background-color: rgb(208, 211, 212);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: slateblue;
            text-align: center;
        }
        h2 {
            color: slateblue;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: slateblue;
            color: white;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            padding: 8px;
            width: calc(100% - 16px);
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: slateblue;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: darkslateblue;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: slateblue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

    </style>
</head>

<body>
    <h1>Welcome, Manager!</h1>

    
    <?php displayProducts($conn); ?>

  
    <h2>Add New Product</h2>
    <form method="post" action="" enctype="multipart/form-data">
    
        <input type="text" name="product_code" placeholder="Product Code">
        <input type="text" name="product_name" placeholder="Product Name">
        <input type="text" name="size" placeholder="Size">
        <input type="text" name="color" placeholder="Color">
        <input type="text" name="price" placeholder="Price">
        <input type="file" name="product_image">

        <input type="submit" value="Add Product">
    </form>

    <a href="ManagerPage.php" style="position: absolute; top: 10px; right: 10px;"><b>Back to Manager Page</b></a>

</body>

</html>

<?php
$conn->close();
?>
