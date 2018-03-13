<?php

class dlink extends switchoid {

// oid for get mac address and port from witch
   private $snmpmac = '1.3.6.1.2.1.17.4.3.1.2';
   private $snmp_forward_transition = '1.3.6.1.2.1.17.2.15.1.10';
   private $snmp_stp_status = '1.3.6.1.2.1.17.2.15.1.3';
   private $tftp = "195.72.157.253";

// community
   public $community='private';


   function getmac($ip) {
     $a=snmpwalkoid($ip,$this->community,$this->snmpmac);

     for (reset($a); $i = key($a); next($a)) {
//       preg_match
       
       echo "$i: $a[$i]\n";
     }

 
   }

   function switch_stp_status($ip) {

//     echo "ip=$ip\n";
     $a=snmpwalkoid($ip,$this->community,$this->snmp_stp_status);
//     echo "snmpwalk\n";
     $j=0;
     for (reset($a); $i = key($a); next($a)) {
       $s1=$i;
       $s2=$a[$i];
       $s1=ereg_replace("SNMPv2-SMI::mib-2.17.2.15.1.3.","",$s1);     
       $s1=trim(ereg_replace(":","",$s1));     
       $s2=ereg_replace("Counter32: ","",$s2);     
       $s2=ereg_replace("INTEGER: ","",$s2);     
       $mem[$j][0]=$ip;
       $mem[$j][1]=$s1;
       $mem[$j][2]=$s2;
       $mem[$j][3]=$ft;
       $j++;
     }
     return($mem);
   }
   
   function speedport($ip,$port) {
      $data=snmpget($ip,$this->community,"IF-MIB::ifSpeed.$port");
      $data=ereg_replace("Gauge32: ","",$data);
      $str=$this->statusport($ip,$port);
      if ($str == "lowerLayerDown(7)") {
         if ($port > 24 ) {
           $data=$data/8*100;
         } else {
           $data=$data/8*10;
         }
      }
      return($data);
   }


   function savecfg($ipm,$file) {
     echo "savecfg($ip,$file)\n";
   } 

   function savetotftp($ip,$file,$tftp) {
     
// snmpset -v2c -c rwtenretni 10.90.90.31 1.3.6.1.4.1.259.6.10.94.1.24.1.3.0 i 4
// snmpset -v2c -c rwtenretni 10.90.90.31 1.3.6.1.4.1.259.6.10.94.1.24.1.6.0 a 10.90.90.4
// snmpset -v2c -c rwtenretni 10.90.90.31 1.3.6.1.4.1.259.6.10.94.1.24.1.4.0 s 90.31
// snmpset -v2c -c rwtenretni 10.90.90.31 1.3.6.1.4.1.259.6.10.94.1.24.1.8.0 i 2

// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.5.0 i 2 
// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.1.0 i 2
// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.3.0 i 4
// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.6.0 a 10.90.90.4 
// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.4.0 s 90.33 
// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.8.0 i 2



snmp2_set($ip,$this->community,"1.3.6.1.4.1.171.12.1.2.1.1.3.3","assress",$tftp);
snmp2_set($ip,$this->community,"1.3.6.1.4.1.171.12.1.2.1.1.4.3","integer",2);
snmp2_set($ip,$this->community,"1.3.6.1.4.1.171.12.1.2.1.1.5.3","string",$ip);


snmp2_set($ip,$this->community,"1.3.6.1.4.1.171.12.1.2.1.1.7.3","integer",2);

snmp2_set($ip,$this->community,"1.3.6.1.4.1.171.12.1.2.1.1.8.3","integer",3);

   }

