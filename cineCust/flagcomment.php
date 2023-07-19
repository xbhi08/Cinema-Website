<?php
    session_start();

     if (isset($_POST['review_id'])){
        //echo "$_POST['review_id']";
        //echo 'success';
        require_once "includes/db_connect.php";

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE reviews r
        SET r.flagged = 1
        WHERE  r.reviewID =".$_POST['review_id'].";";


        $stmt=$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stmt->execute();
        $conn==null;
        die('success');
    }
    else{
        //echo 'failure';
        die('failure');
    }
?>