<?php
    
    $database = "SSC_VotingSys";
    $username = "slsu";
    $password = "123";
    $conn = new PDO("mysql:host=localhost;dbname=$database", $username, $password, array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY=>true));
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    
?>