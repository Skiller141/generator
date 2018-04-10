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

function resizeImage($filename, $newcopy, $max_width, $max_height){
    list($orig_width, $orig_height, $image_type) = getimagesize($filename);
    $width = $orig_width;
    $height = $orig_height;
    if($width > $max_width){
        $width =($max_height / $height) * $width;
        $height = $max_height;
    }
    if($height > $max_height){
        $height =($max_width / $width) * $height;
        $width = $max_width;
    }
    switch ($image_type)
    {
        case 1: $src = imagecreatefromgif($filename); break;
        case 2: $src = imagecreatefromjpeg($filename);  break;
        case 3: $src = imagecreatefrompng($filename); break;
        default: return '';  break;
    }

    $image_p = imagecreatetruecolor($width, $height);
    imagecopyresampled($image_p, $src, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
    imagejpeg($image_p, $newcopy, 80);

    // return $image_p;
}

// $return = resizeImage($filename, $newcopy, $max_width, $max_height);
// echo $return;
?>