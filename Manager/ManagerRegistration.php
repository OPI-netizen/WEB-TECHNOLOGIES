<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manager";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $requiredFields = ['fname', 'dob', 'gender','PN', 'eml', 'pass','branch', 'nid'];
    $isValid = true;

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $isValid = false;
            break;
        }
    }



    if ($isValid) {
        $FullName = $_POST['fname'];
        
       
        $DOB = $_POST['dob'];
        $GANDER = $_POST['gender'];
        $PhoneNumber = $_POST['PN'];
        $Email = $_POST['eml'];
        $PassWord = $_POST['pass'];
        $Branch = $_POST['branch'];
        $NationalID = $_POST['nid'];

        insertUser($FullName, $DOB, $GANDER,$PhoneNumber, $Email, $PassWord,$Branch, $NationalID, $conn);
    } else {
        echo "Please fill in all the required fields.";
    }
}

function insertUser($FullName,  $DOB, $GANDER,$PhoneNumber, $Email, $PassWord,$Branch, $NationalID, $conn)
{
    $sql = "INSERT INTO managerinfo (FullName, DOB, GANDER, PhoneNumber, Email, PassWord, Branch, NationalID) VALUES ('$FullName',  '$DOB', '$GANDER','$PhoneNumber', '$Email', '$PassWord','$Branch', '$NationalID')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration Page</title>
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
        input[type="password"],
        input[type="checkbox"] 
        input[type="radio"] {
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
        <h1>Manager Registration</h1>
        <form method="post">
            <table>

                <tr>
                    <td style="color: slateblue; font-size:150%;"><b>Fullname:</b></td>
                    <td><input type="text" name="fname" placeholder="Enter Fullname"></td>
                </tr>

                <tr>
                    <td style="color: slateblue;font-size:150%;"><b>Date of Birth:</b></td>
                    <td><input type="date" name="dob"></td>
                </tr>

                <tr>
                    <td style="color: slateblue;font-size:150%;"><b>Gender:</b></td>
                    <td>
                        <input type="checkbox" name="gender" value="Male"> Male
                        <input type="checkbox" name="gender" value="Female"> Female<br>
                    </td>
                </tr>

                <tr>
                    <td style="color: slateblue;font-size:150%;"><b>Phone Number:</b></td>
                    <td><input type="text" name="PN" placeholder="Enter Phone Number"></td>
                </tr>

                <tr>
                    <td style="color: slateblue;font-size:150%;"><b>E-mail:</b></td>
                    <td><input type="email" name="eml" placeholder="Enter Email"></td>
                </tr>

                <tr>
                    <td style="color: slateblue;font-size:150%;"><b>Password:</b></td>
                    <td><input type="password" name="pass" placeholder="Enter Password" ></td>
                </tr>

                <tr>
                    <td style="color: slateblue;font-size:150%;"><b>Branch:</b></td>
                    <td>
                        <input type="radio" name="branch" value="Motijheel">Motijheel<br>
                        <input type="radio" name="branch" value="Mohammadpur">Mohammadpur<br>
                        <input type="radio" name="branch" value="Mirpur">Mirpur<br>
                    </td>
                </tr>

                <tr>
                    <td style="color: slateblue;font-size:150%;"><b>NID:</b></td>
                    <td><input type="text" name="nid" placeholder="Enter NID"  maxlength="10"></td>
                </tr>


            </table>
            <br>

            <input type="submit" value="Submit"><br><br>

            <?php if (!empty($error)) { ?>
                <p><?php echo $error; ?></p>
            <?php } ?>

            <hr>

            <p>Already have an Account?<strong><a href="ManagerLogin.php">Login Now!</a></strong></p>

        </form>
    </center>
</body>

</html>