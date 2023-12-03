<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manager";

$conn = new mysqli($servername, $username, $password, $dbname);

if (!isset($_SESSION['loggedIn']) || empty($_SESSION['Email'])) {
    header("Location: ManagerLogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FullName = $_POST['fname'];
    $PhoneNumber = $_POST['PN'];
    $Email = $_POST['eml'];
    $PassWord = $_POST['pass'];

    updateProfile($FullName,$PhoneNumber, $Email, $PassWord, $_SESSION['Email'], $conn);
}

function updateProfile($FullName,$PhoneNumber,$Email, $PassWord, $currentEmail, $conn)
{
    $sql = "UPDATE managerinfo SET FullName='$FullName',PhoneNumber='$PhoneNumber', Email='$Email', PassWord='$PassWord' WHERE Email='$currentEmail'";

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully";
        $_SESSION['Email'] = $Email; 
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Update Profile</title>
    <style>
        body {
            background-color: rgb(208, 211, 212);
            font-family: Arial, sans-serif;
        }

        center {
            margin-top: 5%;
        }

        h1 {
            color: slateblue;
            font-size: 300%;
        }

        table {
            margin: 0 auto;
        }

        td {
            padding: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="password"] {
            padding: 8px;
            width: 200px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: slateblue;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: darkslateblue;
        }

        hr {
            height: 3px;
            width: 20%;
            color: gray;
            background-color: slateblue;
        }

        a {
            color: slateblue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <center>
        <h1>Update Profile</h1>

        <?php
        $currentEmail = $_SESSION['Email'];
        $result = $conn->query("SELECT * FROM managerinfo WHERE Email='$currentEmail'");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        ?>
            <form method="post" action="">
                <table>
                    <tr>
                        <td style="color: slateblue; font-size:150%;"><b>Fullname:</b></td>
                        <td><input type="text" name="fname" value="<?php echo $row['FullName']; ?>"></td>
                    </tr>

                    <tr>
                        <td style="color: slateblue; font-size:150%;"><b>Phone Number:</b></td>
                        <td><input type="text" name="PN" value="<?php echo $row['PhoneNumber']; ?>"></td>
                    </tr>
        
                    <tr>
                        <td style="color: slateblue;font-size:150%;"><b>E-mail:</b></td>
                        <td><input type="email" name="eml" value="<?php echo $row['Email']; ?>"></td>
                    </tr>

                    <tr>
                        <td style="color: slateblue;font-size:150%;"><b>Password:</b></td>
                        <td><input type="password" name="pass" value="<?php echo $row['PassWord']; ?>"></td>
                    </tr>

                </table><br>
                <input type="submit" value="Update"><br>
            <?php
        } else {
            echo "No manager found";
        }
            ?>

            <br><a href="ManagerPage.php"><b>Back to Manager Page</b></a>
            </form>
    </center>
</body>

</html>