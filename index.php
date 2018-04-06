<?php
session_start();
$smsg = "User already logged in";
if(isset($_SESSION['email'])){
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/style.css">
        <title>Generator</title>
    </head>
    <body>
        <div class="top-menu-block">
            <?php if(isset($smsg)){?><div class="smsg"><?php echo $smsg;?></div><?php } ?>
            <h3>Landing page generator</h3>
            <label class="settings-link">
                <p>Settings</p>
                <input name="toggle" class="toggle" type="checkbox">
            </label>
        </div>
        <div class="main">
            <div class="logo">
                <!-- <h1>My logo</h1></div> -->
                <?php 
                    require_once('connect.php');
                    $sql = "SELECT url_img FROM logo_img";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<img src='uploads/". $row['url_img']. "'>" ;
                        }
                    } else {
                        echo "0 results";
                    }

                    mysqli_close($conn); 
                ?>
            </div>
        <div class="right-menu">
            <h3>Logo image</h3>
            <div id="out"></div>
            <form method="POST" enctype="multipart/form-data" action="upload-logo.php" id="upload-logo-form">
                <input type="file" name="logo-upload" id="logo-upload" accept="image/x-png,image/gif,image/jpeg">
                <input type="submit" value="Save">
            </form>
            <h3>Logo position</h3>
            <label for="logo-pos-left">Left</label>
            <input type="radio" name="logo-possition" id="logo-pos-left" class="logo-pos-radio">
            <label for="logo-pos-center">Center</label>
            <input type="radio" name="logo-possition" id="logo-pos-center" class="logo-pos-radio">
            <label for="logo-pos-right">Right</label>
            <input type="radio" name="logo-possition" id="logo-pos-right" class="logo-pos-radio">
        </div>
        <script src="js/main.js"></script>
    </body>
    </html>
<?php
} else {
    header('location: login.php');
}
?>