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

function displayManagers($conn)
{
    $sql = "SELECT * FROM managerinfo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Manager Information</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Full Name</th><th>Date of Birth</th><th>Gander</th><th>Phone Number</th><th>Email</th><th>Branch</th><th>NID</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['FullName'] . "</td>";
            echo "<td>" . $row['DOB'] . "</td>";
            echo "<td>" . $row['GANDER'] . "</td>";
            echo "<td>" . $row['PhoneNumber'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['Branch'] . "</td>";
            echo "<td>" . $row['NationalID'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No manager found.";
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>Manager Information</title>
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

    <?php displayManagers($conn); ?>

    <a href="ManagerPage.php" style="position: absolute; top: 10px; right: 10px;"><b>Back to Manager Page</b></a>
</body>

</html>


<?php
$conn->close();
?>