  function get_forward_transition($ip) {
//     echo "ip=$ip\n";
     $a=snmpwalkoid($ip,$this->community,$this->snmp_forward_transition);
//     echo "snmpwalk\n";
     $j=0;
     for (reset($a); $i = key($a); next($a)) {
       $s1=$i;
       $s2=$a[$i];
       $s1=ereg_replace("SNMPv2-SMI::mib-2.17.2.15.1.10.","",$s1);     
       $s1=trim(ereg_replace(":","",$s1));     
       $s2=ereg_replace("Counter32: ","",$s2);     
       $s2=ereg_replace("INTEGER: ","",$s2);     
       $mem[$j][0]=$ip;
       $mem[$j][1]=$s1;
       $mem[$j][2]=$s2;
       $j++;
     }
     return($mem);
  }

   function cfg_mrtg_port($ip,$port,$community) {
     $desc=$this->descport($ip,$port);
     $mac=$this->macport($ip,$port);
     $alias=$this->aliasport($ip,$port);
     $type=trim($this->typeport($ip,$port));
     
//     echo $type;

     if ($port < 29) {
     switch ($type) {
       case "ethernetCsmacd(6)":
         $speed=12500000;
         break;
       case "gigabitEthernet(117)":
         $speed=125000000;
         break;
       default:
         if ($port > 24 ) {
           $speed=125000000;
         } else {
           $speed=12500000;
         }
         break;

     }
//     $speed=$this->speedport($ip,$port);
     $speeddesc=$speed/1000;
     $speeddesc=$speeddesc.".0 kBytes/s"; 
     $system=$this->info($ip);
     $str="### Interface $port >> Descr: '$desc' | Name: 'Port $port'| Ip: '' | Eth: '$mac' ###\n";
     $str=$str."Target[".$ip."_$port]: $port:".$this->community."@$ip:::::2\n";
     $str=$str."SetEnv[".$ip."_$port]: MRTG_INT_IP=\"\" MRTG_INT_DESCR=\"$desc\"\n";
     $str=$str."MaxBytes[".$ip."_$port]: $speed\n";
     $str=$str."Title[".$ip."_$port]: Traffic Analysis for $port -- $alias\n";
     $str=$str."PageTop[".$ip."_$port]: <h1>Traffic Analysis for $port -- $alias</h1>\n";
     $str=$str."  <div id=\"sysdetails\">\n";
     $str=$str."  <table>\n";
     $str=$str."    <tr><td>System:</td><td>$system</td></tr>\n";
     $str=$str."      <tr><td>Maintainer:</td><td></td></tr>\n";
     $str=$str."      <tr><td>Description:</td><td>$desc</td></tr>\n";
     $str=$str."      <tr><td>ifType:</td><td>$type</td></tr>\n";
     $str=$str."      <tr><td>ifName:</td><td>Port $port</td></tr>\n";
     $str=$str."      <tr><td>Max Speed:</td><td>$speeddesc</td></tr>\n";
     $str=$str."  </table></div>\n";
//     echo $str;
}
     return($str);
  }



  function save_forward_db($mem) {
    $num=count($mem);
    for ($i=0;$i<$num;$i++) {
      $ip=$mem[$i][0];
      $port=$mem[$i][1];
      $value=$mem[$i][2];
      $query="select * from stp where ip like '$ip' and port like '$port' order by sdate desc";
      $res=mysql("mvs",$query);
      echo mysql_error();
      $nn=mysql_num_rows($res);
      if ($nn > 0) {
        $ns=mysql_result($res,0,"num");
        echo "ip=$ip port=$port ns=$ns valu=$value\n";
        if ($ns != $value) {
          $delta=$value-$ns;
          $query="insert into stp(sdate,ip,port,num,delta) values(now(),'$ip','$port','$value','$delta')";
          $res=mysql("mvs",$query);
          $err=mysql_error();
          if (!empty($err)) {
            echo $query."\n$err\n";
//            exit;
          } 
        }
      } else {
        $query="insert into stp(sdate,ip,port,num,delta) values(now(),'$ip','$port','$value',0)";
        $res=mysql("mvs",$query);
          $err=mysql_error();
          if (!empty($err)) {
            echo $query."\n$err\n";
//            exit;
          } 
      }
    }   
 
  }

}
?>
