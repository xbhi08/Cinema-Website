<?php
session_start();
?>
<?php
if(!isset($_SESSION['username']))
{
  header("Location: home.php?referer=areview");
}
?>
<DOCTYPE! HTML5>
    <html>
 <head>
   <title>Insert Shows</title>
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
  margin: 20 0 0 520px; 
    color: white;  
    padding: 20px; 
}
/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}

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

// define variables and set to empty values
$trailer_urlErr=$castErr=$prod_teamErr=$directorErr=$release_dateErr=$countryErr=$imdbErr=$qualityErr=$show_descErr=$show_urlErr=$show_yearErr=$sdateErr=$durationErr= $nameErr = $genreErr = $edateErr =$roomErr=$childErr= $adultErr=$languageErr="";
$username=$trailer_url=$cast=$prod_team=$director=$release_date=$country=$imdb=$quality=$show_desc=$show_url=$show_year=$sdate=$duration= $name= $genre= $edate =$room=$child=$adult= $language="";

if ($_SERVER["REQUEST_METHOD"] == "POST") { //check if the page is being invoked after form data has been submitted
  if (empty($_POST["txt_name"])) {//check if the field is empty
    $nameErr = "The name of the movie is required";
  } else {
    $name = test_input($_POST["txt_name"]);//call the test_input function on $_POST["txt_name"]
    }//end if

  
  if (empty($_POST["txt_genre"])) {
    $genreErr= "A movie genre is required";
  } else {
   $genre= test_input($_POST["txt_genre"]);
  }//end else
    
  if (empty($_POST["txt_language"])) {
    $languageErr= "A language for the movie is required";
  } else {
   $language= test_input($_POST["txt_language"]);
  }//end else

  if (empty($_POST["txt_duration"])) {
    $durationErr = "A duration for the movie is required";
  } else {
    $duration =$_POST["txt_duration"];
  }
 
  if (empty($_POST["txt_sdate"])) {
    $sdateErr = "A start date for the movie is required";
  } else {
    $sdate =$_POST["txt_sdate"];
  }

  if (empty($_POST["txt_edate"])) {
    $edateErr = "An end date for the movie is required";
  } else {
    $edate =$_POST["txt_edate"];
  }
  if (empty($_POST["txt_imdb"])) {
    $imdbErr = "An imdb rating for the movie is required";
  } else {
    $imdb =$_POST["txt_imdb"];
  }
  if (empty($_POST["txt_quality"])) {
    $qualityErr = "A quality for the movie is required";
  } else {
    $quality =$_POST["txt_quality"];
  }
  if (empty($_POST["txt_show_desc"])) {
    $show_descErr = "A show description for the movie is required";
  } else {
    $show_desc =$_POST["txt_show_desc"];
  }
  if (empty($_POST["txt_show_url"])) {
    $show_urlErr = "A show url for the movie is required";
  } else {
    $show_url =$_POST["txt_show_url"];
  }
  if (empty($_POST["txt_show_year"])) {
    $show_yearErr = "A show year for the movie is required";
  } else {
    $show_year =$_POST["txt_show_year"];
  }
  if (empty($_POST["txt_country"])) {
    $countryErr = "The country where the movie was made is required";
  } else {
    $country =$_POST["txt_country"];
  } 
  if (empty($_POST["txt_release_date"])) {
    $release_dateErr = "The release date of the movie is required";
  } else {
    $release_date =$_POST["txt_release_date"];
  } 
  if (empty($_POST["txt_director"])) {
    $directorErr = "The director of the movie is required";
  } else {
    $director =$_POST["txt_director"];
  } 
  if (empty($_POST["txt_prod_team"])) {
    $prod_teamErr = "The production team of the movie is required";
  } else {
    $prod_team =$_POST["txt_prod_team"];
  } 
  if (empty($_POST["txt_cast"])) {
    $castErr = "The cast of the movie is required";
  } else {
  $cast =$_POST["txt_cast"];
  } 
  if (empty($_POST["txt_trailer_url"])) {
    $trailer_urlErr = "The cast of the movie is required";
  } else {
  $trailer_url =$_POST["txt_trailer_url"];
  } 
  if (empty($_POST["txt_room"])) {
    $roomErr = "The room of the movie is required";
  } else {
  $room =$_POST["txt_room"];
  } 
  if (empty($_POST["txt_child"])) {
    $childErr = "The price of a child for the movie is required";
  } else {
  $child =$_POST["txt_child"];
  } 
  if (empty($_POST["txt_adult"])) {
    $adultErr = "The price of an adult for the movie is required";
  } else {
  $adult =$_POST["txt_adult"];
  } 

  echo  $_SESSION['username'] ;
  require_once "includes/db_connect.php"; 
   $sQuery = "SELECT adminID FROM admin WHERE username ='" . $_SESSION['username'] . "'";
        
    echo $sQuery;
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $Result = $conn->query($sQuery) ;
    if($Result )
    {	
      $Msg = "Record retrieved!";
      echo $Msg;
    }else{
       $Msg = "ERROR: Record could not be Saved!";
       echo $Msg;
       //header("Location: ../cine/home.php?signup=success"); 
    }
    
         //$conn = null;
  if($imdbErr=="" && $trailer_urlErr=="" && $castErr=="" && $prod_teamErr==""&&$directorErr==""&&$release_dateErr==""&&$countryErr=="" && $qualityErr=="" && $show_urlErr=="" && $show_yearErr=="" && $sdateErr=="" && $durationErr=="" && $nameErr =="" && $genreErr =="" && $edateErr =="" && $show_descErr =="")
      {
        
  
        
        $userResults = $Result->fetch();
  //echo $userResults['adminID'];
  
        //$conn=null;
        $sInsert = "INSERT INTO shows (adminID,showID,duration,show_name,show_genre,language,country,release_date,director,production_team,cast,start_date,end_date,imdb_rating,quality,show_desc,show_url,trailer_url,show_year)
           VALUES('".$userResults['adminID']."','','$duration','$name','$genre','$language','$country','$release_date','$director','$prod_team','$cast','$sdate','$edate',$imdb,'$quality','$show_desc','$show_url','$trailer_url','$show_year')";
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo $sInsert;
    $addResult = $conn->exec($sInsert) ;
  
    if($addResult )
    {	
      $Msg = "Record inserted!";
      echo $Msg;
      
    }else{
       $Msg = "ERROR: Record could not be Saved!";
       echo $Msg;
    }
      
      }
 //movie table insertion     
      
      $sQuery = "SELECT showID FROM shows WHERE show_name ='$name'";
      echo $sQuery;
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $Result1 = $conn->query($sQuery) ;
    $row = $Result1->fetch();
      if($edate>=date("Y-m-d"))
      {

     $sInsert= "INSERT INTO movies (adminID,showID,room_no,child_price,adult_price,seatsRemainingNight,seatsRemainingDay)
      VALUES('".$userResults['adminID']."','".$row['showID']."','$room','$child','$adult',100,100)";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo $sInsert;
$addResult1 = $conn->exec($sInsert) ;
      }
header("Location: ../cine/home.php?insertion=success");
}

