<?php
session_start();
// ====================== showID ======================
// url = http://localhost/cineCust/result.php?showID=40
// $_SERVER['QUERY_STRING'] = showID=40;
// $urlQuery = ['showID', '40']
// Then access $urlQuery[1] to obtain show id
  //id of film poster chosen
 
if(str_contains($_SERVER['QUERY_STRING'],"=")){
    $urlQuery = explode("=", $_SERVER['QUERY_STRING']);
    $showId = $urlQuery[1];
    $_SESSION['showID'] = $showId;
}else{
    $showId = $_SESSION['showID']; //came from webpage other than home
};

?>

<!DOCTYPE html>
<html>

<head>
    <title>MauriCineResult</title>
    <meta name="description" content="Book tickets for film viewing at MauriCine">
    <meta name="keywords" content="Book cinema Tickets">
    <meta charset="utf-8">
    <meta name="robots" content="index, follow">            

    <link rel="stylesheet" type="text/css" href="css/all.css">

    <link href="css/layout.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/rating_stars.css">  <!-- stars for the review ratings-->
    
    <style>
    <?php
    if(isset($_SESSION['username'])){
        echo ".centered {
            width: 500px;
            height: 950px;
            top: 100px;
            left: calc(30% - 50px);
            position: absolute;
            z-index: 41;
            opacity: 1.0;
            font-size: 20px;
            background-color: lightgrey;
        }";
    }
    else{
        echo ".centered {
            width: 500px;
            height: 150px;
            top: 250px;
            left: calc(30% - 50px);
            position: absolute;
            z-index: 41;
            opacity: 1.0;
            font-size: 20px;
            background-color: lightgrey;
        }";
    }
    ?>
