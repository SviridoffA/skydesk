<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
// include('menu.php');
?>
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
	<title>Destroydrop &raquo; Javascripts &raquo; Tree</title>
-->
	<link rel="StyleSheet" href="dtree.css" type="text/css" />
	<script type="text/javascript" src="dtree.js"></script>
<!--
</head>

<body>

-->
<h2></h2>
<table>
<tr>
<td>
<div class="dtree">

	<p><a href="javascript: d.openAll();">open all</a> | <a
href="javascript: d.closeAll();">close all</a></p>

	<script type="text/javascript">
		<!--

		d = new dTree('d');

		d.add(0,-1,'Skyinet Network','/krasnet/');


<?php
// set totalcustomers from building connected with optic

class tree {

  var $position=1;
  var $level=0;

  function calc($id,$idtree) {
    $idtree=$this->position;
    $this->position++;
    $this->level++;
    $query="select * from points where idconnect=$id";
    mysql_set_charset("utf8");
    $res=mysql("switch",$query);
    echo mysql_error();
//    echo "$query\n";
    $num=mysql_num_rows($res);
    for ($i=0;$i<$num;$i++) {
      $id=mysql_result($res,$i,"id");
      $address=mysql_result($res,$i,"address");
      $building=mysql_result($res,$i,"building");
      $tc=mysql_result($res,$i,"tc");
      $customers=$customers+mysql_result($res,$i,"customers");
      $item=$address." ".$building."($customers-$total)";
      $total=$total+$customers;
      echo "d.add(".$this->position.",".$idtree.",'$item','index.php?ext=".$id."');\n";  
      $customers=$customers+$this->calc($id,$this->position);
    }
    $this->level--;
    return($customers);

  }

  function roots() {

    $query="select * from points where idconnect=0 and id !=0";
    mysql_set_charset("utf8");
    $res=mysql("switch",$query);
    $num=mysql_num_rows($res);
    $j=0;
    for ($i=0;$i<$num;$i++) {
      $j++;
      $id=mysql_result($res,$i,"id");
      $address=mysql_result($res,$i,"address");
      $building=mysql_result($res,$i,"building");
      $customers=mysql_result($res,$i,"customers");
      $tc=mysql_result($res,$i,"tc");
      $item=$address." ".$building."($customers-$tc)";
      echo "d.add(".$this->position.",0,'$item','index.php?ext=".$id."');\n";  
      $totalcustomers=$this->calc($id,$this->position);
      $this->position++;
    }


  }
}
include_once('connect.inc');



$ext=$_GET['ext'];
$make=$_GET['make'];
if ($make)  {
  switch ($make) {
    case "addopticbox":
      $opticboxtype=$_GET['opticboxtype'];
      $comment=$_GET['comment'];
      $idconnect=$_GET['idconnect'];
      $query="insert into opticbox(opticboxtype,comment,idconnect) value('$opticboxtype','$comment','$idconnect')";
//      echo "$query";
      $res=mysql("krasnet",$query);
      echo mysql_error();
      break;
    case "change":
        $address=$_GET['address'];
        $building=$_GET['building'];
        $connected=$_GET['connected'];
        $vlan=$_GET['vlan'];
        $network=$_GET['network'];
        $customers=$_GET['customers'];
        $type=$_GET['type'];
        $optic=$_GET['optic'];
        $switch=$_GET['switch'];
        $box=$_GET['box'];
        $query="update points set address='$address',building='$building',idconnect='$connected',vlan='$vlan',network='$network',customers='$customers',type='$type',optic='$optic',switch='$switch',box='$box' where id=$ext"; 
        $res=mysql("krasnet",$query);
//        echo $query;
      break;
    case "newbuilding":
      $query="insert into points(address,idconnect) values('new',0)";
      $res=mysql("krasnet",$query);
//      echo mysql_error();
      $ext=mysql_insert_id();
      break;
    case "delete":
      $ext=$_GET['ext'];
      $query="delete from points where id=$ext";
      $res=mysql("krasnet",$query);
//      echo mysql_error();
//      echo $query;
      $ext=0;
      break;
    case "deleteopticbox":
      $ext=$_GET['ext'];
      $opticboxid=$_GET['opticboxid'];
      $query="delete from opticbox where id=$opticboxid";
//      echo $query;
      $res=mysql("krasnet",$query);
    
      break;
  }
}



$a=new tree();
$a->roots();
?>
		document.write(d);

		//-->
	</script>

</div>
</td>
<td valign=top>
<br>
<br>

<?php
function selectform($table,$field,$key,$id) {
  $query="select * from $table";
  $res=mysql("krasnet",$query);
  $num=mysql_num_rows($res);
  echo "num=$num";
  for ($i=0;$i<$num;$i++) {
    if (is_array($field)) {
      $field_value="";
      $nn=count($field);
      for ($j=0;$j<$nn;$j++) {
        $mfield=$field[$j];
        $field_value=$field_value." ".mysql_result($res,$i,$mfield);
      } 
    } else {
      $field_value=mysql_result($res,$i,$field);
    }
    $key_value=mysql_result($res,$i,$key);
    if ($id == $key_value) {
      $selected="selected";
    } else {
      $selected="";
    }
    echo "<option value=$key_value $selected>$field_value</option>";
  }
  return($str);
}



// echo "id=$ext";


