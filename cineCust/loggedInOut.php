<?php
    session_start();

     if (isset($_SESSION['username'])){
        //echo 'success';
        die('success');
    }
    else{
        //echo 'failure';
        die('failure');
    }
?>