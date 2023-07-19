<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();

// define variables and set to empty string values

$custNameErr=$usernameErr = $passwordErr =$dobErr= $addressErr=$genderErr=$emailErr ="";
$custName=$username = $userpassword =$dob=$address = $gender=$email= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["txt_dob"])) {
    $dobErr = "Date of birth is required";
  } else {
    $dob = $_POST["txt_dob"];
  }//end else
  if (empty($_POST["txt_address"])) {
    $addressErr = "address is required";
  } else {
    $address = $_POST["txt_address"];
  }//end else
  if (empty($_POST["txt_gender"])) {
    $gender = "gender is required";
  } else {
    $gender = $_POST["txt_gender"];
  }//end else
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
  if (empty($_POST["txt_email"])) {
    $emailErr = "email is required";
  } else {
    $email = $_POST["txt_email"];
  }//end else
  if (empty($_POST["txt_custName"])) {
    $custNameErr = "Your name is required";
  } else {
    $custName = $_POST["txt_custName"];
  }//end else
  if( $custNameErr== "" && $usernameErr == "" && $passwordErr == ""  &&$dobErr== "" &&$addressErr == "" && $genderErr==  "" &&$emailErr== "" )
  {
  	
    $hashed_password = password_hash($userpassword,PASSWORD_DEFAULT);
  	require_once "includes/db_connect.php";
  	$sInsert = "INSERT INTO customer  (customerID,username,custName,password,gender,address,email,dateOfBirth) VALUES( '','$username' ,'$custName', '$hashed_password','$gender','$address','$email','$dob') ";
  	#echo $sQuery;
  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $Result = $conn->exec($sInsert) ;
   
    if($Result )
    {	
    	$Msg = "!Success";
	    echo $Msg;
      header("Location: ../cineCust/home.php?signup=success");  
    }else{
       $Msg = "ERROR: Your credentials could not be saved!";
       echo $Msg;
    	
    }
    $conn==null;
  }//end if
  
 }//end else 
  

?>
<html>
 <head>
 <?php require_once "includes/metatags.php"?>
   <title>Register</title>
   
<style>
  
  </style>
  <link rel="stylesheet" href="css/mystyle.css">
 </head>
 <body>
  <!-- Reference https://www.w3schools.com/css/css_navbar.asp-->
  
  <?php 
   $activemenu = "Register"; 
   //include_once('includes/adminmenu.php');
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
  
  <h3 style="color:red">Please register</h3>
  <p>
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>"  >
     <fieldset>
      <legend>Login Details:</legend>
    Enter your Name : <br/>
	<input type="text" name="txt_custName" maxlength="200" size="50" value="<?php echo $custName;?>"/>
	<span class="error">* <?php echo $custNameErr;?></span><br/><br/> 

	User Name : <br/>
	<input type="text" name="txt_username" maxlength="30" size="50" value="<?php echo $username;?>"/>
	<span class="error">* <?php echo $usernameErr;?></span><br/><br/> 
	Password : <br/>
	<input type="password" name="txt_password" maxlength="30" size="50" value="<?php echo $userpassword ;?>"/>
	<span class="error">* <?php echo $passwordErr;?></span><br/><br/> 
    gender : <br/>
	<input type="radio" name="txt_gender" value="male" <?php if($gender=="male")
	{echo "checked";}
	
	?>/> Male
  	<input type="radio" name="txt_gender" value="female" <?php if($gender=="female")
	{echo "checked";}
	
	?> /> Female
  	<input type="radio" name="txt_gender" value="other" <?php if($gender=="other")
	{echo "checked";}
	
	?> /> Other 
	<span class="error">* <?php echo $genderErr;?></span><br/><br/> 
    Address : <br/>
	<input type="text" name="txt_address" maxlength="300" size="50" value ="<?php echo $address;?>"/>
	<span class="error">* <?php echo $addressErr;?></span><br/><br/> 
    email : <br/>
	<input type="email" name="txt_email" maxlength="300" size="50" value="<?php echo $email;?>"/>
	<span class="error">* <?php echo $emailErr;?></span><br/><br/> 
    Date of birth : <br/>
	<input type="date" name="txt_dob" size="50" value ="<?php echo $dob;?>"/>
	<span class="error">* <?php echo $dobErr;?></span><br/><br/> 

  <input type="reset"/>
	<input type="submit"/> 
	</fieldset>
  </form>
  </p>
  <?php
  }//end else
 
{
 
}//end if
  
  ?>
  
  </div>
 </body>
</html>