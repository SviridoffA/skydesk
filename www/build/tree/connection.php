<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html>
 
<head>
	<title>Destroydrop &raquo; Javascripts &raquo; Tree</title>
 
	<link rel="StyleSheet" href="dtree.css" type="text/css" />
	<script type="text/javascript" src="dtree.js"></script>
 
</head>
 
<body>
 

<?php
include('building.inc.php');
include('box.inc.php');
include('optic_cable.inc.php');
include_once('connect.inc');

  $ext=$_GET['ext'];
  $opticboxid=$_GET['opticboxid'];

  $a=new optic_cable($ext,$opticboxid);

  $idconnect=$_GET['idconnect'];
  if (!empty($idconnect)) {
    $colornum=$_GET['colornum'];
    $optic_cable_id=$_GET['optic_cable_id'];
    $mem=explode(",",$idconnect);
    $to_optic_cable_id=$mem[0];
    $to_colornum=$mem[1];
    $a->insert_optic($opticbox,$colornum,$optic_cable_id,$to_optic_cable_id,$to_colornum);    
  }

  echo "<pre>";
  var_dump($_GET);
  var_dump($a->opticbox);
  echo "</pre>";
  echo "<form>";
  echo "<table>";
  $num=count($a->opticbox['optic_cable']);
  for ($i=0;$i<$num;$i++) {
    echo "<tr><td colspan=2>".$a->opticbox['optic_cable'][$i]['from']." - ".$a->opticbox['optic_cable'][$i]['to']."</td></tr>";
    $nn=count($a->opticbox['optic_cable'][$i]['color']);
    for ($j=1;$j<=$nn;$j++) {
      $colornum=$a->opticbox['optic_cable'][$i]['color'][$j]['colornum'];
      $color=$a->opticbox['optic_cable'][$i]['color'][$j]['color'];
      echo "<tr><td>$color</td><td><font color=$color><b>$colornum</b></font>($colornum)</td><td>";
      $a->select_cable($opticboxid,$a->opticbox['optic_cable'][$i]['id'],$colornum);
      echo "</tr>";
/*
      echo "<tr><td>$color</td><td><font color=$color><b>$colornum</b></font>($colornum)</td><td><select name=$i$colornum>";
      $a->select_cable($opticboxid,$a->opticbox['optic_cable'][$i]['id'],$colornum);
      echo "</select></tr>";
*/    
    }
  }   
  echo "</table>";
  echo "</form>";

?>