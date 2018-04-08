<div class="sett-contaner">
    <h1 class="main-title">Settings of <?php echo $_SESSION['project-title']; ?></h1>

    <form action="" method="POST">
        <label for="site-title">Site title</label>
        <input type="text" name="site-title" id="site-title">
        <input type="submit" value="Save">
    </form>
    <a href="admin.php?createZip=true">Download ZIP</a>
    <a href="admin.php?removePrj=true">Remove project</a>
</div>