</style>





    <!--script src="form.js"></script--> <!--this script is for the validations of the booking form-->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){  //check dom is loaded
        /*
            
            */
        
        //$(document).on("click", "#flagging #commentFlag", function(){
        $(".flagging .commentFlag").click(function(){
            var obj = $(this);  //id of film poster chosen

           /* $.post("loggedInOut.php", {"value":"1234"}, function(response){
                var obj = $(this)  //id of film poster chosen
            
            
                    
                    
                if(response == "successs"){
                    alert("Please login2");
                    if(obj.attr("style") != "color:yellow"){
                        obj.attr("style", "color:yellow"); //set attribute style to gold if was not al
                    }else{
                        //obj.attr("style", "");
                    }
                    
                }
                else{
                    if(response == "failure"){alert("failed");}
                    alert("You need to log in to perform this action. \nRedirecting you to the login page");
                    location.href = "customerlogin.php";  //equivalent to header loc
                }
            });*/
            
            $.ajax({
                url:"loggedInOut.php",  //tranfer control to this page to check if user is logged in
                data:{"value":"1234"},
                cache: false,
                method: "POST",
                success: function(result){
                    
                    
                    if(result == "success"){
                        if(obj.children().attr("style") != "color:yellow"){       //check if flag yellow                      

                            var reviewID = obj.attr("id");
                            $.ajax({
                                url:"flagcomment.php",  //tranfer control to this page to update review table 
                                data:{"review_id":reviewID},
                                cache: false,
                                method: "POST",
                                success: function(result, data){
                                    
                                    
                                    if(result == "success"){
                                        obj.children().attr("style", "color:yellow"); //set attribute style to yellow
                                        alert("Review with id:"+ reviewID +" was succesfully flagged");
                                        //location.href = "flagcomment.php"; 
                                        
                                    }
                                    else{
                                        //if(result == "failure"){alert("You");}
                                        alert("Was not able to flag your comment. Try again");
                                        //location.href = "customerlogin.php";  //equivalent to header loc
                                        //location.href = "loggedInOut.php";
                                    }
                                }, 
                                error: function(xhr){
                                    alert("An error occured: " + xhr.status + " " + xhr.statusText);
                                }
                                
                        
                            });
                        }
                        else{
                            alert("Comment was already flagged"); //if ws already yellow
                        }
                        /*else{
                            if(isFlagger == 1){
                                obj.attr("style", "");
                            }
                        }*/
                        
                    }
                    else{   //if not logged in
                        //if(result == "failure"){alert("You");}
                        alert("You need to log in to perform this action. \nRedirecting you to the login page");
                        location.href = "customerlogin.php";  //equivalent to header loc
                        //location.href = "loggedInOut.php";
                    }
                }, 
                error: function(xhr){
      			    alert("An error occured: " + xhr.status + " " + xhr.statusText);
    		    }
                
  		
  		    }); 
        });  


        //when x is clicked
        $("button#hideDetails").click(function()
        {
            $("#booking_details .booking_content").html("");
            $("#booking_details").fadeToggle();
        });  


        
        //when user whises to book tickets for a film
        $("a#bookticket").click(function(){
        //$(document).on("click", ".bookticket", function(){
           //var obj = $(this);
           

           //alert("bookingbtn");
            $.ajax({
                    url:"bookingAjax.php", 
                    data: {"value":"1234"}, 
                    cache: false,
                    datatype:"json",
                    method: "GET",
                    success: function(result)
                    {
                        
                        //$("#booking_details").attr("style","display:none");
                        //$is_booking_details_visible = $("#booking_details").attr("style");
                         
                         
                        $("#booking_details .booking_content").append(result);                        
                        $("#booking_details").fadeToggle();
                        
        
                        
                    },
                      
                    error: function(xhr)
                        {
                            alert("An error occured: " + xhr.status + " " + xhr.statusText);
                        }
            });           


        });  

        
        
        

    });
           
    </script>
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
                    <li> <a>Filters <i class="fa fa-plus"></i></a>
                        <ul class="genre">
                        <li> <a title="Action movies" href="searching.php?show_genre=Action">Action</a> </li>
                            <li> <a title="Adventure movies" href="searching.php?show_genre=Adventure">Adventure</a> </li>
                            <!--li> <a title="Animation movies" href="">Animation</a> </li-->
                            <li> <a title="Bollywood movies" href="searching.php?show_genre=Bollywood">Bollywood</a> </li>
                            <li> <a title="Comedy movies" href="searching.php?show_genre=Comedy">Comedy</a> </li>
                            <li> <a title="Crime movies" href="searching.php?show_genre=Crime">Crime</a> </li>
                            <li> <a title="Drama movies" href="searching.php?show_genre=Drama">Drama</a> </li>
                            <li> <a title="Family movies" href="searching.php?show_genre=Family">Family</a></li>
                            <li> <a title="Horror movies" href="searching.php?show_genre=Horror">Horror</a> </li>
                            <li> <a title="Romance movies" href="searching.php?show_genre=Romance">Romance</a> </li>
                            <li> <a title="Sci-Fi movies" href="searching.php?show_genre=Sci-Fi">Sci-Fi</a> </li>
                            <li> <a title="Thriller movies" href="searching.php?show_genre=Thriller">Thriller</a> </li>
                            <li> <a title="French" href="searching.php?language=French">French</a> </li>
                            <li> <a title="3D movies" href="searching.php?quality=3D">3D Movies</a> </li>  
                            <li> <a title="2D movies" href="searching.php?quality=2D">2D Movies</a> </li>                             
                            <li> <a title="English" href="searching.php?language=English">English</a> </li> 
                        </ul>
                    </li>
                    <li>
                        <a<a href="" title="MyReviews">MyREVIEWS </a>
                    </li>

                    <!--li><a href="" title="New Movies">New Movies</a></li-->

                    <li><a title="Login/Logout" href="<?php if(isset($_SESSION['username'])){echo 'clogout.php';}ELSE{echo 'customerlogin.php';}?>" ><?php if(isset($_SESSION['username'])){echo'LOG OUT';}ELSE{echo'LOG IN';}?></a></li>
                    <li><a href="" title="About Us">About Us</a></li>

                </ul>
                <div id="user"></div>
                <div id="search-toggler"><i class="fa fa-search"></i></div>
                <div id="search">
                    <form id="search" method="POST" action="searching.php"> 
                        <input type="text" name="txt_keyword" placeholder="Enter your keywords..."> <button></button>
                        
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </header>


</body>
<div class="clearfix"></div>


