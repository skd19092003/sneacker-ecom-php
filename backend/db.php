<?php
    $server = 'localhost';
    $db = 'sneackerdb';
    $user = 'root'; //in localhost
    $pass = ''; //in localhost 

    try {
        $conn=new mysqli($server,$user,$pass, $db);
        echo $conn->host_info . "\nDatabase conntected\n";
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
?>