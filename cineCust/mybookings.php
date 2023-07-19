<?php
session_start();
if(!isset($_SESSION['username']))
    {
        header("Location:customerlogin.php?referer=mybookings");
        die();
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
    .styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}
.styled-table thead tr {
    background-color: #D2042D;
    color: #ffffff;
    text-align: left;
}
.styled-table th,
.styled-table td {
    padding: 12px 15px;
}
.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #D2042D;
}

.styled-table tbody tr.active-row {
    font-weight: 575;
   
}

</Style>
    
    
    
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
                        <a href="mybookings.php" title="MyBookings">MyBookings </a>
                    </li>

                    <!--li><a href="" title="New Movies">New Movies</a></li-->

                    <li><a title="Login/Logout" href="<?php if(isset($_SESSION['username'])){echo 'clogout.php';}ELSE{echo 'customerlogin.php';}?>" ><?php if(isset($_SESSION['username'])){echo'LOG OUT';}ELSE{echo'LOG IN';}?></a></li>
                    <li><a href="" title="About Us">About Us</a></li>

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


</body>
<div class="clearfix"></div>


<div id="body">
    <div class="container">
        <div id="episodes"></div>
        
                    <br/><br/>
                    <table class="styled-table">
    <thead>
        <tr>
            <th>BookingID</th>
            <th>ShowID</th>
            <th>Show_name</th>
            <th>Start_time</th>
            <th>Viewing_date</th>
            <th>No_children</th>
            <th>No_adult</th>
            <th>Payment_status</th>
            <th>Date_paid</th>
            <th>Total_price</th>
            <th>Received_Ticket</th>            
        </tr>
    </thead>
    <tbody>
<?php
require_once "includes/db_connect.php";
                $sQuery = " SELECT b.bookingID, b.showID, s.show_name, b.start_time, b.viewing_date, b.no_children, b.no_adult, b.payment_status, b.date_paid, b.total_price, b.issuedTickets
                            FROM booking b, shows s
                            WHERE b.customerID =".$_SESSION['customerID'].
                            " AND b.issuedTickets = '0'
                            AND b.payment_status = '1'
                            AND b.showID = s.showID
                            ORDER BY bookingID DESC ";  //admin is not a customer, admin must register as customer
                #echo $sQuery;
                //echo "<script>alert(".$sQuery.")</script>";
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                $stmt=$conn->prepare($sQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->execute();
             
            
                //$conn=null;       
                $count = 0;                
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    /*if(($count % 2) ==0){
                        echo"<tr>";
                    }else{
                        echo'<tr class="active-row">';
                    }*/
                    $count++;
                    echo"<tr>
                    <td>" . $row['bookingID'] . "</td>
                    <td>" . $row['showID'] . "</td>
                    <td>" . $row['show_name'] . "</td>
                    <td>" . $row['start_time'] . "</td>
                    <td>" . $row['viewing_date'] . "</td>
                    <td>" . $row['no_children'] . "</td>
                    <td>" . $row['no_adult'] . "</td>
                    <td>" . $row['payment_status'] . "</td>
                    <td>" . $row['date_paid'] . "</td>
                    <td>" . $row['total_price'] . "</td>
                    <td>" . $row['issuedTickets'] . "</td>
                    

                    
                </tr>";
             
                }
?>

        <!--tr>
            <td>Dom</td>
            <td>6000</td>
        </tr>
        <tr class="active-row">
            <td>Melissa</td>
            <td>5150</td>
        </tr-->
        
    </tbody>
</table>
                    
                    
                        
                 
                </section>                                
                            
            </div>
        </div>    
    </div>    
</div>

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
                            <strong>we do not store any trailer on our server,</strong> we only link to the media which
                            is hosted on 3rd party services.</p>
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




