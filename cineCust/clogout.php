<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();
session_destroy();
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
                        <li> <a title ="Register" href="customerregister.php">REGISTER</a></li>

                        <!--li><a href="" title="New Movies">New Movies</a></li-->

                        
                        <li><a title="About Us" href="" >About Us</a></li>
                        <li><a href="login.php" title="Login">LOG IN</a></li>
                                            
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
                            <h3>You are sucessfully logged out !! <a href='customerlogin.php'>Click here to log in </a><h3>
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