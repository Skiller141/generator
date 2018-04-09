<?php 
    if(isset($_POST['project-title'])){
        $configArr = ['site title' => $_POST['project-title']];
        // echo '<pre>';
        // print_r($configArr);
        $myfile = fopen('config.json', 'w');
        fwrite($myfile, json_encode($configArr));
        fclose($myfile);
    }

    if(isset($_POST['logo-img'])){
        $logo = "uploads/" . basename($_FILES['logo-img']['name']);
        echo $logo;
        if(move_uploaded_file($_FILES['logo-img']['tmp_name'], $logo)){
            echo "ok";
        }
        echo '<pre>';
        print_r($_FILES);
        print_r($_POST);
    }
?>
<div class="sett-contaner">
    <h1 class="main-title">Settings of <?php echo $_SESSION['project-title']; ?></h1>

    <form method="POST" action="" id="settings-form" enctype="multipart/form-data">
        <label for="project-title">Project title</label><br>
        <input type="text" name="project-title" id="project-title"><br>
        <label for='logo-img'>Logo</label><br>
        <input type="file" id="logo-img" name="logo-img"><br>
        <input type="submit" value="Save">
    </form>
    <a href="admin.php?createZip=true">Download ZIP</a>
    <a href="admin.php?removePrj=true">Remove project</a>
</div>
<script>
    // document.addEventListener('DOMContentLoaded', function(){
    //     document.forms['settings-form'].addEventListener('submit', function(){
    //         var siteTitle = this['project-title'].value;
    //         var xhr = new XMLHttpRequest()
    //         // var data = 'project-title=' + siteTitle;
    //         xhr.open(this.method, this.action);
    //         xhr.send(siteTitle);
    //     });
    // });
</script>
