<?php
session_start();
?>


<!DOCTYPE html>
<html>

<head>
    <title>MauriCineHome</title>
    <meta name="description" content="Book tickets for film viewing at MauriCine">
    <meta name="keywords" content="Book cinema Tickets">
    <meta charset="utf-8">
    <meta name="robots" content="index, follow">

    <link rel="stylesheet" type="text/css" href="css/all.css">

    <link href="css/layout.css" rel="stylesheet">
</head>

<body class="">
    <header class="home">
        <div class="container">
            <div class="wrapper">
                <div id="menu-toggler"><i class="fa fa-list-ul"></i></div> <a href="/" id="logo"> <img
                        src="images/logo.png" />
                    <h2>MauriCine</h2>
                </a>
                <ul id="menu">
                    <li><a href="home.php">Home</a></li>

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

                    <!--li><a href="" title="New Movies">New Movies</a></li-->                    
                    <li><a title="Register" href="customerregister.php">Register</a></li>
                    <li><a title="MyBookings" href="mybookings.php" >MyBookings</a></li>
                    <li><a title="About Us" href="">About Us</a></li>
                    <li><a title="Login/Logout" href="<?php if(isset($_SESSION['username'])){echo 'clogout.php';}ELSE{echo 'customerlogin.php';}?>" ><?php if(isset($_SESSION['username'])){echo'LOG OUT';}ELSE{echo'LOG IN';}?></a></li>
                </ul>

                <div id="user"></div>
                <div id="search-toggler"><i class="fa fa-search"></i></div>
                <div id="search">
                    <form autocomplete="off" action="searching.php"> <input type="text" name="keyword"
                            placeholder="Enter your keywords..."> <button></button>
                        <div class="suggestions"></div>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </header>
    <div id="body">
        <div id="home-search">
            <div class="container">
                <div class="heading">Search For Movies</div>
                <form id="search" method="POST" action="searching.php"> 
                    <i class="icon fa fa-search"></i>
                    <div class="submit"> 
                        <button type="submit">
                        <i  class="fa fa-arrow-right"></i></button> 
                    </div>
                    <div class="input"> 
                        <input name="txt_keyword" type="text" placeholder="Enter your keywords...">
                        
                    </div>
                </form>
            </div>
        </div>
        
        <div class="container mt-5">
            <div class="text-center">
                <h1 style="font-size: 1.2em; font-weight: 500;">Book Movie Tickets</h1>
                <p> <strong>Book tickets online</strong> at very affordable prices, <strong>Book special screenings
                    </strong> of any movie found in our directory</p>
                <!--div class="addthis_inline_share_toolbox_3849 text-center"></div-->
            </div>

            
            
            <section class="bl">
                
                <div class="heading">
                    <?php
                        $isEqualSign = 0;
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            $value = $_POST['txt_keyword'];
                        }else{
                        if(str_contains($_SERVER['QUERY_STRING'],"=")){
                            $urlQuery = explode("=", $_SERVER['QUERY_STRING']);
                            $value = $urlQuery[1];
                            $isEqualSign = 1;
                            
                        }};
                    ?>
                    <h2> <?php if($isEqualSign != 1){echo "Results for: $value";}else{echo $value." Movies";}; ?></h2>
                    
                    <div class="clearfix"></div>
                </div>
                <div class="filters normal" >
                    <!--div class="filter dropdown"> <button class="dropdown-toggle" data-toggle="dropdown"> <i
                                class="fa fa-folder-open"></i> Genre <span class="value"
                                data-label-placement="true">All</span> </button>
                        <ul class="dropdown-menu genre lg c4">
                            <li> <input name="genre[]" type="checkbox"  id="genre_action" > <label
                                    >Action</label> </li>
                            <li> <input name="genre[]" type="checkbox" id="genre_adventure" value="17"> <label
                                    >Adventure</label> </li>
                            
                        </ul>
                    </div>
                    
                    
                    <div class="filter submit"> <button type="submit" class="btn btn-sm btn-primary"><i
                                class="fa fa-filter"></i> Filter</button> </div>
                    <div class="clearfix"></div>
                    </div-->
                
                
                <div class="content">
                    <div class="tab-content" data-name="playing now">
                        <?php
                        /*if($_SERVER["REQUEST_METHOD"] == "POST"){
                            $value = $_POST['txt_keyword'];
                        }
                        if(str_contains($_SERVER['QUERY_STRING'],"=")){
                            $urlQuery = explode("=", $_SERVER['QUERY_STRING']);
                            $value = $urlQuery[1];
                            
                        }*/
                        require_once "includes/db_connect.php";

                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // lowercase and see if string contains substr
                        $sql = "SELECT shows.showID, shows.show_name, shows.duration, shows.imdb_rating, shows.quality, shows.show_desc, shows.show_url, shows.show_year
                        FROM shows 
                        WHERE CURDATE() <= shows.end_date 
                        AND CURDATE() >= shows.start_date                         
                        AND ( 
                            (LOWER(shows.show_name) LIKE LOWER('%$value%'))
                            OR (LOWER(shows.show_genre) LIKE LOWER('%$value%')) 
                            OR (LOWER(shows.quality) LIKE LOWER('%$value%')) 
                            OR (LOWER(shows.language) LIKE LOWER('%$value%'))
                        )
                        ORDER BY shows.show_name;";


                        $stmt=$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                        $stmt->execute();
                        $conn==null;


                        
                        ?>

                        <div class="filmlist "> <!--films can be arranged in rows(i.e filling the rows)-->
                                
                            <?php
                                /*<div class="item" data-tip=""><!--datatip is the description of the film when hovering over the film's poster-->
                                    <div class="icons">
                                        <div class="quality">HD</div>
                                    </div> 
                                    <a href="" title="Jackass Forever" class="poster">
                                        <img src="images/jackassforever.png" />
                                    </a> 
                                    <span class="imdb"><i class="fa fa-star"></i> 7.30</span>
                                    <h3><a class="title" title="Jackass Forever" href="/movie/jackass-forever-lxnk6">Jackass Forever</a></h3>
                                    <div class="meta"> 2022 <i class="dot"></i> 96 min <i class="type">Movie</i> </div>
                                </div>*/
                                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                                { 
                                    echo '<div class="item" >';
                                    echo   '<div class="icons">
                                              <div class="quality">'.$row['quality'].'</div>
                                            </div>';
                                    // ===== CHANGE ADDED SHOWID TO THE URL PARAMETER
                                    echo    '<a href="result.php?showId='.$row['showID'].'" title="'.$row['show_name'].'"style="visibility:hidden" class="poster">
                                                <img src=\'images\\' . $row['show_url'] . '\' />
                                            </a>';
                                    echo    '<span class="imdb"><i class="fa fa-star"></i>'.$row['imdb_rating'].'</span>';
                                    echo    '<h3><a class="title" title="'.$row['show_name'].'" href="">'.$row['show_name'].'</a></h3>';
                                    echo    '<div class="meta">' . $row['show_year'] . '<i class="dot"></i>'.$row['duration'].'<i class="type">Playing Now</i> </div>
                                          </div>';                               
                                }//end while
                            ?>  
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                
                                                 

            </section>

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

        <div class="bot">
            <!--last menubar but with no buttons-->
        </div>
    </footer>
</body>
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://s1.bunnycdn.ru/assets/template_3/min/all.js?622c7658"></script-->
<!--script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a4bbf5745d3e51e" async></script-->
<!--script type='text/javascript' src='//likedstring.com/d0/ef/3a/d0ef3a0181c8bc6cdc64b116b01ec816.js'></script-->

</html>