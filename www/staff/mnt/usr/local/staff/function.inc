<?php
/*
─юсртыхэю 
6.09.2004 ╧юфёўхЄ єёыєу т ЁрёўхЄх срырэёр (┬√сюЁър єёыєу чр яхЁшюф)

*/
function checkresource($username) {
  $query="select * from summary where username like '$username' and sdate >= '2003-06-01 00:00:00' order by sdate";
  $res=mysql("mvs",$query);
  $num=mysql_num_rows($res);
  $recalc=0;
  for ($i=0;$i < $num;$i++) {
    $sd=mysql_result($res,$i,"sdate");
    $ed=mysql_result($res,$i,"edate");
    $pay=mysql_result($res,$i,"payments");
    $dogid=mysql_result($res,$i,"dogid");
    $tarif=mysql_result($res,$i,"tarif");
    $mbyte==mysql_result($res,$i,"mbyte");
    $paycheck="select sum(summa) as paym from payment where username like '$username' and date >= '$sd' and date <= '$ed'";
    $pres=mysql("mvs",$paycheck);
    $pays=sprintf("%8.2f",mysql_result($pres,0,"paym"));
//    echo "sd=$sd ed=$ed pays=$pays pay=$pay<br>";
    if ($pay != $pays) { 
      $recalc++;
    }

    $ucon="select * from usercontrol where datefrom >= '$sd' and datefrom < '$ed' and userchange like '$username'";
    $ures=mysql("mvs",$ucon);
    $uc=mysql_num_rows($ures);
//    echo "sd=$sd ed=$ed num=$uc $ucon<br>";
    if ($uc > 0) $recalc++;
/*
    $mb="select sum(bytes) as mb from data where service like '$username' and cost >= 0";
    $mres=mysql("mvs",$mb);
    $mb=mysql_result($mres,0,"mb");
//    echo "test";
    $mb=sprintf("%8.3f",$mb/1024/1024);
//    echo "sd=$sd ed=$ed mb=$mb mbyte=$mbyte<br>";
    if ($mb != mbyte ) $recall++;
*/  
//  echo "recalc=$recalc<br>";
  if ($recalc > 0) {
      $del="delete from summary where dogid=$dogid and sdate >= '$sd'";
      $dres=mysql("mvs",$del); 
//      echo $del."<br>";
      $del="delete from begstat where dogid=$dogid and date >= '$sd'";
      $dres=mysql("mvs",$del); 
//
//      echo $del."<br>";
      $i=$num;
    }

  }
  return;
}
function close_session($username) {
  $query="select * from users where username like '$username' and access like 'full'";
  $res=mysql("mvs",$query);
  $num=mysql_num_rows($res);
  if ($num > 0) {
    $pid=mysql_result($res,0,"pid");
    $pp=popen("/bin/kill $pid","r");
    while (!feof($pp)) {
      $str=$str.fgets($pp,2048);
    }
    return($str);
  } else {
    return(0);
  }
}
function checkdisable($username) {
  $query="select * from customers where username like '$username' and now() < stopDate and status=2";
  $res=mysql("mvs",$query);
  $num=mysql_num_rows($res);
  if ($num > 0) {
    return(0);
  } else {
    $query="select * from customers where username like '$username' and status=1";
    $res=mysql("mvs",$query);
    $num=mysql_num_rows($res);
    if ($num > 0) {
      return(0);
    } else {
      return(1);
    }
  }
}

function calcservice($username,$service,$sd,$ed) {
  $gamequery="select sum(bytes) from data where username like '$username' and service like '$service' and startDate >= '$sd' and startDate <= '$ed' and cost >= 0 order by startDate";
//  echo $gamequery."<br>";
  $gres=mysql("mvs",$gamequery);
  $gn=mysql_num_rows($gres);
  if ($gn > 0) {
    $gamebytes=mysql_result($gres,0,"sum(bytes)");
  } else {
    $gamebytes=0;
  }
//  echo "service $service $gamebytes<br>";
  return($gamebytes);
}

