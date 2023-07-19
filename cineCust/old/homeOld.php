<?php
session_start();
?>
<?php
    require_once "includes/db_connect.php";
    $sQuery = "SELECT * FROM shows WHERE showID = 41  ";

    #echo $sQuery;
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $Result = $conn->query($sQuery) ;
    $userResults = $Result->fetch(PDO::FETCH_ASSOC);
    if($userResults['showID'] )//the show exists
    {	
        
            $_SESSION['showID'] = $userResults['showID'];
            
            //echo $Msg ="success";
            $_SESSION['showID'];
            //echo $_SESSION['showID'];
    }
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
                    <li><a href="/home">Home</a></li>

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
                    <li><a title="Register" href="customerregister.php">Register</a></li>
                    <li><a title="MyReviews" href="reviewcust.php" >MyReviews</a></li>
                    <li><a title="About Us" href="">About Us</a></li>
                    <li><a title="Login/Logout" href="<?php if(isset($_SESSION['username'])){echo 'clogout.php';}ELSE{echo 'customerlogin.php';}?>" ><?php if(isset($_SESSION['username'])){echo'LOG OUT';}ELSE{echo'LOG IN';}?></a></li>
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
        <div id="home-search">
            <div class="container">
                <div class="heading">Search For Movies</div>
                <form id="search" method="get" action="search"> <i class="icon fa fa-search"></i>
                    <div class="submit"> <button type="submit"><i class="fa fa-arrow-right"></i></button> </div>
                    <div class="input"> <input name="keyword" type="text" placeholder="Enter your keywords...">
                        <div class="suggestions"></div>
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
                    <h2>Recommended</h2>
                    <div class="tabs">
                        <span data-name="playing now" class="active"><i class="fas fa-play-circle"></i> Playing
                            Now</span>
                        <span data-name="trending"><i class="fas fa-chart-line"></i> Trending</span>
                        <span data-name="upcoming"><i class="fas fa-list"></i> Upcoming</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="content">
                    <div class="tab-content" data-name="playing now">
                        <?php
                        require_once "includes/db_connect.php";

                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT shows.show_name, shows.duration, shows.imdb_rating, shows.quality, shows.show_desc, shows.show_url, shows.show_year
                        FROM shows 
                        WHERE CURDATE() <= shows.end_date 
                        AND CURDATE() >= shows.start_date 
                        ORDER BY shows.show_name;';


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
                                    echo '<div class="item" data-tip="'.$row['show_desc'].'">';
                                    echo   '<div class="icons">
                                              <div class="quality">'.$row['quality'].'</div>
                                            </div>';
                                    echo    '<a href="result.php" title="'.$row['show_name'].'" class="poster">
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

                <div class="content">
                    <div class="tab-content" data-name="trending" style="display:none">
                        <?php
                        require_once "includes/db_connect.php";

                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql = 'SELECT shows.show_name, shows.duration, shows.imdb_rating, shows.quality, shows.show_desc, shows.show_url, shows.show_year
                        FROM shows 
                        WHERE CURDATE() <= shows.end_date 
                        AND CURDATE() >= shows.start_date 
                        AND shows.imdb_rating > 6.9
                        ORDER BY shows.imdb_rating';


                        $stmt=$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                        $stmt->execute();
                        $conn==null;
                        ?>
                        <div class="filmlist ">
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
                                    echo '<div class="item" data-tip="'.$row['show_desc'].'">';
                                    echo   '<div class="icons">
                                              <div class="quality">'.$row['quality'].'</div>
                                            </div>';
                                    echo    '<a href="result.php" title="'.$row['show_name'].'" class="poster">
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
                <div class="content">
                    <div class="tab-content" data-name="upcoming" style="display:none">
                        <?php
                            require_once "includes/db_connect.php";

                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = 'SELECT shows.show_name, shows.duration, shows.imdb_rating, shows.quality, shows.show_desc, shows.show_url, shows.show_year
                            FROM shows
                            WHERE shows.start_date > CURRENT_DATE()
                            ORDER BY shows.show_name';
                            #echo $sql;

                            $stmt=$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                            $stmt->execute();
                            $conn==null;
                        ?>
                        <div class="filmlist ">
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
                                    echo '<div class="item" data-tip="'.$row['show_desc'].'">';
                                    echo   '<div class="icons">
                                              <div class="quality">'.$row['quality'].'</div>
                                            </div>';
                                    echo    '<a href="result.php" title="'.$row['show_name'].'" class="poster">
                                                <img src=\'images\\' . $row['show_url'] . '\' />
                                            </a>'; 
                                    echo    '<span class="imdb"><i class="fa fa-star"></i>'.$row['imdb_rating'].'</span>';
                                    echo    '<h3><a class="title" title="'.$row['show_name'].'" href="">'.$row['show_name'].'</a></h3>';
                                    echo    '<div class="meta">' . $row['show_year'] . '<i class="dot"></i>'.$row['duration'].'<i class="type">Upcoming</i> </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://s1.bunnycdn.ru/assets/template_3/min/all.js?622c7658"></script>
<!--script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a4bbf5745d3e51e" async></script-->
<!--script type='text/javascript' src='//likedstring.com/d0/ef/3a/d0ef3a0181c8bc6cdc64b116b01ec816.js'></script-->

</html>