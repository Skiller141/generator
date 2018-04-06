<?php
require_once('connect.php');
if(isset($_POST) & !empty($_POST)){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pwd = md5($_POST['password']);
    $repPwd = md5($_POST['repPassword']);

    $sqlselect = "SELECT * FROM users WHERE email='$email'";
    $resultselect = mysqli_query($conn, $sqlselect);
    $count = mysqli_num_rows($resultselect);
    if($count == 1){
        $fmsg = 'Такой Email уже существует';
    } else {
        if($pwd === $repPwd) {
            $sql = "INSERT INTO users(email, pass) VALUE ('$email', '$pwd')";
            $result = mysqli_query($conn, $sql);
            if($result){
                $smsg = "User Registration successfull";
                mkdir('users/'.$email, 0777, true);
                file_put_contents('users/'.$email.'/index.html', '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Document</title>
                </head>
                <body>
                    
                </body>
                </html>');
                $sql = "SELECT * FROM users WHERE email='$email' AND pass='$pwd'";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($result);
                session_start();
                $_SESSION['email'] = $email;
                if(isset($_SESSION['email'])){
                    header('location: admin.php');
                }
            } else {
                $fmsg = "User registration failed";
            }
        } else {
            $fmsg = "User registration failed";
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