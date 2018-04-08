<?php
function createDirAndSession(){
    global $conn;
    global $email;
    global $pwd;
    global $repPwd;
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

function outputDirTitle(){
    global $email;
    $prjExistsDir = glob("users/$email/*", GLOB_ONLYDIR);
    foreach($prjExistsDir as $key => $value) {
        $prjName = basename($value);
        echo "<a href='admin.php?project=$prjName' class='new_prj new_prj-$key'>$prjName</a>";
    }
}
?>