function balans($username) {

checkresource($username);
// echo "balans($username)<br>";
set_time_limit(0);
$count=0;  # Max loop
$loop=1;
$debug=0;
  
while (($loop) && ($count < 25)) {
  $count++;
  // Выяснение даты c которой надо расчитывать баланс

// 31.03.2004 Поправлен расчет следующей даты. Было добавляем месяц вычитаем день. Стало добавляем день добавляем месяц вычитаем день
//  $query="select dogovor.id,summa,year(adddate(begstat.date,interval 1 month)) as y1,month(adddate(begstat.date,interval 1 month)) as m1,dayofmonth(adddate(begstat.date,interval 1 month)) as d1,year(adddate(begstat.date,interval 1 day)) as y,month(adddate(begstat.date,interval 1 day)) as m,dayofmonth(adddate(begstat.date,interval 1 day)) as d, to_days(subdate(adddate(begstat.date,interval 1 month),interval 1 day))-to_days(begstat.date) as per,to_days(now())-to_days(adddate(begstat.date,interval 1 day)) as daysFromLastBalans from dogovor,begstat,customers where begstat.dogid=dogovor.id and customers.dogovor=dogovor.id and customers.username like '$username' order by begstat.date desc";
  $query="select dogovor.id,summa,begstat.date,year(subdate(adddate(adddate(begstat.date,interval 1 day),interval 1 month),interval 1 day)) as y1, month(subdate(adddate(adddate(begstat.date,interval 1 day),interval 1 month),interval 1 day)) as m1, dayofmonth(subdate(adddate(adddate(begstat.date,interval 1 day),interval 1 month),interval 1 day)) as d1, year(adddate(begstat.date,interval 1 day)) as y, month(adddate(begstat.date,interval 1 day)) as m, dayofmonth(adddate(begstat.date,interval 1 day)) as d, to_days(subdate(adddate(adddate(begstat.date,interval 1 day),interval 1 month),interval 1 day))-to_days(begstat.date) as per, to_days(now())-to_days(adddate(begstat.date,interval 1 day)) as daysFromLastBalans from dogovor,begstat,customers where begstat.dogid=dogovor.id and customers.dogovor=dogovor.id and customers.username like '$username' order by begstat.date desc";
//  echo $query."<br>";
  $res=mysql("mvs",$query);
  
  if (mysql_error()) echo "1.".mysql_error();
  $nn=mysql_num_rows($res);
  $insert=0; 
  if ($nn > 0) {
      $sd=mysql_result($res,0,"y").".".mysql_result($res,0,"m").".".mysql_result($res,0,"d")." 00:00:00";
      $sdd=sprintf("%04d",mysql_result($res,0,"y"))."-".sprintf("%02d",mysql_result($res,0,"m"))."-".sprintf("%02d",mysql_result($res,0,"d"))." 00:00:00";
      $ed=mysql_result($res,0,"y1").".".mysql_result($res,0,"m1").".".mysql_result($res,0,"d1")." 23:59:59";
      if ($debug) echo "<br>!!sd=$sd ed=$ed<br>";
      // sроверка даты по которую надо расчитывать баланс
      $qchange="select id,year(subdate(datefrom,interval 1 day)) as y1, month(subdate(datefrom,interval 1 day)) as m1,dayofmonth(subdate(datefrom,interval 1 day)) as d1,to_days(subdate(datefrom,interval 1 day))-to_days('$sd') as per,to_days(now())-to_days(subdate(datefrom,interval 1 day)) as daysFromLastBalans  from usercontrol where userchange like '$username' and varchange like 'tarif' and datefrom > '$sd' and datefrom <= '$ed' order by datefrom";
//      $qchange="select id,year(subdate(datefrom,interval 1 day)) as y1, month(subdate(datefrom,interval 1 day)) as m1,dayofmonth(subdate(datefrom,interval 1 day)) as d1,to_days(subdate(datefrom,interval 1 day))-to_days('$sd') as per,to_days(now())-to_days(subdate(datefrom,interval 1 day)) as daysFromLastBalans  from usercontrol where userchange like '$username' and varchange like 'tarif' and datefrom >= '$sd' and datefrom <= '$ed' order by datefrom";
//      $qchange="select id,year(datefrom) as y1, month(datefrom) as m1,dayofmonth(datefrom) as d1,to_days(datefrom)-to_days('$sd') as per,to_days(now())-to_days(datefrom) as daysFromLastBalans  from usercontrol where userchange like '$username' and varchange like 'tarif' and datefrom >= '$sd' and datefrom <= '$ed' order by datefrom";
      if ($debug) echo "<br>!!<br>$qchange<br>";
      $rest=mysql("mvs",$qchange);
      if (mysql_error()) echo "2.".mysql_error();
      $nn1=mysql_num_rows($rest);
      $dayOfMonth=mysql_result($res,0,"per");
      if ($nn1) { 
          $ed=mysql_result($rest,0,"y1").".".mysql_result($rest,0,"m1").".".mysql_result($rest,0,"d1")." 23:59:59";
          $cid=mysql_result($rest,0,"id");
          $daysFromLastBalans=mysql_result($rest,0,"daysFromLastBalans")+1;
          $periodDays=mysql_result($rest,0,"per")+1;
          $insert=1;
      } else {
          $daysFromLastBalans=mysql_result($res,0,"daysFromLastBalans")+1;
      }
//      echo "days=$days<br>";
      $dogid=mysql_result($res,0,"dogovor.id");
      $total=mysql_result($res,0,"summa");
      if ($debug) echo "1a sd=$sd ed=$ed<br>";
  } else {
      $total=0;
      $start=0;
// 31.03.2004 Поправлен расчет следующей даты. Было добавляем месяц вычитаем день. Стало добавляем день добавляем месяц вычитаем день
//      $query="select id,year(subdate(adddate(aktDate,interval 1 month),interval 1 day)) as y1,month(subdate(adddate(aktDate,interval 1 month),interval 1 day)) as m1,dayofmonth(subdate(adddate(aktDate,interval 1 month),interval 1 day)) as d1,year(aktDate) as y,month(aktDate) as m,dayofmonth(aktDate) as d, to_days(subdate(adddate(aktDate,interval 1 month),interval 1 day))-to_days(aktDate) as per, to_days(now())-to_days(aktDate) as daysFromLastBalans from dogovor where domen like '$username'";
      $query="select id,year(subdate(adddate(adddate(aktDate,interval 1 day),interval 1 month),interval 1 day)) as y1,month(subdate(adddate(adddate(aktDate,interval 1 day),interval 1 month),interval 1 day)) as m1,dayofmonth(subdate(adddate(adddate(aktDate,interval 1 day),interval 1 month),interval 1 day)) as d1,year(aktDate) as y,month(aktDate) as m,dayofmonth(aktDate) as d, to_days(subdate(adddate(adddate(aktDate, interval 1 day),interval 1 month),interval 1 day))-to_days(aktDate) as per, to_days(now())-to_days(adddate(aktDate,interval 1 day)) as daysFromLastBalans from dogovor where domen like '$username'";
      $res=mysql("mvs",$query);
//      echo "<br>!!<BR>$query<BR>";
      if (mysql_error()) echo "3.".mysql_error();
      $sd=mysql_result($res,0,"y").".".mysql_result($res,0,"m").".".mysql_result($res,0,"d")." 00:00:00";
      $sdd=sprintf("%04d",mysql_result($res,0,"y"))."-".sprintf("%02d",mysql_result($res,0,"m"))."-".sprintf("%02d",mysql_result($res,0,"d"))." 00:00:00";
      $dogid=mysql_result($res,0,"id");
      $ed=mysql_result($res,0,"y1").".".mysql_result($res,0,"m1").".".mysql_result($res,0,"d1")." 23:59:59";
      // sроверка даты по которую надо расчитывать баланс
      if ($debug) echo "1.sd=$sd ed=$ed<br>";
      $qchange="select id,year(subdate(datefrom,interval 1 day)) as y1,month(subdate(datefrom,interval 1 day)) as m1,dayofmonth(subdate(datefrom,interval 1 day)) as d1,to_days(subdate(datefrom,interval 1 day))-to_days('$sd') as per,to_days(now())-to_days(subdate(datefrom,interval 1 day)) as daysFromLastBalans  from usercontrol where userchange like '$username' and varchange like 'tarif' and datefrom > '$sd' and datefrom <= '$ed' order by datefrom";
      $rest=mysql("mvs",$qchange);
      if (mysql_error()) echo "4.".mysql_error();
      $nn1=mysql_num_rows($rest);
      $dayOfMonth=mysql_result($res,0,"per");
//      echo "days=$dayOfMonth<br>";
      if ($nn1) {
          $cid=mysql_result($rest,0,"y1");
          $ed=mysql_result($rest,0,"y1").".".mysql_result($rest,0,"m1").".".mysql_result($rest,0,"d1")." 23:59:59";
//!!          echo "2.sd=$sd ed=$ed<br>";
          $daysFromLastBalans=mysql_result($rest,0,"daysFromLastBalans")+1;
          $periodDays=mysql_result($rest,0,"per")+1;
          $insert=1;
      } else {
         $daysFromLastBalans=mysql_result($res,0,"daysFromLastBalans")+1;
      }
  }

if ($debug) echo "3.sd=$sd ed=$ed<br>";

$query="select * from customers where username like '$username'";
$res=mysql("mvs",$query);
if (mysql_error()) echo "5.".mysql_error();
$status=mysql_result($res,0,"status");

  $qchange="select vardata from usercontrol where userchange like '$username' and varchange like 'tarif' and datefrom <= '$sd' order by datefrom desc";
  if ($debug) echo $qchange."<br>";
  $rest=mysql("mvs",$qchange);
  if (mysql_error()) echo "6.".mysql_error();
  $nn1=mysql_num_rows($rest);
  if ($debug) echo "nn=$nn1<br>";
  if ($nn1) {
      $tarif=mysql_result($rest,0,"vardata");
  } else {
      $tarif=mysql_result($res,0,"tarif");
  }

// echo "nn1=$nn1 tarif=$tarif<br>";
// echo "<br>$sd - $ed<br>";
$query="select * from pricelist where tarifid=$tarif";
$res=mysql("mvs",$query);
if (mysql_error()) echo "7.".mysql_error();
$nump=mysql_num_rows($res);
if ($nump) {
  $porog=mysql_result($res,0,"porog")*1024*1024;
  $mb=mysql_result($res,0,"costmb");
  $abonplata=mysql_result($res,0,"abon");

} else 
switch ($tarif) {
  case 100:
    $mb=0;
    $porog=0;
    $abonplata=00;
    break;
  case 2048:
    $mb=0.25;
    $porog=2048*1024*1024;
    $abonplata=520;
    break;
  case 10:
    $mb=0.28;
    $porog=0;
    $abonplata=0;
    break;
  case 11:
    $mb=0.80;
    $porog=0;
    $abonplata=10;
    break;
  case 3:
    $mb=0.44;
    $porog=300*1024*1024;
    $abonplata=135;
    break;
  case 2:
    $mb=0.54;
    $porog=100*1024*1024;
    $abonplata=50;
    break;
  default:
    $mb=0.64;
    $porog=40*1024*1024;
    $abonplata=25;

}
$numStart=sprintf("%6.2f",1);
$start=sprintf("%6.2f",$total);
// echo "insert=$insert<br>";
// echo "days=$days<br>";
// echo "periodDays=$periodDays<br>";
if ($insert) {
  $days=$periodDays;
} else {
  if ($daysFromLastBalans > $dayOfMonth) {
    $days=$dayOfMonth; 
  } else {
    $days=$daysFromLastBalans;
  }
}
// echo "daysFromLastBalans=$daysFromLastBalans<br>";
// echo "days=$days<br>";
$oneday=sprintf("%6.6f",$abonplata/$dayOfMonth);
$abon=sprintf("%8.2f",0-$days*$oneday);
$abon=sprintf("%8.2f",$abon);


// include('calculate.inc');

$oldmoney=0;
$total=0;

  $query="select max(endDate) from data where username like '$username' and service like '$username' and startDate >= '$sd' and startDate <= '$ed' order by startDate";
//  echo $query."<br>";
  $res=mysql("mvs",$query);
  if (mysql_error()) echo "8.".mysql_error();
  $num=mysql_num_rows($res);


  $laststat=mysql_result($res,0,"max(endDate)");
//  echo "laststat=$laststat<br>";

  $bytes=calcservice($username,$username,$sd,$ed);
  $gamebytes=calcservice($username,"$username"."_game",$sd,$ed);
  $chatbytes=calcservice($username,"$username"."_chat",$sd,$ed);
//  echo "<br>!!!bytes=$bytes gamebytes=$gamebytes chatbytes=$chatbytes sd=$sd ed=$ed <br>";

// Начало выборки подчиненных записей 
      $down="SELECT dogovor.domen FROM summary, dogovor WHERE parent = $dogid AND dogovor.id = summary.dogid AND sdate = '$sd' ";
      $downres=mysql("mvs",$down);
      $down_num=mysql_num_rows($downres);
      if ($down_num > 0) {
        for($down_i=0;$down_i < $down_num;$down_i++) {
          $down_username=mysql_result($downres,$down_i,"dogovor.domen");

          $down_bytes=calcservice($down_username,$down_username,$sd,$ed);
          $down_gamebytes=calcservice($down_username,"$down_username"."_game",$sd,$ed);
          $down_chatbytes=calcservice($down_username,"$down_username"."_chat",$sd,$ed);

          $bytes=$bytes+$down_bytes;
          $gamebytes=$gamebytes+$down_gamebytes;
          $chatbytes=$chatbytes+$down_chatbytes;
        }
      }
      
// ╬ъюэўрэшх т√сюЁъш яюфўшэхээ√ї чряшёхщ  6.09.2004

  $summ=sprintf("%10.0f",$bytes-$gamebytes-$chatbytes);
//  echo "summ=$summ<br>";
  if ($summ < 0 ) $summ=0;
  
  $total=sprintf("%10.0f",$total+$summ);
//  echo "<br>total=$total<br>";

  $daylimit=sprintf("%16.5f",$porog/$dayOfMonth);

  $limit=sprintf("%16.5f",$daylimit*$days);
  if ($limit > $total) {
    $money=0;
  } else {
    $money=sprintf("%16.5f",($limit-$total)/1024/1024*$mb);
  }
//  echo "<br>money=$money<br>";

// include('calc.inc');

// ┬√сюЁър єёыєу чр яхЁшюф
$query="SELECT services.servid, sum(services.summa) as s, typeservice.description, count(  *  )  AS q FROM services, typeservice WHERE services.servid = typeservice.servid AND servdate >=  '$sd' AND servdate <=  '$ed' and username like '$username' GROUP  BY servid";
// echo $query;
$servtotal=0;
$ress=mysql("mvs",$query);
if (mysql_error()) echo "8a.".mysql_error();
$num=mysql_num_rows($ress);
if ($num) {
  $servtotal=0;
  for ($si=0;$si<$num;$si++) {
    $servtotal=$servtotal+sprintf("%8.2f",mysql_result($ress,$si,"s"));
//    echo "servtotal=".$servtotal."<br>";
  }
}
// echo "num=$num servtotal=$servtotal";

// ╬ъюэўрэшх т√сюЁъш єёыєу чр яхЁшюф


$query="select sum(summa) as summ from payment where username like '$username'  and date >= '$sd' and date <= '$ed'";
// echo $query;
$res=mysql("mvs",$query);
if (mysql_error()) echo "9.".mysql_error();

$num=mysql_num_rows($res);
if ($num) {
  $pay=sprintf("%8.2f",mysql_result($res,0,"summ"));
  $query="select * from payment where username like '$username' and date >= '$sd' and date < '$ed' order by date";
  $res=mysql("mvs",$query);
  if (mysql_error()) echo "10.".mysql_error();
  $numpays=sprintf("%8.2f",mysql_num_rows($res));
}
if ($money > 0 ) $money=0; 
$money=sprintf("%8.2f",$money);
// $endTotal=sprintf("%8.2f",$start+$abon+$money+$pay-$servtotal); old
$endTotal=sprintf("%8.2f",$start+$abon+$money+$pay-$servtotal); // 6/09/2004
// echo "daysFromLastBalans=$daysFromLastBalans totalDays=$totalDays dayOfMonth=$dayOfMonth";
if (((($daysFromLastBalans > $dayOfMonth)) || ($insert==1)) && ($daysFromLastBalans > 1)) {
  $loop=1;
  $begquery="INSERT INTO begstat(dogid,date,summa) VALUES($dogid,'$ed',$endTotal)";
  $bres=mysql("mvs",$begquery);
  if (mysql_error()) echo "11.$username".mysql_error();
} else {
  $loop=0;
}
$total=sprintf("%8.3f",$total/1024/1024);
// echo "<br>total=$total<br>";
  $set="update summary set status=0 where username like '$username'";
  echo $set;
  $balance=mysql("mvs",$set);
  if (mysql_error()) echo "12.".mysql_error();
  $gamemb=sprintf("%10.3f",$gamebytes/1024/1024);
  $chatmb=sprintf("%10.3f",$chatbytes/1024/1024);
  $set="insert into summary(dogid,username,tarif,beginstat,mbyte,gamemb,chatmb,cost,abonplata,days,payments,numpay,sdate,edate,laststat,total,status) values ($dogid,'$username',$tarif,$start,$total,$gamemb,$chatmb,$money,$abon,$days,$pay,$numpays,'$sd','$ed','$laststat',$endTotal,1)";
  echo $set;

  $balance=mysql("mvs",$set);
//  echo "<br>!!$set<br>";
  if (mysql_error()) echo "<br>!! $set <br>13.".mysql_error();
  if (mysql_error()) {
    $set="update summary set laststat='$laststat',tarif=$tarif,status=1,mbyte=$total,gamemb=$gamemb,chatmb=$chatmb,cost=$money,days=$days,numpay=$numpays,payments=$pay,edate='$ed',total=$endTotal,abonplata=$abon where dogid=$dogid and username like '$username' and beginstat=$start and sdate= '$sdd'";
//    $set="update summary set laststat='$laststat',tarif=$tarif,status=1,mbyte=$total,gamemb=$gamemb,chatmb=$chatmb,cost=$money,days=$days,numpay=$numpays,payments=$pay,edate='$ed',total=$endTotal,abonplata=$abon where dogid=$dogid and username like '$username' and sdate like '$sdd'";
    $balance=mysql("mvs",$set);
//    echo "<br>!!$set<br>";
  if (mysql_error()) echo "<br>!! $set 14.".mysql_error();
    if (mysql_error()) echo "15.".mysql_error();
  } else {
//    echo $set;
  }
  if ($endTotal < 0) {
//    echo "status=$status";
    switch ($status) {
      case 0:
        $query="update customers set access=0 where username like '$username'";
        $res=mysql("mvs",$query);
        if (mysql_error()) echo "16.".mysql_error();
        break;
      case 1:
        $query="select * from customers where username like '$username' and dateStop not like '0000-00-00 00:00:00' and now() < dateStop";
        $res=mysql("mvs",$query);
        if (mysql_error()) echo "17.".mysql_error();
        $num=mysql_num_rows($res);
        if ($num > 0) {    
          $query="update customers set access=0 where username like '$username'";
          $res=mysql("mvs",$query);
          if (mysql_error()) echo "18.".mysql_error();
        } else {
          $query="update customers set access=1 where username like '$username'";
          $res=mysql("mvs",$query);
          if (mysql_error()) echo "19.".mysql_error();
        }
        break;
      case 2:
        $query="update customers set access=1 where username like '$username'";
        $res=mysql("mvs",$query);
        if (mysql_error())  echo "20.".mysql_error();
        break;
      case 4:
        
        $query="update customers set access=1 where username like '$username'";
        $res=mysql("mvs",$query);
        if (mysql_error())  echo "20.".mysql_error();
        break;
    }
  } else {
     $query="update customers set access=0 where username like '$username'";
     $res=mysql("mvs",$query);
     if (mysql_error()) echo "21.".mysql_error();
  }


}
}

?>