if ($ext) {
$query="select * from points where id=$ext";
$res=mysql("krasnet",$query);
$id=mysql_result($res,0,"id");
$address=mysql_result($res,0,"address");
$building=mysql_result($res,0,"building");
$vlan=mysql_result($res,0,"vlan");
$network=mysql_result($res,0,"network");
$customers=mysql_result($res,0,"customers");
$idconnect=mysql_result($res,0,"idconnect");
$type=mysql_result($res,0,"type");
$totalcustomers=mysql_result($res,0,"totalcustomers");
$tc=mysql_result($res,0,"tc");
$optic=mysql_result($res,0,"optic");
$switch=mysql_result($res,0,"switch");
$box=mysql_result($res,0,"box");
echo "<table>";
echo "<tr><td><form>";
echo "<input type=hidden name=ext value=$ext>";
echo "<input type=hidden name=make value=delete>";
echo "<input class=input type=submit value=Delete></form><form></td><td><form>";
echo "<input type=hidden name=ext value=$ext>";
echo "<input type=hidden name=make value=newbuilding>";
echo "<input class=input type=submit value=New></form><form></td></tr>";
echo "<tr><td>address</td><td><input class=field type=text size=25 name=address value=$address></td></tr>";
echo "<tr><td>building</td><td><input class=field type=text size=25 name=building value=$building></td></tr>";
echo "<tr><td>connected </td><td><select name=idconnect>";
$field[0]="address";
$field[1]="building";
echo selectform("points",$field,"id",$idconnect);
echo "</select></td></tr>";
echo "<tr><td>vlan </td><td><input class=field type=text size=5 name=vlan value=$vlan></td></tr>";
echo "<tr><td>network</td><td><input class=field type=text size=20 name=network value=$network></td></tr>";
echo "<tr><td>customers</td><td><input class=field type=text size=4 name=customers value=$customers></td></tr>";
// echo "<tr><td>type connect</td><td><input class=field type=text size=6 name=type value=$type></td></tr>";

echo "<tr><td>type connect</td><td><select name=type>";
echo selectform("tconnect","typeconnect","id",$type);
echo "</td></tr>";

echo "<tr><td>total customers</td><td>$totalcustomers</td></tr>";
echo "<tr><td>tc</td><td>$tc</td></tr>";
echo "<tr><td>optic</td><td><select name=optic>";
echo "</select>$optic</td></tr>";
echo "<tr><td>switch</td><td><select name=switch>";
echo selectform("switch","model","id",$switch);
echo "</select></td></tr>";
echo "<tr><td>box</td><td><select name=box>";
echo selectform("box","model","id",$box);
echo "</select></td></tr>";
echo "<input type=hidden name=ext value=$ext>";
echo "<input type=hidden name=make value=change>";
echo "<tr><td><input class=input type=submit value=Change></td><td></td></tr>";
echo "</table>";
echo "<br><br><br><br></form>";
}

// area for optic box
if (!empty($ext)) {
  echo "<table>";
  $query="select optic_box_description.model,optic_box_description.id,opticbox.* from opticbox,optic_box_description where optic_box_description.id=opticbox.opticboxtype and opticbox.idconnect=$ext";
  $res=mysql("krasnet",$query);
  $num=mysql_num_rows($res);
  for ($i=0;$i<$num;$i++) {
    $opticboxtype=mysql_result($res,$i,"optic_box_description.model");
    $opticboxid=mysql_result($res,$i,"opticbox.id");
    $comment=mysql_result($res,$i,"comment");
    echo "<tr><td><form><a href=connection.php?ext=$ext&opticboxid=$opticboxid>$opticboxtype</a></td><td>$comment</td><td><input class=input type=submit value=addcable></form></td><td><form><input type=hidden name=ext value=$ext><input type=hidden name=opticboxid value=$opticboxid><input type=hidden name=make value=deleteopticbox><input class=input type=submit value=delete></form></td></tr></tr>";
    $query1="select optic_cable.*,cabletype.* from optic_cable,cabletype where optic_cable.type=cabletype.id and optic_cable.from_opticbox_id=$opticboxid";
//    echo $query1;
    $res1=mysql("krasnet",$query1);
    echo mysql_error();
    $nn=mysql_num_rows($res1);
//    echo "nn=$nn";
    for ($j=0;$j<$nn;$j++) {
      $from_optic_box_id=mysql_result($res1,$j,"optic_cable.from_opticbox_id");
      $to_optic_box_id=mysql_result($res1,$j,"optic_cable.to_opticbox_id");
      $optic_cable_id=mysql_result($res1,$j,"optic_cable.id");
      $optic_cable_type=mysql_result($res1,$j,"cabletype.cabletypes");
      echo "<tr><td>$optic_cable_id</td><td>$from_optic_box_id</td><td>$to_optic_box_id</td><td>$optic_cable_type</td></tr>";
    }


    $query1="select optic_cable.*,cabletype.* from optic_cable,cabletype where optic_cable.type=cabletype.id and optic_cable.to_opticbox_id=$opticboxid";
//    echo $query1;
    $res1=mysql("krasnet",$query1);
    echo mysql_error();
    $nn=mysql_num_rows($res1);
//    echo "nn=$nn";
    for ($j=0;$j<$nn;$j++) {
      $from_optic_box_id=mysql_result($res1,$j,"optic_cable.from_opticbox_id");
      $to_optic_box_id=mysql_result($res1,$j,"optic_cable.to_opticbox_id");
      $optic_cable_id=mysql_result($res1,$j,"optic_cable.id");
      $optic_cable_type=mysql_result($res1,$j,"cabletype.cabletypes");
      echo "<tr><td>$optic_cable_id</td><td>$from_optic_box_id</td><td>$to_optic_box_id</td><td>$optic_cable_type</td></tr>";
    }


  }
  echo "</table>";
}
?>

<br>
<br>
<?php
// include('addbox.inc');
?>
</td>
</tr>

</body>

</html>