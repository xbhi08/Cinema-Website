<?php                                    
session_start(); 
$childrenErr = $adultsErr = $viewingdateErr = $usernameErr = $passwordErr = $viewingtimeErr ="";                
$username = $userpassword = $viewingtime = $viewingdate  = $no_adults = $no_children = "";      
if(!isset($_SESSION['username']))
    { 
        echo'<div style="margin-left:20%;margin-right:20%;height:500px;"></br>';        
            echo "<h3  style=\"color:red;text-align:center;\">* You are not logged in</h3>";
            echo "<span style =  \"margin-left:4%;color:red;font-size: 13pt;\">Click on <a style = \"color:blue\" href=\"customerlogin.php\">login </a>to go to the login page</span></div>"; 
        
    }//end if
    else
    {
        
        
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }     

        // define variables and set to empty string values

        

        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
           // echo "<script>alert('inside')</script>";
            if (empty($_POST["txt_username"])) 
            {
                $usernameErr = "Username is required";                
            } 
            else 
            {
                $username = test_input($_POST["txt_username"]);
                if (!preg_match("/^[a-zA-Z0-9_\']*$/",$username)) 
                { 
                    $usernameErr = "Only letters, the underscore symbol and digits are allowed";                    
                }//end iF
            }//end else

            if (empty($_POST["txt_password"])) 
            {                
                $passwordErr = "Password is required";
            } 
            else 
            {
                
                $userpassword = test_input($_POST["txt_password"]);
                //$hashed_password = password_hash($userpassword,PASSWORD_DEFAULT);
                //We hashed passwords using   
                //$hashed_password = password_hash($password,PASSWORD_DEFAULT);
                //References http://php.net/manual/en/function.password-verify.php
                require_once "includes/db_connect.php";
                $sQuery = "SELECT * FROM customer WHERE username = '$username'";  //admin is not a customer, admin must register as customer
                
                #echo $sQuery;
                //echo "<script>alert(".$sQuery.")</script>";
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $Result = $conn->query($sQuery);
                $numrows = $Result->rowCount();
                $userResults = $Result->fetch(PDO::FETCH_ASSOC);
                if($numrows != 0)//the user exists
                {	
                    $hashed_password = $userResults['password'];
                    if(!password_verify($userpassword,$hashed_password))  //but password does not match                                       
                    {
                        
                        //$usernameErr = $passwordErr = "Valid password is required";
                        $usernameErr = $passwordErr =$Msg = "ERROR: Your credentials seem to be wrong. Try again or make sure you are a registered user!";
                        //echo $Msg;
                        #echo "<script>alert(".$Msg.")</script>";
                    }                   
                } 
                else{
                    $usernameErr = $passwordErr =$Msg = "ERROR: Your credentials seem to be wrong. Try again or make sure you are a registered user!";

                }
                //$conn=null; 

            }//end else

            if (($_POST["txt_children"] == '')) //had to do this because o is counted as empty
            {                
                $childrenErr = "Number of children is required";
            } 
            else 
            {
                $no_children = test_input($_POST["txt_children"]);
                if($_POST["txt_children"] < 0)
                {
                    $childrenErr = "Invalid input for number of children";
                }               
            }

            if ($_POST["txt_adults"] == '') 
            {                
                $adultsErr = "Number of adults is required";
            } 
            else 
            {
                $no_adults = test_input($_POST["txt_adults"]);
                if($_POST["txt_adults"] < 0)
                {
                    $adultsErr = "Invalid input for number of adults";
                    
                }               
            }

            

            if (empty($_POST["txt_viewingdate"])) 
            {                
                $viewingdateErr = "Invalid viewing dated (Date should be between ".$_SESSION['start_date']. "and ".$_SESSION['end_date'].")";
            } 
            else 
            {
                $viewingdate = test_input($_POST["txt_viewingdate"]);
                if(($_POST["txt_viewingdate"] <= $_SESSION['start_date']) || ($_POST["txt_viewingdate"] >= $_SESSION['end_date']) )
                {
                    $viewingdateErr = "Invalid viewing dated (Date should be between ".$_SESSION['start_date']. "and ".$_SESSION['end_date'].")";
                }                
            }

            if (empty($_POST["txt_viewingtime"])) 
            {                
                $viewingtimeErr = "Invalid viewing time";
            } 
            else 
            {
                $viewingtime = test_input($_POST["txt_viewingtime"]);
                //echo $viewingtime;
                if(($_POST["txt_viewingtime"] != "14:00:00") && ($_POST["txt_viewingtime"] != "20:00:00") )
                {
                    $viewingtimeErr = "Invalid viewing time";
                }                
            }
    
    
    
            if($usernameErr == "" && $passwordErr == "" && $viewingtimeErr == "" && $viewingdateErr == "" && $adultsErr == "" && $childrenErr == "")
            {
                $child_price = $adult_price = $seatsRemainingDay = $seatsRemainingNight = 0;
                $currD = date("Y-m-d");//current date

                /*if (!isset($_SESSION['username'])){*/
                    //header("Location:customerlogin.php?referer=bookingAjax");
                    //die();
                //}
                require_once "includes/db_connect.php";
                $sQuery = "SELECT * FROM movies WHERE showID =".$_SESSION['showID'];
                //echo "<script>alert(".$sQuery.")</script>";
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                $stmt=$conn->prepare($sQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->execute();
             
            
                //$conn=null;                       
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    //echo "<script>alert(\"WE in\")</script>";
                    $child_price = (int)$row['child_price'];
                    $adult_price = (int)$row['adult_price'];
                    $seatsRemainingDay = (int)$row['seatsRemainingDay'];
                    $seatsRemainingNight = (int)$row['seatsRemainingNight'];
                }
                //}
                $tot_price = ($no_children * $child_price) + ($no_adults * $adult_price);
                //echo "<script>alert('$tot_price')</script>";
        
        

                require_once "includes/db_connect.php";
                $sInsert="INSERT INTO booking (bookingID, customerID, showID, start_time, no_children, no_adult, payment_status, date_paid, total_price, reviewed, issuedTickets, viewing_date)
                VALUES ('', '".$_SESSION['customerID']."', '".$_SESSION['showID']."', '$viewingtime', '$no_children', '$no_adults', '1', '$currD', '$tot_price', '0', '0', '$viewingdate')";
                #echo $sInsert;
                //echo "<script>alert('$sInsert')</script>";
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $Result = $conn->exec($sInsert) ;
            
                if($Result)
                {	
                    
                    //echo "<script>alert('Booking done')</script>";
                    //if insert was sucessfully done 
                    //compare viewing time and decrease no. of seats remaining accordingly
                    
                    if($viewingtime == "14:00:00"){
                        $seatsRemaining= $seatsRemainingDay - ($no_children + $no_adults);                       
                        $sUpdate = "UPDATE movies m
                        SET m.seatsRemainingDay = '$seatsRemaining'
                        WHERE  m.showID =".$_SESSION['showID'];
                    }else{
                        
                        //echo "<script>alert(\"20hr\")</script>";
                        $seatsRemaining = $seatsRemainingNight - ($no_children + $no_adults);
                        $sUpdate = "UPDATE movies m
                        SET m.seatsRemainingNight = '$seatsRemaining'
                        WHERE  m.showID =".$_SESSION['showID'];
                    }
                    //$conn=null;
                    //echo "<script>alert('$seatsRemaining')</script>";
                    //echo "<script>alert('$sUpdate')</script>";

                    require_once "includes/db_connect.php";
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //echo $sUpdate;
                    $stmtU=$conn->prepare($sUpdate, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                    $stmtU->execute();
                    
                    $Msg ="Booking was successfull";                    
                    //echo "<script>alert('$Msg')</script>";
                    //header("Location: result.php");  
                    //die();
                }
                else
                {
                $Msg = "ERROR: Your booking was not sucessfull";
                //echo "<script>alert('$Msg')</script>";             
                }
                $conn==null;
                                                    
            }

    
                
            
        
        }
    }//endelse isset username
    
    $errors = []; $data = [];  //associative arrays to store data and errror messages
    $errors['childrenErr']=$childrenErr; $errors['viewingdateErr']=$viewingdateErr; $errors['adultsErr']=$adultsErr;
    $errors['usernameErr']=$usernameErr; $errors['passwordErr']=$passwordErr; $errors['viewingtimeErr']=$viewingtimeErr;
    
    $data['username']=$username; $data['userpassword']=$userpassword; $data['viewingtime']=$viewingtime; 
    $data['no_adults']=$no_adults; $data['no_children']=$no_children;

    if(!($usernameErr == "" && $passwordErr == "" && $viewingtimeErr == "" && $viewingdateErr == "" && $adultsErr == "" && $childrenErr == ""))
    {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success!';
    
    }


    //header('Content-Type: application/json'); 
    
    echo json_encode($data); //, JSON_PRETTY_PRINT
?>