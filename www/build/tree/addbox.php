<?php
include('menu.php');
?>
<form method=get action=index.php>
<input type=hidden name=make value=addopticbox>
<?php
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
      echo "$query";
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



?>


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


// area for optic box
?>

<br>
<br>
�������� ���� � ����� ����������� <?php echo $ext;?>
<table>
<tr><td>opticboxtype</td><td><select name=opticboxtype>
<?php
echo selectform("optic_box_description","model","id",0);

?>
</select></td></tr>
<tr><td>address</td><td><select name=idconnect>
<?php

$field[0]="address";
$field[1]="building";
echo selectform("points",$field,"id",$ext);

?>
</select></td></tr>
<tr><td>comment</td><td><input class=field type=text name=comment size=40></td></tr>
<tr><td colspan=2><input class=input value=addbox type=submit></td></tr>
</table>

</table>
</form>

</td>
</tr>

</body>

</html>