<?php
    include "config.php";

    $userid = $_GET['id'];

    $delete_query = "DELETE FROM user WHERE user_id = {$userid}";

    if(mysqli_query($conn, $delete_query)){
        header("Location: users.php");
    }
    else{
        echo "<p>Can not Delete Query</p>";
    }

    mysqli_close($conn);

?>