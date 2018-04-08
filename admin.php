<?php
session_start();
require_once('connect.php');
if(isset($_SESSION)){
    $email = $_SESSION['email'];
    // $prjTitle = $_SESSION['project-title'];
    $smsg = "User already logged in as ".$email;
   
    if(isset($_GET['logout'])){
        session_destroy();
        header('location: login.php');
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
    $_SESSION['count-dir-before'] = $countFoldersBefore;
    $prjName = [];
    $JSONprjName = [];
    if(isset($_SESSION['count-dir-before'])){
        $prjExistsDir = glob("users/$email/*", GLOB_ONLYDIR);
        foreach($prjExistsDir as $key => $value) {
            // $prjName[] = str_replace("users/$email/", "", $value);
            $prjName[] = basename($value);
        }
        $JSONprjName = $prjName;
    }

    if(isset($_GET['createZip'])){
        $zip = new ZipArchive;
        $prjTitle = $_SESSION['project-title'];
        $download = "users/$email/$prjTitle/$prjTitle.zip";
        $zip->open($download, ZipArchive::CREATE);
        foreach (glob("users/$email/$prjTitle/*") as $file) {
            $zip->addFile(basename($file));
        }
        $zip->close();
        if(file_exists($download)){
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($download).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($download));
            flush(); // Flush system output buffer
            readfile($download);
            unlink($download);
            exit;
        }
    }

    if(isset($_GET['removePrj'])){
        $prjTitle = $_SESSION['project-title'];

        $dir = "users/$email/$prjTitle";
        function rmrf($dir){
            foreach (glob($dir) as $file) {
                if (is_dir($file)) {
                    rmrf("$file/*");
                    rmdir($file);
                } else {
                    unlink($file);
                }
            }
        }
        rmrf($dir);

        $_SESSION['count-dir-before']--;
        if($key = array_search($prjTitle, $JSONprjName) !== false){
            unset($JSONprjName[$key]);
        }
        unset($_SESSION['project-title']);
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
                    $prjName = basename($value);
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
        <div class="new-project-popup">
            <h2>New project</h2>
            <form id="add-project">
                <label for="project-title">Project title</label>
                <input type="text" name="project-title" id="project-title">
                <input type="submit" value="Add project">
            </form>
        </div>
        <div class="prj-error-popup">Project with this title exists</div>
    </div>
    <script src="js/admin.js"></script>
    <script>
        document.forms['add-project'].addEventListener('submit', function(e) {
            var prjErrorPopup = document.getElementsByClassName('prj-error-popup')[0];
            var countDir = "<?php echo $_SESSION['count-dir-before']; ?>";
            var prjTitleVal = this['project-title'].value;
            if(countDir > 4) {
                alert('Maximum 5 projects');
            } else {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'add-project.php?project-title=' + prjTitleVal);
                xhr.send();  
            }
            newPrjPopup.style.display = 'none';
            mask.style.display = 'none';
            close.style.display = 'none';
            
            var prjNameArr = <?php echo json_encode($JSONprjName); ?>;
            for(var i = 0; i < prjNameArr.length; i++) {
                if(prjNameArr[i] === prjTitleVal) {
                    prjErrorPopup.style.display = 'block';
                    mask.style.display = 'block';
                    close.style.display = 'block';
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>
