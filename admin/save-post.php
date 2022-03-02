<?php
    include "config.php";

    // Code for the file
    if(isset($_FILES['fileToUpload'])){
        
        $errors = array();
        
        $file_name = $_FILES['fileToUpload']['name'];
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

    session_start();
    $title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $description = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $date = date("d M, Y");
    $author = $_SESSION['user_id'];

    // Insert into Database SQL
    $sql = "INSERT INTO post(title, description, category, post_date, author, post_img)
                    VALUES ('{$title}', '{$description}', '{$category}', '{$date}', '{$author}', '{$file_name}');";
    
    // Update category SQL
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";

    // If there have same SQL name then need to usel mysql multiquery method
    if (mysqli_multi_query($conn, $sql)){
        header("Location: post.php");
    }
    else{
        echo "<div class='alert alert-danger'>Query Failed</div>";
    }

?>