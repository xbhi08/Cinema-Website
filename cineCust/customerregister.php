<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();
?>
<!DOCTYPE html>
<html>

    <head>
        <title>MauriCineLogin</title>
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
                    href="css\all.css">

                <link href="css\layout.css" rel="stylesheet">
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
                        <li><a href="home.php">Home</a></li>
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
                        <li> <a title = "MyReviews" href="reviewcust.php">MyREVIEWS</a></li>

                        <!--li><a href="" title="New Movies">New Movies</a></li-->

                        <li><a href="" title="About Us">About Us</a></li>
                        <li><a href="<?php if(isset($_SESSION['username'])){echo'/cineCust/clogout.php';}ELSE{echo'/cineCust/customerlogin.php';}?>" title="Login/Logout"><?php if(isset($_SESSION['username'])){echo'LOG OUT';}ELSE{echo'LOG IN';}?></a></li>
                                            
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

        
    
        <div id="body">
            <div class="container">             
                <div class="bl-1">
                    <section class="bl">
                        <div class="content">
                            <?php   

                            function test_input($data) {
                                $data = trim($data);
                                $data = stripslashes($data);
                                $data = htmlspecialchars($data);
                                return $data;
                            }                  
                                
                            // define variables and set to empty string values

                            $custnameErr = $usernameErr = $passwordErr = $dobErr= $addressErr = $genderErr = $emailErr = "";
                            $cust_name = $username = $userpassword = $dob = $address = $gender= $email= "";

                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (empty($_POST["txt_dob"])) {
                                $dobErr = "Date of birth is required";
                            } else {
                                $dob = test_input($_POST["txt_dob"]);
                            }//end else
                            if (empty($_POST["txt_address"])) {
                                $addressErr = "address is required";
                            } else {
                                $address = test_input($_POST["txt_address"]);
                                if (!preg_match("/^[A-Za-z0-9\- ]+$/",$address)) { 
                                    $addressErr = "Only letters, digits, hyphen and white space are allowed"; 
                                 }//end if
                            }//end else
                            if (empty($_POST["txt_gender"])) {
                                $genderErr = "gender is required";
                            } else {
                                $gender = test_input($_POST["txt_gender"]);
                            }//end else
                            if (empty($_POST["txt_username"])) {
                                $usernameErr = "User Name is required";
                            } else {

                                //checking if username is already taken
                                require_once "includes/db_connect.php";
                                $username = $_POST["txt_username"];
                                $sQuery = "SELECT * From customer WHERE customer.username = ".$conn->quote($username);
                                #echo $sQuery;
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                                
                                $Search = $conn->query($sQuery);
                                $numrows = $Search->rowCount();

                                if ($numrows != 0){ //if record exists
                                    $usernameErr = "Username is already taken. Please try and come up with another one!!";
                                    $username = "";
                                } else {
                                    $username = test_input($_POST["txt_username"]);
                                    if (!preg_match("/^[a-zA-Z0-9_\']*$/",$username)) { 
                                        $usernameErr = "Only letters, the underscore symbol and digits are allowed"; 
                                    }//end if
                                }
                            }//end else
                            if (empty($_POST["txt_cust_name"])) {
                                $custnameErr = "Full customer Name is required";
                            } else {
                                $cust_name = test_input($_POST["txt_cust_name"]);
                                if (!preg_match("/^([A-Z][a-z\']*)(\s[A-Z][a-z\']*)*$/",$cust_name)) { 
                                    $custnameErr = "Only letters are allowed(Each word entered should start with an uppercase letter)"; 
                                }//end if
                            }
                            if (empty($_POST["txt_password"])) {
                                $passwordErr = "Password is required";
                            } else {
                                $userpassword = test_input($_POST["txt_password"]);
                            }//end else
                            if (empty($_POST["txt_email"])) {
                                $emailErr = "Email is required";
                            } else {
                                $email = test_input($_POST["txt_email"]);
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    $emailErr = "Invalid email format";
                                }
                            }//end else
                            
                            
                            if($custnameErr == "" && $usernameErr == "" && $passwordErr == ""  && $dobErr== "" &&$addressErr == "" && $genderErr==  "" && $emailErr == "" )
                            {
                                
                                $hashed_password = password_hash($userpassword,PASSWORD_DEFAULT);
                                require_once "includes/db_connect.php";
                                $sInsert = "INSERT INTO customer  (customerID,username,custName,password,gender,address,email,dateOfBirth) VALUES( '', ".$conn->quote($username).", ".$conn->quote($cust_name).", '$hashed_password','$gender',".$conn->quote($address).", ".$conn->quote($email).", '$dob') ";
                                #echo $sQuery;
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                
                                $Result = $conn->exec($sInsert) ;
                            
                                if($Result )
                                {	
                                    //$Msg = "Successfully Registered with credentials(CustomerName|username|gender|address|email|dob): '$cust_name'| '$username'|'$gender'|'$address'|'$email'|'$dob'";
                                    $Msg = "Successfully Registered with credentials";
                                    echo $Msg;
                                    header("Location: ../cineCust/customerlogin.php?referer=register");  
                                    die();
                                }else{
                                $Msg = "ERROR: Your credentials could not be saved!";
                                echo $Msg;
                                    
                                }
                                $conn==null;
                            }//end if
                            
                            }//end else 
                             
                            ?>
                            
                            <?php
                            //form is made available on if get(i.e empty) or post(i.e form was submitted with an error), then show form
                            if ( ($_SERVER["REQUEST_METHOD"] == "GET") || ( ($_SERVER["REQUEST_METHOD"] == "POST") && (($custnameErr != "") ||($usernameErr != "") || ($passwordErr != "")  || ($dobErr != "") || ($addressErr != "") || ($genderErr !=  "") || ($emailErr != "" )) ) )
                            { 
                            ?>
                            <div style="margin-left:15%;padding:1px 16px;height:700px;">
                                
                                <?php
                                if(isset($_SESSION['username']))
                                { 
                                    echo "<h3 style=\"color:red\">You are already logged in</h3>";
                                    
                                }//end if
                                else
                                {	  
                                ?>

                                <h3 style="color:red">Please register</h3>
                                <p>
                                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                        <fieldset>
                                        <legend>Login Details:</legend>
                                        Customer full name : <br />
                                        <input type="text" name="txt_cust_name" maxlength="200" size="50" placeholder="Abc Def" value="<?php if($custnameErr == ""){echo $cust_name;}?>" />
                                        <span class="error">* <?php echo $custnameErr;?></span><br /><br />
                                        Username : <br />
                                        <input type="text" name="txt_username" maxlength="50" size="50" placeholder="gi_Jada2022" value="<?php if($usernameErr == ""){echo $username;}?>" />
                                        <span class="error">* <?php echo $usernameErr;?></span><br /><br />
                                        Password : <br />
                                        <input type="password" name="txt_password" maxlength="30" size="50" value="" /> 
                                        <span class="error">* <?php echo $passwordErr;?></span><br /><br />
                                        gender : <br />
                                        <input type="radio" name="txt_gender" value="male" <?php if($gender=="male")
                                        {echo "checked";}
                                        
                                        ?> /> Male
                                            <input type="radio" name="txt_gender" value="female" <?php if($gender=="female")
                                        {echo "checked";}
                                        
                                        ?> /> Female
                                            <input type="radio" name="txt_gender" value="other" <?php if($gender=="other")
                                        {echo "checked";}
                                        
                                        ?> /> Other
                                        <span class="error">* <?php echo $genderErr;?></span><br /><br />
                                        Address : <br />
                                        <input type="text" name="txt_address" maxlength="300" size="50" value="<?php if($addressErr == ""){echo $address;}?>" />
                                        <span class="error">* <?php echo $addressErr;?></span><br /><br />
                                        email : <br />
                                        <input type="email" name="txt_email" maxlength="300" size="50" value="<?php if($emailErr == ""){echo $email;}?>" />
                                        <span class="error">* <?php echo $emailErr;?></span><br /><br />
                                        Date of birth : <br />
                                        <input type="date" name="txt_dob" size="50" value="<?php if($dobErr == ""){echo $dob;}?>" />
                                        <span class="error">* <?php echo $dobErr;?></span><br /><br />

                                        <input type="reset" />
                                        <input type="submit" />
                                        </fieldset>
                                    </form>
                                </p>

                                <?php
                                }//end else
                                
                                }//endif in case of successful subtion of form data
                            
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