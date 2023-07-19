<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();

// define variables and set to empty string values

$usernameErr = $passwordErr ="";
$username = $userpassword= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["txt_username"])) {
    $usernameErr = "User Name is required";
  } else {
     $username = $_POST["txt_username"];
  }//end else
  if (empty($_POST["txt_password"])) {
    $passwordErr = "Password is required";
  } else {
    $userpassword = $_POST["txt_password"];
  }//end else
  
  if($usernameErr == "" && $passwordErr == "" )
  {
  	
   //We hashed passwords using   
    //$hashed_password = password_hash($password,PASSWORD_DEFAULT);
  	//References http://php.net/manual/en/function.password-verify.php
  	require_once "includes/db_connect.php";
  	$sQuery = "SELECT * FROM admin WHERE username = '$username'  ";
  	
  	#echo $sQuery;
  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $Result = $conn->query($sQuery) ;
    $userResults = $Result->fetch(PDO::FETCH_ASSOC);
    if($userResults['username'] )//the user exists
    {	
    	$hashed_password = $userResults['password'];
    	if(password_verify($userpassword,$hashed_password))
    	{
    		$_SESSION['username'] = $userResults['username'];
    		$_SESSION['admin'] = true;
    		echo $Msg ="success";
    		echo 	$_SESSION['username'];
    		header("Location: ../cine/home.php?signup=success");  
    	}
    	else
    	{
    		$Msg = "ERROR: Your credentials seem to be wrong. Try again or make sure you are a registered user!";
       		echo $Msg;
    	}
    	
    }else{
       $Msg = "ERROR: Your credentials seem to be wrong. Try again or make sure you are a registered user!";
       echo $Msg;
    	
    }
  }//end if
 
 }//end else 
    

?>
<html>
 <head>
 <?php require_once "includes/metatags.php"?>
   <title>log in</title>
   
<style>
  
  </style>
  <link rel="stylesheet" href="css/admin.css">
 </head>
 <body>
  <!-- Reference https://www.w3schools.com/css/css_navbar.asp-->
  
  <?php 
   $activemenu = "login"; 
   //include_once('includes/adminmenu.php');
   //include_once('insertShowsForm.php');
  ?>
  <div style="margin-left:15%;padding:1px 16px;height:1000px;">
  <?php
  if(isset($_SESSION['login']))
  { 
    echo "<h3 style=\"color:red\">You are already logged in</h3>";
    
  }//end if
  else
  {	  
  ?>
  
  <h2>Login Page</h2><br>    
    <div class="login">    
    <form id="login" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">    
        <label><b>User Name     
        </b>    
        </label>    
        <input type="text" name="txt_username" id="username" placeholder="Enter Username">    
        <br><br>    
        <label><b>Password     
        </b>    
        </label>    
        <input type="Password" name="txt_password" id="password" placeholder="Enter Password">    
        <br><br>    
        <input type="submit" name="log" id="log" value="Log In Here">       
        <br><br>     
    </form>     
  <?php
  }//end else

  ?>
  
  </div>
 </body>
</html>