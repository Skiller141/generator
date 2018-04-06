<?php
    require_once('connect.php');
    if(isset($_POST) & !empty($_POST)){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pwd = md5($_POST['password']);
        $sql = "SELECT * FROM users WHERE email='$email' AND pass='$pwd'";

        $result = mysqli_query($conn, $sql);
        $count = count(mysqli_num_rows($result));
        
        if($count == 1){
            echo $count;
            session_start();
            $_SESSION['email'] = $email;
        } else {
            $fmsg = "Invalid Email/Password";
        }
    }
    if(isset($_SESSION['email'])){
        $smsg = "User already logged in";
        header('location: admin.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/admin.css">
    <title>Login</title>
</head>
<body>
    <div class="main-contaner">
        <div class="my-contaner">
            <h1 align="center">Login</h1>
            <div class="form-contaner">
                <?php if(isset($smsg)){?><div class="smsg"><?php echo $smsg;?></div><?php } ?>
                <?php if(isset($fmsg)){?><div class="fmsg"><?php echo $fmsg;?></div><?php } ?>
                <form action="" id="reg-form" method="POST">
                    <label for="email">Email</label><br>
                    <input type="email" name="email" id="email"><br>
                    <label for="password">Password</label><br>
                    <input type="password" name="password" id="password"><br>
                    <input type="submit" value="Login">
                    <a href="register.php">Create an account</a>
                </form>
            </div>
        </div>
        <?php 
            if(isset($_SESSION['email'])){
                ?>
                <a href="logout.php" class="logout">Log out</a>
                <?php
            }
        ?>
    </div>
</body>
</html>