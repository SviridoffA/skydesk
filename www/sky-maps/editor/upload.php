<?php 
include("config.php"); 
$points = trim($_POST['coords']); 
$result = mysql_query ("INSERT INTO userslineymap VALUES (0, '#FF0000', 2, ' ', '$points')"); 
?>