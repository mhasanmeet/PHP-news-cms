<?php
    include "config.php";

    $post_id = $_GET['id'];
    $cat_id = $_GET['catid'];

    // Image file unlink / delete from folder
    $img_file_delete = "SELECT * FROM post WHERE post_id= {$post_id}";
    $img_file_query = mysqli_query($conn, $img_file_delete) or die("Query Error");
    $fetch_sql = mysqli_fetch_assoc($img_file_query);

    unlink("upload/" . $fetch_sql['post_img']);
    
    // delete post
    $sql = "DELETE FROM post WHERE post_id = {$post_id};";
    $sql .= "UPDATE category SET post= post - 1 WHERE category_id = {$cat_id}";

    if(mysqli_multi_query($conn, $sql)){
        header("Location: post.php");
    }
    else{
        echo "Query Failed";
    }
?>