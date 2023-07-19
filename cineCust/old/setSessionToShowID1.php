<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();


// define variables and set to empty string values
if(isset($_POST))
{
    $_SESSION['showID'] = $_POST['showID'];
}

  

?>