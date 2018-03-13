<?php
require_once("cd.php");
$dbh=new CDataBase("mvs", "localhost", "root", "#fdnjvfn45"); 
$table="categories"; // таблица категорий 
$id_name="cid";     
$query="SELECT * FROM ".$table." ORDER BY cleft ASC"; 
$result=$dbh->query($query); 
while($row = $dbh->fetch_array($result)) 
{ 
   echo str_repeat("&nbsp;",6*$row['clevel']).$row['title']."<br>"; 
} 
?> 