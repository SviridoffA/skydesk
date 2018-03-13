<?php
class cisco3750 extends switchoid{
// community
   public $community='public';

   function savetotftp($ip,$file,$tftp) {
     
// snmpset -v 1 -c private 195.72.157.250 .1.3.6.1.4.1.9.2.1.55.195.72.157.253 string 3560

      snmpset($ip,$this->community,".1.3.6.1.4.1.9.2.1.55.$tftp","string", $file);

   }


   function cfg_mrtg_port($ip,$port,$community) {
     $desc=$this->descport($ip,$port);
     $mac=$this->macport($ip,$port);
     $alias=$this->aliasport($ip,$port);
     $type=$this->typeport($ip,$port);

//     echo $type;
     $speed=125000000;

//     $speed=$this->speedport($ip,$port);

     $str="";
//     echo "port=$port \n";
     if ($port < 10000 ) return($str);
     
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
     return($str);
  }




  function cfg_mrtg_port_all($ip,$community) {
    $port=$this->ports($ip);
    $num=count($port);
//    if ($num > 10000) $num=10;
    for ($i=0;$i<$num;$i++) {
      $index=$port[$i];
      $index=ereg_replace("INTEGER: ","",$index);
      $cfg=$cfg.$this->cfg_mrtg_port($ip,$index,"tenretni");
    }
    return($cfg);
  }


}

?>