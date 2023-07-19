<?php
session_start();
$showId = $_SESSION['showID'];
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}     
//$bookingID = "";
function hasWatched($watched, $showId) {
    require_once "includes/db_connect.php";

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT *
    FROM  booking b
    WHERE b.customerID ='".$_SESSION['customerID']."'
    AND b.showID =".$showId."
    AND b.reviewed = 0";  

    //echo $sql;
    
    
    $Result = $conn->query($sql);
    
    $numrows = $Result->rowCount();
    $conn==null;
    //$userResults = $Result->fetch(PDO::FETCH_ASSOC);
    
    if($numrows != 0)//the user exists
    { 
        $stmt=$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['bookingId'] = $row['bookingID'];                                                    
        //echo $_SESSION['bookingId'];
        return 1;
        
    }
    else{
        return 0;
    } 
                                        
    
}

$haswatched = 0;
$rating=$ratingErr=$reviewtxtErr=$reviewtxt="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_SESSION['username'])){
        
        $haswatched = hasWatched(0, $showId);
        if($haswatched == 1){
            if (empty($_POST['userreviewtxt'])) {
                $reviewtxt = test_input($_POST['userreviewtxt']);
                $reviewtxtErr = "Empty review submitted";
                
            } else {
                $reviewtxt = test_input($_POST['userreviewtxt']);
                /*if (!preg_match("/^[a-zA-Z0-9_\']*$/",$username)) {                                                     
                }*///end iF
            }//end else
            if(isset($_POST['rating'])){
                $rating = $_POST['rating'];
            }
            else {
                $ratingErr = "Movie was not rated";
            }
            
            if($ratingErr == "" && $reviewtxtErr == "" )
            {
                /*echo "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script><script>
                $.ajax({
                    url:\"addreview.php\",  //tranfer control to this page to update review table 
                    data: {\"reviewtxt\":'$reviewtxt', \"rating\":'$rating'},
                    cache: false,
                    method:\"POST\",
                    success: function(result, data){
                        
                        
                        if(result == 'success'){
                            // obj.children().attr('style', 'color:yellow'); //set attribute style to yellow
                            alert('succ');
                            //location.href = 'flagcomment.php'; 
                            
                        }
                        else{
                            if(result == 'failure'){alert('You');}
                            //alert('Was not able to flag your comment. Try again');
                            //location.href = 'customerlogin.php';  //equivalent to header loc
                            //location.href = 'loggedInOut.php';
                        }
                    }, 
                    error: function(xhr){
                        alert('An error occured: ' + xhr.status + ' ' + xhr.statusText);
                    }
                    
            
                }); </script>";*/


                //had to do this else Uncaught Error: Call to a member function setAttribute() on null because $conn already used
                $server_name = "localhost";
                $user_name = "root";
                $password = "";
                $db_name = "mauricine";
                //$conn = mysqli_connect($server_name ,$user_name,$password , $db_name);
                try
                {
                $con = new PDO("mysql:host=$server_name;dbname=$db_name", $user_name, $password);
                }
                catch(PDOException $e)
                {
                    echo $sql . "<br>" . $e->getMessage();
                }      
                            
                $currD = date("Y-m-d");
                //require_once "includes/db_connect.php";
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sInsert = "INSERT INTO reviews (reviewID, customerID, showID, adminID, comment, rating, banned, flagged, date_posted) 
                VALUES ('', '".$_SESSION['customerID']."' , '".$_SESSION['showID']."', '1', '$reviewtxt', '$rating','0','0','$currD')";
                //echo $sInsert;
                $Result = $con->exec($sInsert);

                $sUpdate = "UPDATE booking b
                SET b.reviewed = 1
                WHERE  b.bookingID =".$_SESSION['bookingId'];
                
                //echo $sUpdate;
                $stmtU=$con->prepare($sUpdate, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                $stmtU->execute();
                header("Location: result.php");                                                             
            }
            else{
                echo '<script>alert("Either you have not written a review or you did not give a rating to make a valid review")</script>';
                echo "<br/><br/><br/><h3 style =  \"color:red;font-size: 30pt; ;text-align:center;\">Click on <a stle = \"color:blue\" href=\"result.php\">back</a> to the previous page</a></h6>";
            }
        }   
        else{
            
            //echo "<script type='text/javascript'> alert('".$prompt_msg."'); </script>";
            echo '<script>alert("You have never bought a ticket for this movie or you have already reviewed this movie. \nHence why you cannot review this movie")</script>';
            echo "<br/><br/><br/><h3 style =  \"color:red;font-size:30pt;text-align:center;\">Click on <a style = \"color:blue\" href=\"result.php\">back</a> to the previous page</a></h3>";                                                        
        } 
    }
    else{
        echo 'You are not logged in';
        echo '<script>alert("You are not logged in")</script>';
        header("Location: customerlogin.php?referer=validatereviews");
    }
}
//header("Location: result.php");
?>