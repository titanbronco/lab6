<?php

function getDatabaseConnection()
{
     $host = "us-cdbr-iron-east-05.cleardb.net";
     $username = "bbf7de8df9454c";
     $password = "441ff6f0";
    $dbname="heroku_6ed4258c62bdf7f";
// Create connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    return $conn;
    
  }

?>