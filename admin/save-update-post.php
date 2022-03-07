<?php
    include "config.php";

    if(empty($_FILES['new-images']['name'])){
        $image_name = $_POST['old_image'];
    }
    else{
        $errors = array();
        
        $image_name = $_FILES['fileToUpload']['name'];
        $file_size = $_FILES['fileToUpload']['size'];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'];
        $file_type = $_FILES['fileToUpload']['type'];
        $file_ext =  strtolower(end(explode('.', $file_name)));
        $extensions = array("jpeg", "jpg", "png");

        // Check required file extensions
        if(in_array($file_ext, $extensions) === flase){
            $errors[] = "This extension file is not allowed, Please choose a JPG or PNG file";
        }

        // Check file size
        if($file_size > 2097152){
            $errors[] = "File size must be 2MB or lower than 2MB";
        }

        // if there is no error then upload file into database
        if(empty($errors) == true){
            move_uploaded_file($file_tmp, "upload/" . $file_name);
        }
        else{
            print_r($errors);
            die();
        }
    }

    $sql = "UPDATE post SET title = '{$_POST["post_title"]}',description='{$_POST["postdesc"]}', category='{$_POST["category"]}', post_img='{$image_name}' 
            WHERE post_id = {$_POST["post_id"]}";
            
    $update_sql = mysqli_query($conn, $sql) or die ("Query Failed");

    if($update_sql){
        header("Location: post.php");
    }

?>