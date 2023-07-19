<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();

// define variables and set to empty string values

$usernameErr = $passwordErr =$dobErr= $addressErr=$genderErr=$emailErr ="";
$username = $userpassword =$dob=$address= $gender=$email= "";

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
    $address = $_POST["txt_gender"];
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
  if($usernameErr == "" && $passwordErr == ""  &&$dobErr== "" &&$addressErr == "" && $genderErr==  "" &&$emailErr== ""  )
  {
  	
    $hashed_password = password_hash($userpassword,PASSWORD_DEFAULT);
  	require_once "includes/db_connect.php";
  	$sInsert = "INSERT INTO admin  (adminID,username,password,gender,address,email,dateOfBirth) VALUES( '','$username' , '$hashed_password','$gender','$address','$email','$dob') ";
  	#echo $sQuery;
  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $Result = $conn->exec($sInsert) ;
   
    if($Result )
    {	
    	$Msg = "!Success";
	    echo $Msg;
      header("Location: ../cine/home.php?signup=success");  
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
  body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: orange;
}

* {
  box-sizing: none;
}

/* Add padding to containers */
.container {
  width: 500px;  
  padding: 16px;
  background-color: white;
  color: orange;
  border-radius: 15px; 
  margin: auto;
  margin: 20 0 0 350px;
}

/* Full-width input fields */
input[type=text], input[type=password],input[type=email] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: white;
  border-radius: 15px;  
}

input[type=text]:focus,input[type=email] , input[type=password]:focus {
  background-color: white;
  outline: none;
  
  border-radius: 15px;  
}

/* Overwrite default styles of hr */
hr {
 
  margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: orange;
  color: white;
  padding: 16px ;
  margin: 8px ;
  border: none;
  cursor: pointer;
  width: 45%;
  opacity: 0.9;
  border-radius: 15px; 
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}
.center{
  margin: 20 0 0 540px; 
    color: white;  
    padding: 20px; 
}
/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
  </style>
  

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript">

<script type="text/javascript">
<script>
$(document).ready(function(){

 $("#txt_username").keyup(function(){

    var username = $(this).val().trim();

    if(username != ''){

       $.ajax({
          url: 'AjaxFile.php',
          type: 'post',
          data: {username: username},
          success: function(response){

              $('#uname_response').html(response);
             
           }
       });
    }else{
       $("#uname_response").html("");
      
    }

  });

});
</script>

  
<script>
$(document).ready(function(){
//The onkeyup event occurs when the user releases a key 
   $("#txt_username").keyup(function(){

      var username = $(this).val().trim();

      if(username != ''){

         $.ajax({
            url: 'AjaxFile.php',
            type: 'post',
            data: {username: username},
            success: function(response){

                $('#uname_response').html(response);
                
             }
         });
      }else{
         $("#uname_response").html("");
         
      }

    });

 });
</script>


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
  
  <h3 style="color:white" class="center">Register</h3>
  <p>
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>"  >
  <div class="container">
     
      
	Username : <br/>
	<input type="text" placeholder="Enter Username" name="txt_username" maxlength="30" size="50" value="<?php echo $username;?>"/>
	<span class="error">* <?php echo $usernameErr;?></span><br/><br/> 
	Password : <br/>
	<input type="password" placeholder="Enter Password" name="txt_password" maxlength="30" size="50" value="<?php echo $userpassword ;?>"/>
	<span class="error">* <?php echo $passwordErr;?></span><br/><br/> 
  Email : <br/>
	<input type="email" placeholder="Enter Email" name="txt_email" maxlength="300" size="50" value="<?php echo $email;?>"/>
	<span class="error">* <?php echo $emailErr;?></span><br/><br/>

  Gender : <br/>
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
	<input type="text" placeholder="Enter address" name="txt_address" maxlength="300" size="50" value ="<?php echo $address;?>"/>
	<span class="error">* <?php echo $addressErr;?></span><br/><br/> 
    
  Date of birth : <br/>
	<input type="date" placeholder="Enter date of birth" name="txt_dob" size="50" value ="<?php echo $dob;?>"/>
	<span class="error">* <?php echo $dobErr;?></span><br/><br/> 

  <input type="reset" name="rst" id="rst" class="registerbtn" value="Clear"/>
	<input type="submit" name="reg" id="reg" class="registerbtn" value="Sign Up"/> 
	
  </div>
  </form>
  </p>
  <?php
  }//end else
  if ($_SERVER["REQUEST_METHOD"] == "POST" )
{
 
}//end if
  
  ?>
  
  </div>
 </body>
</html>