<div id="body">
    <div class="container">
        <div id="episodes"></div>
        <div class="watch-extra">
            <div class="bl-1">
                <section class="info">
                    <br/><br/>
                    
                    
                    <?php
                    require_once "includes/db_connect.php"; 

                   /* if(isset($_POST)){
                        $_SESSION['showID'] = $_POST['showID'];
                    }else{
                        echo "dfasjdfgjg";
                    }*/
                    //echo $_SESSION['showID'];
                    
                    // echo $sQuery;
                   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   $sql = "SELECT * FROM shows WHERE showID =".$showId;
                   $stmt=$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                   $stmt->execute();
                   //$conn==null;
                   //$_SESSION[''] = ;
                   
                   
                               
                   while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                   {

                    $_SESSION['start_date'] = $row['start_date'];
                    $_SESSION['end_date'] = $row['end_date'];
                    

                    echo '<div class="poster"> 
                        <span><img itemprop="image" src=\'images\\' . $row['show_url'] . '\' /></span> 
                    </div>';   
                    echo '<div class="info">';                                
                    echo'<h1 itemprop="name" class="title">'.$row['show_name'].'</h1>';
                    echo'<div class="meta lg">'; 
                        echo '<span class="quality">'.$row['quality'].'</span>';                        
                        echo '<span class="imdb"><a class="quality">IMDb: '.$row['imdb_rating'].'</a> </span>'; 
                        
                    echo '</div>';
                    echo '<div itemprop="description" class="desc shorting" style="color:black">'.$row['show_desc'].'</div>';
                    echo '<div class="meta">';
                    echo '<div>'; 
                        echo '<span style="color:black">Genre:</span> <span> <a style="color:black" title="Comedy">'.$row['show_genre'].'</a>,';
                    echo '</div>
                    <div> 
                        <span style="color:black">Release:</span>
                        <span itemprop="dateCreated" style="color:black">'.$row['release_date'].'</span> 
                    </div>';
                    echo '<div> 
                        <span style="color:black">In Mauricine theatres as from:&nbsp;&nbsp;   </span>
                        <span style="color:black"><a style="color:black"> '.$row['start_date'].'</a> up to <a style="color:black"> '.$row['end_date'].'</a></span>
                         
                    </div>';
                    echo '<div><span style="color:black">Duration:</span><span style="color:black">'.$row['duration'].' min</span></div>';
                    echo '<div>
                        <span style="color:black">Director:</span> 
                        <span style="color:black" class="shorting" data-max="20">'.$row['director'].'</span> 
                    </div>';
                    echo '<div> 
                        <span style="color:black">Production:</span> 
                        <span> <span style="color:black" title="prod">'.$row['production_team'].'</span>
                    </div style="width: 100%">';
                    echo '<div class="casts"> 
                        <span style="color:black">Cast:</span> 
                        <span class="shorting" style="color:black" data-type="text"> <span itemprop="actor" title="cast"> <span itemprop="name">'.$row['cast'].'</span></span>
                        </span> 
                    </div>';                    
                    echo '<div class="link"> 
                        <span style="color:black">Link to official trailer:&nbsp; &nbsp;  </span> 
                        <span class="shorting" data-type="link"> <a href='.$row['trailer_url'].' style="color:black" title="trailer_url">  '.$row['trailer_url'].'</a> </span> 
                    </div></br>';  
                   }
                   ?>
                    <!--div class="btn-group open">
                        <a color:red class="btn btn-primary" href=""><p style="color:white"><i style="color:white" class="fas fa-cart-arrow-down"></i>  Book Tickets</p></a>
                    </div-->
                    
                    <a  id="bookticket" style="color:white" class="btn btn-danger">
                    <i style="color:white" id="bookingbtn" class="fas fa-cart-arrow-down fa-1x" aria-hidden="true"></i>&nbsp;&nbsp;Book Tickets</a>
                    
                    
                </section>
            </div>
            
            <div class="bl-2">
                <section class="bl">
                <br/><br/>
                    <div class="heading simple">
                        <h2 class="title">Reviews</h2>
                    </div>
                    <div class="content">                        
                        


                        <?php
                            require_once "includes/db_connect.php";

                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = 'SELECT c.username ,r.comment, r.date_posted, r.rating, r.flagged, r.reviewID
                            FROM reviews r, customer c
                            WHERE r.showID = '.$showId.'
                            AND r.customerID = c.customerID
                            AND banned = 0
                            ORDER BY r.rating DESC';


                            $stmt=$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                            $stmt->execute();
                            $conn==null;
                        
                                        
                            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                            {
                                
                                echo   '<div id="episodes"></div>';
                                echo   '<div class="watch-extra">';
                                echo        '<div class="bl-1">';
                                echo            '<section class="info">';
                                echo                '<h3><a style="font-size:30px" class="title">'.$row['username'].'</a></h3>';
                                echo                '<div class="meta lg">                                              
                                                        <span class="imdb">';for ($x = 1; $x <= $row['rating']; $x++) {
                                                            echo '<i class="fa fa-star" style="color:gold"></i>';
                                                          };echo'</span>                                                        
                                                     </div>';
                                
                                echo                '<div> 
                                                        <!--span style="font-weight:500">Comment: </span-->
                                                    </div>' ; 
                                echo                '<div  itemprop="description" class="desc shorting" span style="font-weight:500" data-type="text">'.$row['comment'].'</div>';
                                echo                '<div class="flagging" style="font-size:12px"> 
                                                        <span>Date posted: </span> 
                                                        <span itemprop="dateCreated">'.$row['date_posted'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <span class="fa-stack fa-lg">
                                                            <i class="fa fa-square fa-stack-2x"></i>
                                                            <a class="commentFlag" id="'.$row['reviewID'].'"><i  class="fa fa-flag fa-stack-1x fa-inverse"'; if($row['flagged']==1){echo 'style="color:yellow"';}; echo ' ></i><a>
                                                        </span>
                                                    </div></br>' ;
                                /*echo              '<span class="fa-stack fa-lg">
                                                        <i class="fa fa-square fa-stack-2x"></i>
                                                        <i  class="fa fa-flag fa-stack-1x fa-inverse"'; if($row['flagged']==1){echo 'style="color:gold"';}; echo ' ></i>
                                                    </span>';*/
                                echo            '</section>';
                                echo        '</div>';
                                echo    '</div>' ;                         
                            }//end while
                        ?>
                    </div>
                </section>
                <div class="watch-extra">
                            <div class="bl-1">
                                <section class="info">         
                                    
                                        <h3><a style="font-size:30px" class="title"><?php if(isset($_SESSION['username'])){echo $_SESSION['username'];}else{echo "Username";};?></a></h3>
                                        <br/><h2 style="font-size:18px;font-weight:500;"><a >Review this movie</a></h2>
                                        
                                        <form method="post" action="validatereviews.php">
                                        <fieldset style="font-size:17px" class="starability-basic"> 
                                            <legend style="font-size:16px;font-weight:500;">Rate movie:</legend>
                                            <input type="radio" id="rate5" name="rating" value="1" />
                                            <label for="rate5" title="Amazing">5 stars</label>
                                            <input type="radio" id="rate4" name="rating" value="2" />
                                            <label for="rate4" title="Very good">4 stars</label>
                                            <input type="radio" id="rate3" name="rating" value="3" />
                                            <label for="rate3" title="Average">3 stars</label>
                                            <input type="radio" id="rate2" name="rating" value="4" />
                                            <label for="rate2" title="Not good">2 stars</label>
                                            <input type="radio" id="rate1" name="rating" value="5" />
                                            <label for="rate1" title="Terrible">1 star</label>
                                        </fieldset>
                                        
                                        
                                                
                                        <p>
                                        <fieldset>
                                            <legend style="font-size:16px;font-weight:500;">Input review</legend> 
                                            <textarea name="userreviewtxt" rows="6" cols="29"></textarea>
                                            <br/>
                                            <input class="submitbtn" type="submit" value="Submit">
                                        </p>    
                                                                         
                                         
                    
                                </section>                                
                            </div>
                        </div>
            </div>
        </div>    
    </div>    
</div>

<footer>
    <div class="top">
        <div class="container">
            <!--div class="about">
                <div>
                    <div class="heading">About Us</div>
                    <div class="desc">
                        <p>This website allows users to <strong>book tickets for a movie</strong> or,
                            <strong>for a special screening of a film</strong> at MauriCine cinema theatres.</p>
                        <p class="small font-italic">This site only displays trailers of films,
                            <strong>we do not store any trailer on our server,</strong> we only link to the media which
                            is hosted on 3rd party services.</p>
                    </div>
                </div>
            </div-->
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
                        <!--Bzn geter ki mkpv fr ek sa!!!!!!!-->
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="centered" id="booking_details" style="display:none">
        <button type="button" id="hideDetails" style="float:right; background-color:red">x</button>
        <div class="booking_content" ></div>
    </div>

    <div class="bot">
        <!--last menubar but with no buttons-->
    </div>
</footer>

</HTML>