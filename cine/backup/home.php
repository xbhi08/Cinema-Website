<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>

   
    <style>
body ,html {
  height: 100%;
  margin: 0;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 25%;
  background-color: none;
  position: fixed;
  height: 100%;
  overflow: auto;
}

li a {
  display: block;
  color: white;
  padding: 8px 16px;
  text-decoration: none;
  font-size:30px;
}

li a.active {
  background-color: #04AA6D;
  color: white;
}

nav {
  background-color: grey;
  
}
li a:hover:not(.active) {
  background-color: #555;
  color: white;
}

#example1 {
  border: 2px solid black;
  padding: 25px;
  background: url(images/cinema.png);
  background-repeat: no-repeat;
  background-size: cover;
  
}
</style>
</head>

<body id="example1">

    <nav>
    
                <ul>
                <li><img src="images/logo.png" ></li>
                    <li><a href="adminlogin.php" title="Login">Login</a></li>
                      
                        <li><a href="adminregister.php" title="Register">Register</a></li>
                        <li><a href="insertShowsForm.php" title="Insert Shows">Insert Shows</a></li>
                        <li><a href="areview.php" title="Admin Review">Manage Comments</a></li>
                        <li><a href="" title="dac">Delete a customer</a></li>
                        <li><a href="alogout.php" title="Log Out">Log Out</a></li></li>
                        
                </ul>

</nav>       
   

   
</body>
   

</html>