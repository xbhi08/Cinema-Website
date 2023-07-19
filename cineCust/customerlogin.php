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
                        <li><a href="/cineCust/home.php">Home</a></li>
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
                        <li> <a title ="MyBookings" href="mybookings.php">MyBookings </a></li>

                        <!--li><a href="" title="New Movies">New Movies</a></li-->

                        <li><a href="<?php if(isset($_SESSION['username'])){echo 'clogout.php';}ELSE{echo 'customerregister.php';}?>"><?php if(isset($_SESSION['username'])){echo'LOG OUT';}ELSE{echo'REGISTER';}?></a></li>
                        <li><a title="About Us" href="" >About Us</a></li>
                                            
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
                <div class="watch-extra">
                    <div class="bl-1">
                        <section class="bl">
                            <div class="content">
                                <?php                                    
                                    if(isset($_GET['referer'])){
                                        if($_GET['referer'] == 'validatereviews'){                                            
                                            echo "<h4 style=\"color:blue; text-align:center;\">&nbsp;&nbsp;&nbsp;&nbsp;* You need to login to be able to review films</h4>";
                                        }
                                        if($_GET['referer'] == 'register'){                                            
                                            echo "<h4 style=\"color:blue; text-align:center;\">&nbsp;&nbsp;&nbsp;&nbsp;* You are now successfully registered as a customer, please login now</h4>";
                                        }
                                        if($_GET['referer'] == 'result'){                                            
                                            echo "<h4 style=\"color:blue; text-align:center;\">&nbsp;&nbsp;&nbsp;&nbsp;*  You need to login to be able to book tickets</h4>";
                                        }
                                        if($_GET['referer'] == 'mybookings'){                                            
                                            echo "<h4 style=\"color:blue; text-align:center;\">&nbsp;&nbsp;&nbsp;&nbsp;*  You need to login to be able to view your bookings</h4>";
                                        }
                                    }

                                    
                                    function test_input($data) {
                                        $data = trim($data);
                                        $data = stripslashes($data);
                                        $data = htmlspecialchars($data);
                                        return $data;
                                    }     
                                    
                                    // define variables and set to empty string values

                                    $usernameErr = $passwordErr ="";
                                    $username = $userpassword= "";

                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                        if (empty($_POST["txt_username"])) {
                                            $usernameErr = "User Name is required";
                                            $passwordErr = "Password is required";
                                        } else {
                                            $username = test_input($_POST["txt_username"]);
                                            if (!preg_match("/^[a-zA-Z0-9_\']*$/",$username)) { 
                                                $usernameErr = "Only letters, the underscore symbol and digits are allowed"; 
                                                $passwordErr = "Password is required";
                                            }//end iF
                                        }//end else
                                        if (empty($_POST["txt_password"])) {
                                            $usernameErr = "User Name is required";
                                            $passwordErr = "Password is required";
                                        } else {
                                            $userpassword = test_input($_POST["txt_password"]);
                                        }//end else
                                        
                                        if($usernameErr == "" && $passwordErr == "" )
                                        {
                                            
                                        //We hashed passwords using   
                                            //$hashed_password = password_hash($password,PASSWORD_DEFAULT);
                                            //References http://php.net/manual/en/function.password-verify.php
                                            require_once "includes/db_connect.php";
                                            $sQuery = "SELECT * FROM customer WHERE username = '$username'";  //admin is not a customer, admin must register as customer
                                            
                                            #echo $sQuery;
                                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            
                                            $Result = $conn->query($sQuery) ;
                                            $numrows = $Result->rowCount();
                                            $userResults = $Result->fetch(PDO::FETCH_ASSOC);
                                            if($numrows != 0)//the user exists
                                            {	
                                                $hashed_password = $userResults['password'];
                                                if(password_verify($userpassword,$hashed_password))
                                                
                                                {
                                                    $_SESSION['username'] = $userResults['username']; 
                                                    $_SESSION['customerID'] = $userResults['customerID'];                                                   
                                                    //echo $Msg ="success";
                                                    //echo 	$_SESSION['username'];
                                                   
                                                    ////DOES NOT WORK IN BETWEEN IF STATEMENT BUT WORKS OUTSIDE OF IT 
                                                   /* if(isset($_GET['referer'])){
                                                        if($_GET['referer'] == 'review'){
                                                            header("Location: reviewcust.php?referer=login"); //redirect back to review page if user was redirected from there
                                                            die();
                                                        }
                                                    }  */
                                                     
                                                }
                                                else
                                                {
                                                    $Msg = "ERROR: Your credentials seem to be wrong. Try again or make sure you are a registered user!";
                                                    echo "<span style =  \"margin-left:20%;font-size: 12pt; text-align:left;\">".$Msg."</span>";   
                                                    echo "<h6 style =  \"margin-left:20%;font-size: 14pt; text-align:left; color:blue;\">Click on the hyperlink <a href=\"customerregister.php\">register</a> page, if you do not have a customer account</a></h6>";
                                                }
                                            
                                                }else{
                                                                                                        
                                                    $Msg = "ERROR: Your credentials seem to be wrong. Try again or make sure you are a registered user!";
                                                    echo "<span style =  \"margin-left:20%;font-size: 12pt; text-align:left;\">".$Msg."</span>";                                                  
                                                    echo "<h6 style =  \"margin-left:20%;font-size: 14pt; text-align:left; color:blue;\">Click on the hyperlink <a href=\"customerregister.php\">register</a>, if you do not have a customer account</a></h6>";
                                                }
                                        }//end if
                                    
                                    }//end else                        
                                ?>
                                <div style="margin-left:15%;padding:1px 85px;height:100px;">
                                    <?php
                                    if (isset($_SESSION['username']))
                                    { 
                                        
                                        echo "<h3 style=\"color:red\">You are already logged in</h3>";
                                        //echo "<h6 style =  \"font-size: 14pt;\">Click on hyperlink to go to the <a href=\"result.php\"></a> h <a href = \"home.php\">Home</a>to t page</a></h6>";
                                        
                                        
                                    }//end if
                                    else{                                    
                                                                     
                                    ?>
                                        <h3 style="color:red">Please login</h3>
                                        <p>
                                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                            <fieldset>
                                            <legend>Login Details:</legend>
                                            User Name : <br />
                                            <input type="text" name="txt_username" maxlength="30" size="50" />
                                            <span class="error">* <?php echo $usernameErr;?></span><br/><br/>
                                            Password : <br />
                                            <input type="password" name="txt_password" maxlength="30" size="50" />
                                            <span class="error">* <?php echo $passwordErr;?></span><br/><br/>

                                            <input type="reset" />
                                            <input type="submit" />
                                            </fieldset><br/><br/>
                                        </p>
                                        <?php
                                    }//end else
                                    
                                    ?>

                                </div>
                                <div class="clearfix"></div>
                            </div>                  
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </body><br/>
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
                            <li><a href="sitemap.xml" target="_blank">Sitemap</a></li>
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