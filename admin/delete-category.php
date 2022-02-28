<?php
    include "config.php";

    if($_SESSION["user_role"] ==  '0'){
        header("Location: post.php");
    }

    
?>