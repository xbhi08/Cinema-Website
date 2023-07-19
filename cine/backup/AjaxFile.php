<?php
  

  if(isset($_POST['txt_username'])){
     
     require_once "includes/db_connect.php";
     $username = $_POST['txt_username'];

     $sql = "SELECT count(*) AS cntUser FROM admin WHERE username ='".$username."'";

     $result = $conn->query($sql);

     $response = "<span style='color: green;'>Available.</span>";
     if(PDOStatement::rowCount($result)){
        $row = PDO::fetch_assoc($result);

        $count = $row['cntUser'];
      
        if($count > 0){
            $response = "<span style='color: red;'>Not Available.</span>";
        }
     
     }

     echo $response;
     die;
  }
?>