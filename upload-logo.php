<?php
$dir = './uploads/';
$filename = basename($dir.$_FILES['logo-upload']['name']);
$tmpname = $_FILES['logo-upload']['tmp_name'];
if(move_uploaded_file($tmpname, $dir.$filename)){
    require_once('connect.php');
    $sql = "INSERT INTO logo_img (url_img) VALUE ('$filename')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

mysqli_close($conn);
    // echo '<img src="uploads/'.$filename.'" width="200px" height="200px">';
    echo '<div />';
} else {
    echo "false";
}
?>