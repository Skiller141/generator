<?php
session_start();
require_once('connect.php');
if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    $prjTitle = $_SESSION['project-title'];
    $smsg = "User already logged in as ".$email;
    // echo '<pre>';
    // print_r($_SESSION);
    
    // $sql = "SELECT * FROM users_projects";
    // $result = mysqli_query($conn, $sql);
    // if (mysqli_num_rows($result) > 0) {
    //     while($row = mysqli_fetch_array($result)) {
    //         $rowArray[] = $row;
    //     }
    // }
    function logOut() {
        session_destroy();
        header('location: login.php');
    }
    if(isset($_GET['logout'])){
        logOut();
    }

    if(isset($_GET['project'])){
        // unset_session($_SESSION['project-title']);
        $_SESSION['project-title'] = $_GET['project'];
        // echo $_SESSION['project-title'];
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                document.getElementsByClassName('prj-contaner')[0].style.display = 'block';
            });
        </script>
        <?php
    }

    $countFoldersBefore = count(glob("users/$email/*", GLOB_ONLYDIR));
    if(!glob("users/$email/*", GLOB_ONLYDIR)){
        $countFolders = 0;
    }
    
    $prjName = [];
    if(isset($_SESSION['count-dir-before'])){
        $_SESSION['count-dir-before'] = $countFoldersBefore;
        $prjExistsDir = glob("users/$email/*", GLOB_ONLYDIR);
        foreach($prjExistsDir as $key => $value) {
            $prjName[] = str_replace("users/$email/", "", $value);
        }
        $JSONprjName = $prjName;
    }
    
} else {
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/admin.css">
    <title>Admin panel</title>
</head>
<body>
    <div class="main-contaner">
        <?php if(isset($smsg)){?><div class="logged-in"><?php echo $smsg; ?></div><?php } ?>
        <div class="main-menu">
            <ul class="main-menu-list">
                <a href="index.php"><li class="items item-1">Перейти на сайт</li></a>
                <a href="admin.php?logout=true"><li class="items item-5">Log out</li></a>
            </ul>
            <div class="active-projects">
                <?php
                $prjExistsDir = glob("users/$email/*", GLOB_ONLYDIR);
                foreach($prjExistsDir as $key => $value) {
                    $prjName = str_replace("users/$email/", "", $value);
                    echo "<a href='admin.php?project=$prjName' class='new_prj new_prj-$key'>$prjName</a>";
                }
                ?>
            </div>
            <a class="new-project-btn"></a>
        </div>
        <div class="content">
           <div class="prj-contaner"><?php require('settings.php') ?></div>
        </div> 
        <div class="mask"></div>
        <div class="close"></div>
        <div class="new-project-pupup">
            <h2>New project</h2>
            <form id="add-project">
                <label for="project-title">Project title</label>
                <input type="text" name="project-title" id="project-title">
                <input type="submit" value="Add project">
            </form>
        </div>
    </div>
    <script src="js/admin.js"></script>
    <script>
        document.forms['add-project'].addEventListener('submit', function(e) {
            var countDir = "<?php echo $_SESSION['count-dir-before']; ?>";
            var prjTitleVal = this['project-title'].value;
            if(countDir >= 5) {
                e.preventDefault();
                alert('Maximum 5 projects');
            } else {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'add-project2.php?project-title=' + prjTitleVal);
                xhr.send();  
            }
            newPrjPupup.style.display = 'none';
            mask.style.display = 'none';
            close.style.display = 'none';
            
            var prjNameArr = <?php echo json_encode($JSONprjName); ?>;
            for(var i = 0; i < prjNameArr.length; i++) {
                if(prjNameArr[i] === prjTitleVal) {
                    e.preventDefault();
                    alert('Project with this title exists');
                }
            }
        });
    </script>
</body>
</html>