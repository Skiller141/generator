<?php
session_start();
require_once('connect.php');
require_once('functions.php');
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
    /************************************* */
    $configArr = [];
    if(isset($_POST['submit'])){
        if(isset($_FILES['logo-img'])){
            $dir = 'uploads/';
            $check = getimagesize($_FILES['logo-img']['tmp_name']);
            if($check !== false){
                $filename = $dir . basename($_FILES['logo-img']['name']);
                $newcopy = explode(".", $filename);
                $newcopy[0] = $dir.'logo.';
                $newcopy = $newcopy[0] . $newcopy[1];
                
                if(move_uploaded_file($_FILES['logo-img']['tmp_name'], $filename)){
                    resizeImage($filename, $newcopy, 150, 150); //the function in functions.php
                    unlink($filename);
                    $configArr['site logo'] = $newcopy;
                }
            } else {
                $logoErr = '<span class="logoErr">The file is not image</span>';
            }
        }
    
        if(isset($_POST['project-title'])){
            $configArr['site title'] = $_POST['project-title'];
        }
        
        if(isset($_POST['switch_2'])){
            $configArr['switch_2'] = $_POST['switch_2'];
        }

        $myfile = fopen('config.json', 'w');
        fwrite($myfile, json_encode($configArr));
        fclose($myfile);

        // echo '<pre>';
        // print_r($_POST['switch_2']);
        // echo '</pre>';
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
            outputDirTitle();
            ?>
        </div>
        <a class="new-project-btn"></a>
    </div>
    <div class="content">
        <div class="prj-contaner">
            <div class="sett-contaner">
                <h1 class="main-title">Settings of <?php echo $_SESSION['project-title']; ?></h1>

                <form method="POST" action="" id="settings-form" enctype="multipart/form-data">
                    <h2 align="center">LOGO</h2>
                    <div class="switch-field">
                        <div class="switch-title">Logo image or text</div>
                        <input type="radio" id="switch_left" name="switch_2" value="yes"/>
                        <label for="switch_left">Logo image</label>
                        <input type="radio" id="switch_right" name="switch_2" value="no" />
                        <label for="switch_right">Logo text</label>
                    </div>
                    <div class="add-logo-field">
                        <label for='logo-img'>Logo</label><br>
                        <input type="file" id="logo-img" name="logo-img"><?php if(isset($logoErr)){echo $logoErr;} ?><br>
                    </div>
                    <div class="add-text-field">
                        <label for="project-title">Project title</label><br>
                        <input type="text" name="project-title" id="project-title"><br>
                    </div>
                    <hr style="margin: 20px 0;">
                    <input type="submit" value="Save" name="submit">
                </form>
                <a href="admin.php?createZip=true">Download ZIP</a>
                <a href="admin.php?removePrj=true">Remove project</a>
            </div>
       </div>
    </div> 
    <div class="mask"></div>
    <div class="close"></div>
    <div class="new-project-popup">
        <h2>New project</h2>
        <form id="add-project">
            <label for="project-title">Project title</label>
            <input type="text" name="add-project-title" id="add-project-title">
            <input type="submit" value="Add project">
        </form>
    </div>
    <div class="prj-error-popup">Project with this title exists</div>
</div>
<script src="js/admin.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.forms['add-project'].addEventListener('submit', function(e) {
            var prjErrorPopup = document.getElementsByClassName('prj-error-popup')[0];
            var countDir = "<?php echo $_SESSION['count-dir-before']; ?>";
            var prjTitleVal = this['add-project-title'].value;
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
    });
</script>
</body>
</html>
