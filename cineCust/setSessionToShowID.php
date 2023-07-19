<?php
// Start the session
//The session_start() function must be the very first thing in your document. Before any HTML tags.
session_start();
header("Content-Type: application/json");

if(isset($_POST['showID'])) {
    $_SESSION['showID'] = $_POST['showID'];
    echo json_encode([]);  //ajax call must return something else wont work 
}

?>