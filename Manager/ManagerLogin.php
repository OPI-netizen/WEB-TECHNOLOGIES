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

if (isset($_POST['submit'])) {
    $error = ''; 

    if (empty($_POST['eml']) || empty($_POST['pass'])) {
        $error = "Email or Password is invalid";
    } else {
        $Email = $_POST["eml"];
        $PassWord = $_POST["pass"];

        $result = loginuser($conn, "managerinfo", $Email, $PassWord);

        if ($result->num_rows > 0) {
            $_SESSION['Email'] = $_POST['eml'];
            $_SESSION['PassWord'] = $_POST['pass'];
            $_SESSION['loggedIn'] = true; 
            header("Location: ManagerPage.php");
            exit();
        } else {
            $error = "Email or Password is invalid";
        }
    }
}

function loginuser($conn, $managerinfo, $Email, $PassWord)
{
    $result = $conn->query("SELECT * FROM " . $managerinfo . " WHERE Email='" . $Email . "' AND PassWord='" . $PassWord . "'");
    return $result;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <style>
        body {
            background-color: rgb(208, 211, 212);
            font-family: Arial, sans-serif;
        }

        center {
            margin-top: 10%;
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

        p {
            color: red;
            text-align: center;
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
    </style>
</head>

<body>
    <center>
        <h1>Manager Login</h1>
        <form method="post" action="">
            <table>
                <tr>
                    <td style="color: slateblue; font-size:150%;"><b>E-mail:</b></td>
                    <td><input type="text" name="eml" placeholder="Enter Email"></td>
                </tr>

                <tr>
                    <td style="color: slateblue; font-size:150%;"><b>Password:</b></td>
                    <td><input type="password" name="pass" placeholder="Enter Password"></td>
                </tr>
            </table>
            <br>

            <input type="submit" name="submit" value="Login"><br><br>

            <?php if (!empty($error)) { ?>
                <p><?php echo $error; ?></p>
            <?php } ?>

            <hr>

            <p>Don't have an Account?<strong><a href="ManagerRegistration.php">Register Now!</a></strong></p>

        </form>
    </center>
</body>

</html>

