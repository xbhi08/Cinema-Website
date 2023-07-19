<?php
session_start();

//Make sure the user is logged in first to be able to submit a review
if(!isset($_SESSION['username']))
{
  header("Location: home.php?referer=areview");
}
?>
<html>
 <head>
   <?php require_once "includes/metatags.php"?>
   <title>Review</title>
   <!--References
	https://www.w3schools.com/php/php_mysql_insert.asp
-->
<style>

div h3 {
color:purple;
text-transform:uppercase;
}

.error {color: #FF0000;}

  </style>
  <link rel="stylesheet" href="css/mystyle.css">
 </head>
 <body>
<?php  
// define variables and set to empty string values


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once "includes/db_connect.php";
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $review_id = "";
  $banned="";
  foreach($_POST as $key => $value) {
    if (strpos($key, 'rdo_review_id_')>=0) {
       $review_id = substr($key, 14);
       #echo $review_id;
       #echo $value;
       
       if($value == "Ban")
       {
       	$banned = 1;
       }
       if($value == "Accept")
       {
       	$banned = 0;
       }
       $sUpdate = "UPDATE reviews SET flagged = 0, banned= $banned WHERE reviewID=$review_id";
       
       #echo $sUpdate;
       $updateResult = $conn->exec($sUpdate) ;
       if($updateResult)
       {
    	$Msg = "Record Updated!";
    	#echo $Msg;
       }else{
         $Msg = "ERROR: Record could not be updated!";
    	#   echo $Msg;
    
    	}//end else ($updateResult)
    }//end if(strpos($key, 'chk_review_id_')>=0)
  }//end foreach
   	
  $conn==null;    

}//end if ($_SERVER["REQUEST_METHOD"] == "POST")


  
?>
  <?php 
   $activemenu = "review"; 
   //include_once('home.php');
  ?>
   
  <div style="margin-left:15%;padding:1px 16px;height:1000px;">
  <?php
   require_once "includes/db_connect.php";
   $sQuery = "SELECT * FROM reviews WHERE flagged = 1" ; 
   #echo $sQuery;
   $Result = $conn->query($sQuery) ;
   $numrows = $Result->rowCount();
   #echo $numrows;
   if ($numrows ==0)
   {
   	echo "<h3 style='color:red'>There are no reviews that have been flagged!!!!!</h3>";
   }//end if
   else
   {
	
   ?>
  
  <h3 >Please Moderate the following reviews</h3>
<p><span class="error">* required field</span></p>  
<p>
<!--
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
-->   
   
   
   <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>"  >
     <fieldset>
      <legend>Review Details:</legend>
	  <?php
	  echo "<table><tr><th>Comment</th><th>Accept</th><th>Ban</th><tr/>";
	  while($row = $Result->fetch(PDO::FETCH_ASSOC) )
	  {
	  	echo "<tr>";
	  	echo "<td>" . $row['comment']. "</td>";
	  	echo "<td><input type = radio name=rdo_review_id_" . $row['reviewID']. " value='Accept'> </td>";
	  	echo "<td><input type = radio name=rdo_review_id_" . $row['reviewID']. " value='Ban'></td>";
	  	echo "</tr>";
	  	
	  }//end while
	  echo "</table>";
	  
	  ?>
     </fieldset>
	
	<input type="submit"/> 
	<input type="reset"/>


   </form>
   <?php
   
   }//end else if ($numrows ==0) ?>
  </p>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" )
{
 echo "<h3 >$Msg</h3>";
 
}//end if
  

?>
  </div>

 </body>
</html>