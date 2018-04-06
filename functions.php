<?php
function createDirAndSession($conn, $email, $pwd, $repPwd){
    if($pwd === $repPwd) {
        $sql = "INSERT INTO users(email, pass) VALUE ('$email', '$pwd')";
        if(mysqli_query($conn, $sql)){
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
            // $sql = "SELECT * FROM users WHERE email='$email' AND pass='$pwd'";
            // $result = mysqli_query($conn, $sql);
            // $count = mysqli_num_rows($result);
            session_start();
            $_SESSION['email'] = $email;
            if(isset($_SESSION['email'])){
                header('location: admin.php');
            }
        } else {
            $fmsg = "User registration failed";
        }
    } else {
        $fmsg = "Password does not match";
    } 
}
?>