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


function searchProducts($conn, $searchTerm)
{
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm); 

    $sql = "SELECT * FROM products WHERE ProductName LIKE '%$searchTerm%' OR ProductCode LIKE '%$searchTerm%' OR Color LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Search Results</h2>";
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
        echo "No matching products found.";
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

?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Product</title>
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

        form {
            width: 50%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"] {
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

  
    <form method="post" action="">
        <input type="text" name="searchTerm" placeholder="Search by name, code, or color">
        <input type="submit" name="search" value="Search">
    </form>

   
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
        $searchTerm = $_POST['searchTerm'];

        if (!empty($searchTerm)) {
            searchProducts($conn, $searchTerm);
        } else {
            echo "Please enter a search term.";
        }
    }
    ?>


    <a href="ManagerPage.php" style="position: absolute; top: 10px; right: 10px;"><b>Back to Manager Page</b></a>
</body>

</html>
<?php
$conn->close();
?>