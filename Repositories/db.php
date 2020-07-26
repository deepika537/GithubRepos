<?php
/*
 * Created on Tue July 24 2020
 * @author: Deepika
 * Details: DB connection page
 */

 $dbhost = "localhost";//hostname
 $dbuser = "root";//database username
 $dbpass = "";//database password
 $db = "repositories";//database name
 //Create db connection
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
?>
