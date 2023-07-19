<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();
session_destroy();
?>
<html>
<head>
 <?php require_once "includes/metatags.php"?>
<style>
    body{color:white;}
    #example1 {
  
  padding: 25px;
  background: url(images/myers.png);
  background-repeat: no-repeat;
  background-size: cover;
  
}
    </style>
</head>
<body id="example1">
You are sucessfully logged out !! <a href='adminlogin.php'>Click here to log in </a>
</body>
</html>