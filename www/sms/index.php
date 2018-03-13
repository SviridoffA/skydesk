<meta http-equiv="Content-Type" content="text/html; charset=utf-8">  

<?php

function getaddr($build) {
  mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
  mysql_set_charset("utf8");
  $query="select * from __dom_list where id=$build";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  $name=mysql_result($res,0,"name");
  return($name);
}

function getlist() {

mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
mysql_set_charset("utf8");
$query="select * from __dom_list order by name";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
  for ($i=0;$i<$num;$i++) {
    $sw="";
    $address=mysql_result($res,$i,"__dom_list.name");
    $id=mysql_result($res,$i,"__dom_list.id");
    $str=$str."<option value=$id>$address</option>";
  
  }
  return($str);
}


function getdv($uid) {
mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
mysql_set_charset("utf8");
$query="select * from dv_calls where uid=$uid";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
return($num);
}

function get_all_builds($build, $login, $password, $message){
$query="select * from links_optica where linkbuild=$build";
mysql_connect("localhost","root","zabbix");
$res=mysql("sky_switch",$query);
echo mysql_error();
$num=mysql_num_rows($res);
if ($num>0){
  for ($i=0;$i<$num;$i++) {
    $linkbuild=mysql_result($res,$i,"buildid");
    $address=getaddr($linkbuild);
     echo "<br>";  
    echo  $address;
    echo "<br>";   
    getusers($linkbuild, $login, $password, $message);  
    get_all_builds($linkbuild, $login, $password, $message);
       //$linktype=mysql_result($res,$i,"linktype");
       //$linkbuildid=mysql_result($res,$i,"id");
       //$address=getaddr($linkbuild);
  }
} 
/*else {
   echo "Нет подключенныйх свитчей";
} */ 
}


function getusers($build, $login, $password, $message) {
mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
mysql_set_charset("utf8");
$query="select users.id, users.disable, users_pi.uid, users_pi.fio, users_pi.phone from users, users_pi where users.uid=users_pi.uid and users.disable=0 and users_pi.__dom=$build";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
if ($num===0){
  //echo " <code style='color:#808080'>Нет клиентов в этом доме </code>";
 echo "<kbd style='color:#808080'>Нет клиентов в этом доме  </kbd>";
}
$k=0;
$str="<table>";
  for ($i=0;$i<$num;$i++) {
    $sw="";
    $k++;
    $id=mysql_result($res,$i,"users.id");
    $uid=mysql_result($res,$i,"users_pi.uid");
    $name=mysql_result($res,$i,"users_pi.fio");
    $phone=mysql_result($res,$i,"users_pi.phone");

    $postdata = http_build_query(
      array(
        'login' => $login,
        'psw' => $password,
        'phones' => $phone,
        'mes' => $message,
        'charset' => 'utf-8',
      )
    );

    $opts = array(
      'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
      )
    );
    $context  = stream_context_create($opts);
    $result = file_get_contents('https://smsc.ru/sys/send.php', false, $context);
    echo "<br>";
    echo $result;
    #echo "<br>";

   //$api_message="https://smsc.ru/sys/send.php?login=".$login."&psw=".$password."&phones=".$phone."&mes=".$message;

    //$tst=getdv($uid);
    //if ($tst > 0) {
      $str=$str."<tr><td><font color=green>$k</font></td><td><font color=green>$id</font></td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</td><td><font color=green>$name</font></td></a></font></td><td>$phone</td></tr>";
   // $str=$str."<tr><td><font color=green>$k</font></td><td><font color=green>$id</font></td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</td><td><font color=green>$name</font></td></a></font></td><td>$phone</td><td>$api_message</td></tr>";   

    //} 


    /*else {
      $str=$str."<tr><td><font color=red>$k</font></td><td><font color=red>$id</font></td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</a></td>><td><font color=red>$name</font></td><td>$phone</td></tr>";
   // $str=$str."<tr><td><font color=red>$k</font></td><td><font color=red>$id</font></td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</a></td>><td><font color=red>$name</font></td><td>$phone</td><td>$api_message</td></tr>";
    }  */

  }
  $str=$str."</table>";

  echo ($str);
  return($str);
}


#Main

$login='Skyinet';
$password='catalyst';

echo "<b>Выберете дом:</b><br>";
echo "<form action='' name=addlinks method=\"post\">";

#CHOOSE BUILDING FIELD
echo "<select name=choose_building>";
echo getlist();
echo "</select>";



#MESSAGE FIELD
echo "<br><p><b>Введите текст сообщения:</b></p>";
echo "<p><textarea name='message' rows='10' cols='50' placeholder='Укажите текст сообщения' required></textarea></p>";
echo "<p><b>Пример сообещения:</b></p><p><i>Здравствуйте, уважаемый абонент! </i></p> <p><i>{Дата} Ориентировочно с {время} по {время} по улице {узел} будут проводиться плановые <p><i>технические работы в связи с чем в вашем районе возможны временные перебои в работе услуги Интернет.</p></i><p><i>Просим прощения за предоставленные неудобства. <p><i>C уважением, Компания Skyinet. </i></p>";


echo "<p><input type='submit' value='Отправить'></p>";
echo "</form>";



if(!empty($_POST['message'])){
  $message=$_POST['message'];
  echo "<b>Текст сообщения: </b>".$message;  #add more common output
}

echo "<br>";
echo "<br>";

if(!empty($_POST['choose_building'])){
  $build=$_POST['choose_building'];
  #echo "Build.id - ".$build;
 $address=getaddr($build);
  echo "<b>Выбранный дом: </b>".$address;
  echo "<br>";
  echo "<br>";
  echo "<b>Клиенты:</b>";
  echo "<br>";
  echo "<br>";
  
  echo  $address;
  echo "<br>"; 
  getusers($build, $login, $password, $message);
  get_all_builds($build, $login, $password, $message);
 # $str=get_all_builds($build, $login, $password, $message);
  #echo $str;
}
