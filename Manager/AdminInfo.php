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


function displayAdmins($conn)
{
    $sql = "SELECT * FROM admininfo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Admin Information</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Full Name</th><th>Date of Birth</th><th>Gander</th><th>Phone Number</th><th>Email</th><th>Branch</th><th>NID</th><th>Action</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['ID'] . "</td>";
            echo "<td>" . $row['A_FullName'] . "</td>";
            echo "<td>" . $row['A_DOB'] . "</td>";
            echo "<td>" . $row['A_GANDER'] . "</td>";
            echo "<td>" . $row['A_PhoneNumber'] . "</td>";
            echo "<td>" . $row['A_Email'] . "</td>";
            echo "<td>" . $row['A_Branch'] . "</td>";
            echo "<td>" . $row['A_NationalID'] . "</td>";
            echo "<td><a href='?delete=" . $row['A_Email'] . "'>Delete</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No admin found.";
    }
}


if (isset($_GET['delete'])) {
    $deleteEmail = $_GET['delete'];
    $deleteSql = "DELETE FROM admininfo WHERE A_Email='$deleteEmail'";

    if ($conn->query($deleteSql) === TRUE) {
        echo "Admin deleted successfully.";
    } else {
        echo "Error deleting admin: " . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $ID = $_POST['id'];
    $A_FullName = $_POST['a_fname'];
    $A_DOB = $_POST['a_dob'];
    $A_GANDER = $_POST['a_gander'];
    $A_PhoneNumber = $_POST['PN'];
    $A_Email = $_POST['a_email'];
    $A_Password = $_POST['a_password'];
    $A_Branch = $_POST['a_branch'];
    $A_NationalID = $_POST['a_nid'];

    
    $insertSql = "INSERT INTO admininfo (ID,A_FullName,  A_DOB, A_GANDER,A_PhoneNumber, A_Email, A_Password,A_Branch, A_NationalID) 
                  VALUES ('$ID','$A_FullName', '$A_DOB', '$A_GANDER','$A_PhoneNumber', '$A_Email', '$A_Password','$A_Branch', '$A_NationalID')";

    if ($conn->query($insertSql) === TRUE) {
        echo "Admin added successfully.";
    } else {
        echo "Error adding admin: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Information</title>
    <style>
        body {
            background-color: rgb(208, 211, 212);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1,
        h2 {
            color: slateblue;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
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
        input[type="email"] {
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
 
    <?php displayAdmins($conn); ?>

    <h2>Add New Admin</h2>
    <form method="post" action="">

        <input type="text" name="id" placeholder="Admin ID">
        <input type="text" name="a_fname" placeholder="Admin Full Name">
        <input type="date" name="a_dob" placeholder="Date of Birth">
        <label for="male">Male</label>
        <input type="radio" name="a_gander" value="male" id="male">
        <label for="female">Female</label>
        <input type="radio" name="a_gander" value="female" id="female"> 
        <input type="text" name="PN" placeholder="Admin Phone Number" >
        <input type="email" name="a_email" placeholder="Admin Email">
        <input type="password" name="a_password" placeholder="Admin Password">


        <label for="motijheel">Motijheel</label>
        <input type="radio" name="a_branch" value="motijheel" id="motijheel">
        <label for="mohammadpur">Mohammadpur</label>
        <input type="radio" name="a_branch" value="mohammadpur" id="mohammadpur">
        <label for="mirpur">Mirpur</label>
        <input type="radio" name="a_branch" value="mirpur" id="mirpur">





        <input type="text" name="a_nid" placeholder="National ID">

        <input type="submit" value="Add Admin">
    </form>

    <a href="ManagerPage.php" style="position: absolute; top: 10px; right: 10px;"><b>Back to Manager Page</b></a>

</body>

</html>


<?php
$conn->close();
?>