<?php
    session_start();
    if(isset($_GET['logout'])){
        session_destroy();
        header('location: login.php');
    }

    if(!$_SESSION){
        ?>
            <script>
                document.addEventListener('DOMContentLoaded', function(){
                    document.getElementsByClassName('top-menu-contaner')[0].style.display = 'none';
                });
            </script>
        <?php
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <div class="main-contaner">
        <section class="top-menu-contaner">
            <div class="top-menu">
                <a href="index.php" class="topLink">HOME</a>
                <a href="admin.php" class="topLink">Admin Panel</a>
            </div>
            <div class="site-title"><h1>GENERATOR</h1></div>
            <a href="index.php?logout=true" class="logout">Log Out</a>
        </section>
        <header class="header">
            <div class="logo"></div>
        </header>
    </div>
    <script src="js/main.js"></script>
</body>
</html>