<?php
session_start();

//Make sure the user is logged in first to be able to submit a review 
//else redirects user to login page
if(!isset($_SESSION['username']))
{  
  header("Location: customerlogin.php?referer=review");
  die();
}
?>
<!DOCTYPE html>
<html>

    <head>
        <title>MauriCineReview</title>
        <meta name="description" 
        content="Book tickets for film viewing at MauriCine">
        <meta name="keywords"
            content="Book cinema Tickets">
        <meta charset="utf-8">
        <meta name="robots" content="index, follow">

        <style>
            .error {color: #FF0000;}
        </style>
    
        <link rel="stylesheet" type="text/css"
            href="css/all.css">

        <link href="css/layout.css" rel="stylesheet">

        
    </head>

    <body class="list">
        <header class="static">
            <div class="container">
                <div class="wrapper">
                    <div id="menu-toggler"><i class="fa fa-list-ul"></i></div> <a href="/" id="logo"> <img
                            src="images/logo.png" />
                        <h2>MauriCine</h2>
                    </a>
                    <ul id="menu">
                        <li><a href="\cineCust\home.php">Home</a></li>
                        <li> <a>Genre <i class="fa fa-plus"></i></a>
                            <ul class="genre">
                                <li> <a title="Action movies" href="">Action</a> </li>
                                    <li> <a title="Adventure movies" href="">Adventure</a> </li> 
                                    <li> <a title="Animation movies" href="">Animation</a> </li>                        
                                    <li> <a title="Bollywood movies" href="">Bollywood</a> </li>
                                    <li> <a title="Comedy movies" href="">Comedy</a> </li> 
                                    <li> <a title="Crime movies" href="">Crime</a> </li> 
                                    <li> <a title="Drama movies" href="">Drama</a> </li> 
                                    <li> <a title="Family movies" href="">Family</a></li>                              
                                    <li> <a title="Horror movies" href="">Horror</a> </li>
                                    <li> <a title="Romance movies" href="">Romance</a> </li>
                                    <li> <a title="Sci-Fi movies" href="">Sci-Fi</a> </li>
                                    <li> <a title="Thriller movies" href="">Thriller</a> </li> 
                            </ul>
                        </li>

                        <!--li><a href="" title="New Movies">New Movies</a></li-->

                        <li><a title="About Us" href="" >About Us</a></li>                        
                        <li><a title="Login" href="clogout.php" >LOG OUT</a></li>
                                            
                    </ul>
                    <div id="user"></div>
                    <div id="search-toggler"><i class="fa fa-search"></i></div>
                    <div id="search">
                        <form autocomplete="off" action="search"> <input type="text" name="keyword"
                                placeholder="Enter your keywords..."> <button></button>
                            <div class="suggestions"></div>
                        </form>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </header>

        
    
        <!--div id="body">
            <div class="container mt-5">
                <section class="bl">
                    <div class="heading">
                        <h2>Reviews</h2>
                        <div class="clearfix"></div>
                    </div>
                </section>
            </div>
        </div-->


        <div id="body">
            <div class="container">              
                <div class="bl-1">
                    <section class="bl">
                        <div class="heading">
                            </br><h2>MyReviews</h2>
                            <div class="clearfix"></div>
                        </div>
                    </section>
                    <section class="bl">
                        <div class="content">
                            <?php 
                                      
                                // define variables and set to empty string values

                                $nameErr = $ratingErr = $commentErr = "";
                                $name = $customerID = $showID = $booking_date = $rating = $gender = $comment =  $booking = "";
                                
                                //whether POST or GET
                                $name = $_SESSION['username']; //since already logged(i.e already sanitised), username is retrieved from session 
                                $nameErr = ""; //hence error msg will always be null
                                    

                                if (($_SERVER["REQUEST_METHOD"] == "POST")) {
                                    //if (empty($_POST["txt_name"])) {
                                        //$nameErr = "Name is required";
                                    //} else {
                                        //$name = test_input($_POST["txt_name"]);                                     
                                    //}*/
                                    
                    
                                    if (empty($_POST["txt_rating"])) {
                                        $ratingErr= "A proper rating is required";
                                    } else {
                                        $rating = test_input($_POST["txt_rating"]);
                                        if (!filter_var($rating, FILTER_VALIDATE_FLOAT)) { //Let us invoke the inbuilt function filter_var
                                            $ratingErr = "Rating should be numeric"; 
                                        }//end if
                                    }
                        
                    
                                    if (empty($_POST["txt_comment"])) {
                                        $commentErr = "You need to input a comment to complete the review of a film";
                                    } else {//remove harmful text
                                        
                                        $comment = filter_var($_POST["txt_comment"],  FILTER_SANITIZE_STRING);  
                                        $comment = test_input($comment);                                                                             
                                    }



                                    if($nameErr == "" && $ratingErr == "" && $commentErr == "")
                                    {
                                        $booking = $_POST["txt_booking"];
                                        #echo $visit;
                                        #Let us split the string according to |
                                        list($customerID, $username, $showID, $show_name, $booking_date , $price) = explode( "|", $booking);
                                        $currentDate = date("Y/m/d");
                                        require_once "includes/db_connect.php";
                                        //We escape the single quotes 
                                        //We use fixed values for the dates, house_id, 
                                        #Let us have a transaction, where we will either commit the insert and update statements, or rollback both
                                        $sInsert = "INSERT INTO reviews(reviewID,customerID, showID, adminID, comment, rating, banned, flagged, date_posted)
                                            VALUES ("."'',". $conn->quote($customerID) . ", '$showID','1'," . $conn->quote($comment) .", $rating, '0', '0', '$currentDate') ;";
                                        #echo $sInsert;

                                        // set the PDO error mode to exception
                                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $conn->beginTransaction() ;	
                                        $addResult = $conn->exec($sInsert) ;
                                        if($addResult )
                                        {	
                                            $Msg = "Record Saved!";
                                        #   echo $Msg;
                                        }else{
                                        $Msg = "ERROR: Record could not be Saved!";
                                        $conn->rollBack();					
                                        echo $Msg;
                                        die();
                                        }//end else
                                        
                                        $sUpdate = "UPDATE booking SET reviewed = 1 WHERE customerID = $customerID AND showID = $showID ";
                                        #echo $sUpdate;
                                        $updateResult = $conn->exec($sUpdate) ;
                                        if($updateResult)
                                        {
                                            $Msg = "Record Updated!";
                                            #echo $Msg;
                                        }else{
                                        $Msg = "ERROR: Record could not be updated!";
                                        $conn->rollBack();					
                                        echo $Msg;
                                        die();
                                        }//end else ($updateResult)
                                        
                                        $conn->commit();	
                                        $conn==null;    
                                    }//end if($nameErr == "" && $rating_Err == "" && $genderErr == "" && $commentErr == ""  )
                                }//end if ($_SERVER["REQUEST_METHOD"] == "POST")

                                function test_input($data) {
                                $data = trim($data);
                                $data = stripslashes($data);
                                $data = htmlspecialchars($data);
                                return $data;
                                }
                            
                                require_once "includes/db_connect.php";
                                $sQuery = "SELECT booking.date_paid, booking.total_price, shows.showID, shows.show_name, booking.customerID, c.username
                                        FROM booking  INNER JOIN shows  ON shows.showID = booking.showID
                                        INNER JOIN customer c ON c.customerID = booking.customerID
                                        WHERE  booking.reviewed = 0 
                                        AND c.username= " . $conn->quote($_SESSION['username']) ; 
                                #echo $sQuery;
                                $Result = $conn->query($sQuery) ;
                                $numrows = $Result->rowCount();
                                #echo $numrows;
                                if ($numrows ==0)
                                {
                                    echo "<h3 style='color:red'>You have already reviewed every movies that you could review!!!!!</h3>"; 
                                    echo "<h6 style =  \"font-size: 14pt;\">Click on hyperlink to go to the <a href=\"home.php\">Home</a> page or, to the <a href = \"clogout.php\">Logout</a> page</a></h6>";
                                }//end if
                                else{ 
                                
                            ?>
                            <?php if(($_SERVER["REQUEST_METHOD"] == "GET") || ( ($_SERVER["REQUEST_METHOD"] == "POST") && (($nameErr != "") || ($ratingErr != "") || ($commentErr != "")) ) ){ ?>
                            <div style="margin-left:15%;padding:1px 5px;height:700px;">    
                                <h3 style="color:red">Please review films that you booked on this site</h3>
                                    
                                <p>
                                <!--
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
                                -->   
        
        
                                <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>"  >
                                    <fieldset>
                                        <legend>Personal Details:</legend>
                                        Username : <br/>
                                        <input type="text" class ="fixed-value" value ="<?php echo $name;?>"  readonly/>
                                        <span class="error">* Value is fixed because you are currently logged as this user</span><br/><br/>
                                    </fieldset>
                                    <!-- multiple, size -->
                                    <fieldset>
                                        <legend>Film Details:</legend>
                                        Choose the show you want to rate: (We are showing bookings as customerID | username | showID | show_name | booking_date | price)<br/>
                                        <select name="txt_booking">
                                            <?php
                                                while ($row = $Result->fetch()) {
                                                $str = "";
                                                $str = $str. $row['customerID'] . "|";
                                                $str = $str. $row['username'] . "|";
                                                $str = $str . $row['showID'] . "|";
                                                $str = $str . $row['show_name'] . "|";
                                                $str = $str . $row['date_paid'] . "|";
                                                $str = $str . $row['total_price'] . "|";
                                                echo "<option value = '$str'>$str</option>";
                                                }//end while
                                            ?>
                                        </select></br></br>
                                    
                                        Please specify your appreciation of the film you viewed
                                    
                                        <select name="txt_rating" >
                                        <option value= "" selected >Please select a value</option>
                                            <option value= "1" <?php if($rating == "1") {echo "selected";} ?>>1</option>
                                            <option value= "2" <?php if($rating == "2") {echo "selected";} ?>>2</option>
                                            <option value= "3" <?php if($rating == "3") {echo "selected";} ?>>3</option>
                                            <option value= "4" <?php if($rating == "4") {echo "selected";} ?>>4</option>
                                            <option value= "5" <?php if($rating == "5") {echo "selected";} ?>>5</option>
                                        </select>
                                        <span class="error">* <?php echo $ratingErr;?></span><br/><br/>
                                        Comment: <br/>
                                        <textarea  rows="10" cols="130" name="txt_comment"><?php if($commentErr == ""){echo $comment;}?></textarea><br/>
                                        <span class="error">* <?php echo $commentErr;?></span><br/><br/>
                                        <input type="submit"/> 
                                        <input type="reset"/>

                                </form>
                                
                                <?php
                                        }//endif in case of successful subtion of form data
                                    }//end else if ($numrows ==0) 
                                ?>
                                </p>
                                <?php
                                    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($nameErr == "" && $ratingErr == "" && $commentErr == ""))
                                    {
                                        echo "<h3 >$Msg</h3>";
                                        echo "<h2>Your Input was:</h2>";
                                        echo $booking;
                                        echo "<br>";
                                        echo $name;
                                        echo "<br>";
                                        echo $rating;
                                        echo "<br>";
                                        echo $comment;
                                        echo "<br>";
                                    

                                    }//end if 

                                ?>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </section>                        
                </div>                
            </div>
        </div>
        
    </body>
        
        

        <footer>
            <div class="top">
                <div class="container">
                    <div class="about">
                        <div>
                            <div class="heading">About Us</div>
                            <div class="desc">
                                <p>This website allows users to <strong>book tickets for a movie</strong> or, 
                                <strong>for a special screening of a film</strong> at MauriCine cinema theatres.</p>
                                <p class="small font-italic">This site only displays trailers of films, 
                                    <strong>we do not store any trailer on our server,</strong> we only link to the media which is hosted on 3rd party services.</p>
                            </div>
                        </div>
                    </div>
                    <div class="links">
                        <div class="bl">
                            <div class="heading">Links</div>
                            <ul>
                                <li><a href="">Playing Now</a></li>
                                <li><a href="">Movie Catalogue</a></li>
                                <li><a href="">Most Watched</a></li>
                                <li><a href="">Top IMDb</a></li>
                            </ul>
                        </div>
                        <div class="bl">
                            <div class="heading"></div>
                            <ul>
                                <li><a href="" title="Action Movies">Action</a></li>
                                <li><a href="" title="Comedy Movies">Comedy</a></li>
                                <li><a href="" title="Horror Movies">Horror</a></li>
                                <li><a href="" title="Romantic Movies">Romantic</a></li>
                            </ul>
                        </div>
                        <div class="bl">
                            <div class="heading"></div>
                            <ul>
                                <li><a href="" title="Contact us">Contact Us</a></li>
                                <li><a href="sitemap.xml" target="_blank">Sitemap</a></li> <!--Bzn geter ki mkpv fr ek sa!!!!!!!-->  
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="bot">
                <!--last menubar but with no buttons-->
            </div>
        </footer>
    
</HTML>