function test_input($data) {
  //The trim() function in PHP removes whitespace or any other predefined character from both the left and right sides   a string.
  //The striplashes function removes backslashes in a string.
  //htmlspecialchars() function convert the special characters to HTML entities whereas htmlentities() function convert all applicable characters to HTML entities.
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
  <?php 
   $activemenu = "insertShowsForm"; 
   //include('adminlogin.php');
  ?>
   
  <div style="margin-left:15%;padding:1px 16px;height:1000px;">
 
<p><span class="error">* required field</span></p>  
<p>
<!--
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
-->  
<!--//So, the $_SERVER["PHP_SELF"] sends the submitted form data to the page itself, 
instead of jumping to a different page. This way, the user will get error messages on the same page as the form. -->
<h3 style="color:white" class="center">Movie Details</h3>
 <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
 <div class="container">


show Name : <br/>
	<!--Let us add the value the user submitted when submitting the form -->
	<input type="text" placeholder="Enter show name" name="txt_name" maxlength="160" size="50"  value="<?php echo $name;  ?>"/>
	<span class="error">* <?php echo $nameErr;?></span><br/><br/>


show genre: <br/>
	<input type="radio" name="txt_genre" value="Action" <?php if($genre=="Action")
	{echo "checked";}
	
	?>/> Action
  
  <input type="radio" name="txt_genre" value="Adventure" <?php if($genre=="Adventure")
	{echo "checked";}
	
	?>/> Adventure

<input type="radio" name="txt_genre" value="Animation" <?php if($genre=="Animation")
	{echo "checked";}
	
	?>/> Animation

<input type="radio" name="txt_genre" value="Bollywood" <?php if($genre=="Bollywood")
	{echo "checked";}
	
	?>/> Bollywood

<input type="radio" name="txt_genre" value="Comedy" <?php if($genre=="Comedy")
	{echo "checked";}
	
	?>/> Comedy

<input type="radio" name="txt_genre" value="Crime" <?php if($genre=="Crime")
	{echo "checked";}
	
	?>/> Crime

<input type="radio" name="txt_genre" value="Drama" <?php if($genre=="Drama")
	{echo "checked";}
	
	?>/> Drama

<input type="radio" name="txt_genre" value="Family" <?php if($genre=="Family")
	{echo "checked";}
	
	?>/>Family

<input type="radio" name="txt_genre" value="Horror" <?php if($genre=="Horror")
	{echo "checked";}
	
	?>/>Horror

<input type="radio" name="txt_genre" value="Romance" <?php if($genre=="Romance")
	{echo "checked";}
	
	?>/>Romance

<input type="radio" name="txt_genre" value="Sci-Fi" <?php if($genre=="Sci-Fi")
	{echo "checked";}
	
	?>/>Sci-Fi

<input type="radio" name="txt_genre" value="Thriller" <?php if($genre=="Thriller")
	{echo "checked";}
	
	?>/>Thriller
	<span class="error">* <?php echo $genreErr;?></span><br/><br/>

Language : <br/>
	<!--Let us add the value the user submitted when submitting the form -->
	<input type="text" placeholder="Enter language" name="txt_language" maxlength="50" size="50"  value="<?php echo $language;  ?>"/>
	<span class="error">* <?php echo $languageErr;?></span><br/><br/>

country : <br/>
	<!--Let us add the value the user submitted when submitting the form -->
	<input type="text" placeholder="Enter country" name="txt_country" maxlength="60" size="50"  value="<?php echo $country;  ?>"/>
	<span class="error">* <?php echo $countryErr;?></span><br/><br/>

Duration: <br/>
  <input type ="number" name ="txt_duration" maxlength="10" size="50" value="<?php echo $duration;  ?>"/>
  <span class="error">* <?php echo $durationErr;?></span><br/><br/>

release date: <br/>
<input type ="date" name ="txt_release_date" maxlength="10" size="50" value="<?php echo $release_date;  ?>"/>
<span class="error">* <?php echo $release_dateErr;?></span><br/><br/>

Start date: <br/>
<input type ="date" name ="txt_sdate" maxlength="10" size="50" value="<?php echo $sdate;  ?>"/>
<span class="error">* <?php echo $sdateErr;?></span><br/><br/>		

End date : <br/>
<input type ="date" name ="txt_edate" maxlength="10" size="50" value="<?php echo $edate;  ?>"/>
<span class="error">* <?php echo $edateErr;?></span><br/><br/>

imdb rating : <br/>
 <input type ="number" name ="txt_imdb" min = "0" max ="10" maxlength="10" size="50" value="<?php echo $imdb;  ?>"/>
 <span class="error">* <?php echo $imdbErr;?></span><br/><br/>

quality: <br/>
<input type="radio" name="txt_quality" value="2D" <?php if($quality=="2D")
	{echo "checked";}
	
	?>/> 2D

<input type="radio" name="txt_quality" value="3D" <?php if($quality=="3D")
	{echo "checked";}
	
	?>/> 3D

<span class="error">* <?php echo $qualityErr;?></span><br/><br/>

Show Description: <br/>
<textarea  rows="10" cols="50" placeholder="Enter description" name="txt_show_desc"><?php echo $show_desc;?></textarea><br/><br/>
<span class="error">* <?php echo $show_descErr;?></span><br/><br/>
Show Url : <br/>
	<input type="text" placeholder="Enter show url" name="txt_show_url" maxlength="160" size="50"  value="<?php echo $show_url;  ?>"/>
	<span class="error">* <?php echo $show_urlErr;?></span><br/><br/>

Trailer Url : <br/>
	<input type="text" placeholder="Enter trailer url" name="txt_trailer_url" maxlength="160" size="50"  value="<?php echo $trailer_url;  ?>"/>
	<span class="error">* <?php echo $trailer_urlErr;?></span><br/><br/>

Show Year : <br/>
 <input type ="number" name ="txt_show_year" min = "1900" max ="2022" maxlength="10" size="50" value="<?php echo $show_year;  ?>"/>
 <span class="error">* <?php echo $show_yearErr;?></span><br/><br/>

Show Director : <br/>
	<!--Let us add the value the user submitted when submitting the form -->
	<input type="text" placeholder="Enter show director" name="txt_director" maxlength="500" size="50"  value="<?php echo $director;  ?>"/>
	<span class="error">* <?php echo $directorErr;?></span><br/><br/>

Production Team : <br/>
	<!--Let us add the value the user submitted when submitting the form -->
	<input type="text" placeholder="Enter production team" name="txt_prod_team" maxlength="500" size="50"  value="<?php echo $prod_team;  ?>"/>
	<span class="error">* <?php echo $prod_teamErr;?></span><br/><br/>

Casts : <br/>
	<!--Let us add the value the user submitted when submitting the form -->
	<input type="text" placeholder="Enter casts" name="txt_cast" maxlength="890" size="50"  value="<?php echo $cast;  ?>"/>
	<span class="error">* <?php echo $castErr;?></span><br/><br/>

Room : <br/>
	<!--Let us add the value the user submitted when submitting the form -->
	<input type="number" name="txt_room"  size="50"  value="<?php echo $room;  ?>"/>
	<span class="error">* <?php echo $roomErr;?></span><br/><br/>

Child Price: <br/>
	<!--Let us add the value the user submitted when submitting the form -->
	<input type="number" name="txt_child"  size="50"  value="<?php echo $child;  ?>"/>
	<span class="error">* <?php echo $childErr;?></span><br/><br/>

Adult price : <br/>
	<!--Let us add the value the user submitted when submitting the form -->
	<input type="number" name="txt_adult"  size="50"  value="<?php echo $adult;  ?>"/>
	<span class="error">* <?php echo $adultErr;?></span><br/><br/>

 <input type="reset"/> 
<input type="submit"/> 
</div>
   </form>
  </p>

  </div>

<?php 
/*if ($_SERVER["REQUEST_METHOD"] == "POST"){
echo $name;
}*/
?>
 </body>
</html>