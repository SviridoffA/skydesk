<?php
function readdata($username,$service,$sdate,$edate) {
//     echo "start";
     $defaultStatus=1;
     $date=$sdate;
     if ($edate) {
       $date=$date."-".$edate;
     }
     $query="select serverstat from customers where username like '$username'";
     $res=mysql("mvs",$query);
     echo mysql_error();
     $serverstat=mysql_result($res,0,"serverstat");
//     echo "serverstat=$serverstat\n";
     switch ($serverstat) {
         case 2:
           $pp=popen("/usr/local/bin/ipastat -e -r $service -t -i $date -n","r");
//           $pp=fopen("http://195.58.229.194/stat/t.html?login=$service&date=$date&submit=yes","r");
//           echo "http://195.58.229.194/stat/t.html?login=$service&date=$date&submit=yes\n";
           break;
         default:
           $pp=popen("/usr/local/bin/ipastat -e -r $service -t -i $date -n","r");
//           echo "/usr/local/bin/ipastat -e -r $service -t -i $date -n";
           break;
     }
     $i=1;
     if (!$pp) return;
     while (!feof($pp)) {
//       echo "$username\n";
       $i++;
       $str=fgets($pp,1024);
       echo $str."<br>";
       if ($i > 2) {
         $mem=array();
         $mem=explode(" ",$str);
         $num=count($mem);
         if ($num = 5) {
           if ($mem[2] == "24:00:00") $mem[2]="23:59:59";
           $ds=$mem[0]." ".$mem[1];
           $de=$mem[0]." ".$mem[2];
           $bytes=$mem[3];
           $query="INSERT INTO data(username,startDate,endDate,bytes,service,status) VALUES('$username','$ds','$de',$bytes,'$service',$defaultStatus)";
//           echo $query."\n";
           mysql("mvs",$query);
           if  (mysql_error()) {
              $query="update data set bytes='$bytes',endDate='$de',status=$defaultStatus where service like '$service' and startDate='$ds' and username like '$username'";
//              echo $query."\n";
              mysql("mvs",$query);
              $str=mysql_error();
              if ($str) {
                echo $query."\n";
                echo $str."\n";
              }
           }
         } 

       }
     }
     switch ($serverstat) {
         case 2:
           fclose($pp);
           break;
         default:
           pclose($pp);
           break;
     }
}   
?>