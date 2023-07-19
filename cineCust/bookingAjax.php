<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();

?>
<html>


    
    <meta name="description"
        content="Book tickets for film viewing at MauriCine">
    <meta name="keywords"
        content="Book cinema Tickets">
    <meta charset="utf-8">
    <meta name="robots" content="index, follow">


    <style>
        .error {
            color: #FF0000;
        font-size:13px;
        font-weight:500;
        }
    </style>


    <link rel="stylesheet" type="text/css"
        href="css\all.css">

    <link href="css\layout.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <!--script src="form.js"></script--> <!--this script is for the validations of the booking form-->
    <script>
$(document).ready(function(){
    $("body").on("submit", "#bookingform", function(e){
        //$("#bookingform").submit(function(e) {
            //alert('dfasdjdfj');
        //e.preventDefault(); // avoid to execute the actual submit of the form.
        
        //var form = $(this);
        
        
        
        e.preventDefault();  //prevent form from submitiing to target page as defined in the form
        
                    //alert('1');
                    //alert("innsdafh");
                    //$("#usernameErr").append('*fgdf');

                   /* var formData = {
                        txt_username: $("#username").val(),
                        txt_password: $("#password").val(),
                        txt_children: $("#no_children").val(),
                        txt_adults: $("#no_adults").val(),
                        txt_viewingdate: $("#viewingdate").val(),  
                        txt_viewingtime: $("#viewingtime").val()               
        };*/


                    
        var user = $("#username").val();
        var pass = $("#password").val();
        var child = $("#no_children").val();
        var adult = $("#no_adults").val();
        var vdate = $("#viewingdate").val();  
        var vtime = $("#viewingtime").val();             
        
        var url = "bookingformvalidations.php";

        

       
        //ajax request to bookingformvalidations to submit the form data
        $.ajax({
      url: url,
      data: {txt_username: user,
        txt_password: pass,
        txt_children: child,
        txt_adults: adult,
        txt_viewingdate: vdate,  
        txt_viewingtime:  vtime}, 
      dataType: 'JSON',
      type: "post", 
      error: function(xhr){
              alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    })
    .done(function(data)
    { 
      //alert(JSON.stringify(data)); 
      if (data) {

                if (data.success != false) {
                    alert("Booking was successful"); 
                }
                
                if (data.errors.usernameErr != "") {
                    $("#usernameErr").append("");
                  $("#usernameErr").html(
                    '* ' + data.errors.usernameErr
                  );
                }
                else{
                    $("#usernameErr").html(
                        ""
                      );
                }
        
                if (data.errors.passwordErr != "") {
                    $("#passwordErr").html(
                        ""
                      );
                  $("#passwordErr").append(
                    '* ' + data.errors.passwordErr
                  );
                }
                else{
                    $("#passwordErr").html(
                        ""
                      );
                }
        
                if (data.errors.childrenErr != "") {
                    $("#childrenErr").html(
                        ""
                      );
                  $("#childrenErr").append(
                    '* '  + data.errors.childrenErr
                  );
                }
                else{
                    $("#childrenErr").html(
                        ""
                      );
                }

                if (data.errors.adultsErr != "") {
                    $("#adultsErr").html(
                        ""
                      );
                  $("#adultsErr").append(
                    '* '  + data.errors.adultsErr
                  );
                }
                else{
                    $("#adultsErr").html(
                        ""
                      );
                }

                

                if (data.errors.viewingdateErr != "") {
                    $("#viewingdateErr").html(
                        ""
                      );
                    $("#viewingdateErr").append(
                        '* ' + data.errors.viewingdateErr
                    );
                }
                else{
                    $("#viewingdateErr").html(
                        ""
                      );
                }

                if (data.errors.viewingtimeErr) {
                    $("#viewingtimeErr").html(
                        ""
                      );
                    $("#viewingtimeErr").append(
                        '* ' + data.errors.viewingtimeErr
                    );
                }
                else{
                    $("#viewingtimeErr").html(
                        ""
                      );
                }
                
              }  
      
    })//.done(function(data)
            
                });
            });
</script>

    <?php                                    
        
        
        
        
                           
    ?>
    <?php
    if(!isset($_SESSION['username']))
    { 
        echo'<div style="margin-left:20%;margin-right:20%;height:500px;"></br>';        
            echo "<h3  style=\"color:red;text-align:center;\">* You are not logged in</h3>";
            echo "<span style =  \"margin-left:4%;color:red;font-size: 13pt;\">Click on <a style = \"color:blue\" href=\"customerlogin.php\">login </a>to go to the login page</span></div>"; 
        
    }//end if
    else
    {	  //if logged in
       /* if ( ($_SERVER["REQUEST_METHOD"] == "GET") || ( ($_SERVER["REQUEST_METHOD"] == "POST") && (($usernameErr != "") || ($passwordErr != "")  || ($childrenErr != "") || ($viewingdateErr != "") || ($viewingtimeErr !=  "") ) ) )
        { */
            
    ?>
            <h3 style="color:red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please fill booking data</h3>
            <div style="margin-left:20%;margin-right:20%;height:500px;">
                    
                    
                    <p>
                    <!--?php echo $_SERVER["PHP_SELF"];?bookingformvalidations.php-->
                    <form id="bookingform" method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                        <fieldset>
                        <legend style="color:black">Booking Details:</legend>
                        User Name : <br />
                        <input id="username" class="form-control" type="text" name="txt_username" maxlength="30" size="50" placeholder="e.g: gi_Jada2022" />
                        <span id="usernameErr" class="error"></span><br/><br/>
                        Password : <br />
                        <input id="password" class="form-control" type="password" name="txt_password" maxlength="30" size="50" />
                        <span id="passwordErr" class="error"></span><br/><br/>
                        Number of children : <br />
                        <input id="no_children" class="form-control" type="number" name="txt_children" maxlength="10" size="50" />
                        <span id="childrenErr" class="error"></span><br/><br/>
                        Number of adults : <br />
                        <input id="no_adults" class="form-control" type="number" name="txt_adults" maxlength="30" size="50" />
                        <span id="adultsErr" class="error"></span><br/><br/>
                        Date of viewing :<br/>
                        <input id="viewingdate" class="form-control" type="date" name="txt_viewingdate" />
                        <span id="viewingdateErr" class="error"></span><br/><br/>
                        Time of viewing :<br/>
                        <select id="viewingtime" class="form-control" class="viewingtime" name="txt_viewingtime">
                            <option value=""></option>
                            <option value="14:00:00" >14 a.m</option>
                            <option value="20:00:00" >20 p.m</option>                                                
                        </select>
                        <span id="viewingtimeErr" class="error"></span><br/><br/>


                        <button type="submit" style="color:white" class="btn btn-danger" id="paymentbtn" href="#"></i>Proceed to payments</button>
                                                            
                        </fieldset>
                    </form>
                    </p>       

            </div>
    <?php
    //echo 'success';
        
       // }
    }
    ?>
   
        <html>