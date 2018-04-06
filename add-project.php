<?php
if (!isset($_SESSION['email'])){session_start();} // Session start
if(isset($_SESSION['email'])){ // if Session isset
    $email = $_SESSION['email'];
    $smsg = "User already logged in";
    if(isset($_POST) & !empty($_POST)){ // if $_POST isset and not empty
        $prjTitle = $_POST['project-title'];
        $prjFolder = 'users/'.$email.'/'.$prjTitle;
        if(!file_exists($prjFolder)){ // if file doesn't exist
            mkdir($prjFolder);
            $myfile = fopen($prjFolder.'/index.html', 'w');
            fwrite($myfile, 'test');
            fclose($myfile);
        }
        require('connect.php'); 
        $sql = "SELECT * FROM users_projects";
        $result = mysqli_query($conn, $sql);
        if($result == false) { // if table doesn't exist
            $sqlCreateTable = "CREATE TABLE users_projects (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user VARCHAR(30) NOT NULL,
                project VARCHAR(30) NOT NULL,
                reg_date TIMESTAMP
            )";
            if(mysqli_query($conn, $sqlCreateTable)){ // create table
                echo "Table users_projects created successfully";
            }
        } elseif($result == true) {
            echo "Table users_projects exists";
            // $sqlSelect = "SELECT * FROM users_project";
            // $resultSelect = mysqli_query($conn, $sqlSelect);
            // // $row = mysqli_fetch_array($resultSelect);
            if($resultSelect == false){
                $sqlInsert = "INSERT INTO users_projects(user, project) VALUE ('$email', '$prjTitle')";
                if(mysqli_query($conn, $sqlInsert)){
                    $sqlSelect = "SELECT * FROM users_projects";
                    mysqli_query($conn, $sqlSelect);
                    $resultSelect = mysqli_query($conn, $sqlSelect);
                    $row = mysqli_fetch_array($resultSelect);
                    echo 'Project add to data base';
                    echo '<pre>';
                    print_r($row);
                    $jsonFile = fopen('users/'.$email.'/projects.json', 'w');
                    fwrite($jsonFile, json_encode($row));
                    fclose($jsonFile);
                }
            } else {
                $sqlSelect = "SELECT * FROM users_projects";
                $resultSelect = mysqli_query($conn, $sqlSelect);
                if(mysqli_query($conn, $sqlSelect)){
                    if (mysqli_num_rows($resultSelect) > 0) {
                        $row = mysqli_fetch_array($resultSelect);
                        // echo '<pre>';
                        // print_r($row);
                        // var_dump($row);
                        // echo $row['project'];
                        foreach($row as $value){
                            if(!$row[$value] == $prjTitle){
                                $sqlInsert = "INSERT INTO users_projects(user, project) VALUE ('$email', '$prjTitle')";
                                if(mysqli_query($conn, $sqlInsert)){
                                    echo 'Project add to data base';
                                    $sqlSelect = "SELECT * FROM users_projects";
                                    $resultSelect = mysqli_query($conn, $sqlSelect);
                                    $row = mysqli_fetch_array($resultSelect);
                                    // if (mysqli_num_rows($resultSelect) > 0) {
                                    //     while($row = mysqli_fetch_array($resultSelect)) {
                                    //         $rowArray[] = $row;
                                    //     }
                                    //     foreach( $rowArray as $key => $val ){
                                    //         for($i = 0; $i <= 3; $i++){
                                    //             unset($rowArray[$key][$i]);
                                    //         }
                                    //     }
                                        echo '<br>new<br>';
                                        echo '<pre>';
                                        print_r($row);
                                        $jsonFile = fopen('users/'.$email.'/projects.json', 'w');
                                        fwrite($jsonFile, json_encode($row));
                                        fclose($jsonFile);
                                    // }
                                } else {
                                    echo 'Error: '.mysqli_error($conn);
                                }
                            } else {
                                echo 'The title exists';
                            }  
                        }
                    }
                }
            }
        }
        mysqli_close($conn);
    }
    unset($_POST['project-title']);
    // unset($row);
} else {
    header('location: login.php');
}
?>