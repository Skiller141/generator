<?php
require_once('connect.php');
require_once('functions.php');

if(isset($_POST) & !empty($_POST)){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pwd = md5($_POST['password']);
    $repPwd = md5($_POST['repPassword']);
    
    $sql = "SELECT * FROM users";
    if(!mysqli_query($conn, $sql)){
        $sqlCreateTable = "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(50),
            pass VARCHAR(30),
            reg_date TIMESTAMP
        )";
        if(mysqli_query($conn, $sqlCreateTable)){
            createDirAndSession($conn, $email, $pwd, $repPwd);
        }
    } else {
        $sqlselect = "SELECT * FROM users WHERE email='$email'";
        $resultselect = mysqli_query($conn, $sqlselect);
        $count = mysqli_num_rows($resultselect);
        if($count == 1){
            $fmsg = 'Такой Email уже существует';
        } else {
            createDirAndSession($conn, $email, $pwd, $repPwd);
        } 
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/admin.css">
    <title>Register</title>
</head>
<body>
    <div class="my-contaner">
        <h1 align="center">Register</h1>
        <div class="form-contaner">
            <?php if(isset($smsg)){?><div class="smsg"><?php echo $smsg;?></div><?php } ?>
            <?php if(isset($fmsg)){?><div class="fmsg"><?php echo $fmsg;?></div><?php } ?>
            <form action="" id="reg-form" method="POST">
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email"><br>
                <label for="password">Password</label><br>
                <input type="password" name="password" id="password"><br>
                <label for="repPassword">Repeat password</label><br>
                <input type="password" name="repPassword" id="repPassword"><br>
                <input type="submit" value="Register">
                <a href="login.php">Log In</a>
            </form>
        </div>
    </div>
</body>
</html>