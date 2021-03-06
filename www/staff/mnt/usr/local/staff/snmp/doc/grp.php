<?php

class groupswitch {
  private $sysDescroid="SNMPv2-MIB::sysDescr.0";

   public function info($ip,$community) {
      $data=snmpget($ip,$community,$this->sysDescroid);
      $data=ereg_replace("STRING: ","",$data);
      return($data);
   }
  
  public function print_forward($mem) {
    $num=count($mem);
//    var_dump($mem);
    for ($i=0;$i<$num;$i++) {
      $port=$mem[$i][1];
      $n=$mem[$i][2];
      $ip=$mem[$i][0];
      if (($n == 5) || ($n==6) || ($n==1)) {
//        echo "$ip $port $n\n";
      } else {
        echo "$ip $port $n\n";
      }
    }
  }

  public function print_error($mem) {
    $num=count($mem);
//    var_dump($mem);
    for ($i=0;$i<$num;$i++) {
      $ip=$mem[$i][0];
      $port=$mem[$i][1];
      $n=$mem[$i][2];
      $n1=$mem[$i][3];
      if (($n != 0) || ($n1 !=0))        echo "$ip $port $n $n1\n";
    }
  }

  public function save_db_error($mem) {
    $num=count($mem);
    for ($i=0;$i<$num;$i++) {
      $ip=$mem[$i][0];
      $port=$mem[$i][1];
      $n=trim($mem[$i][2]);
      $n1=trim($mem[$i][3]);
      $query="select * from errors where ip like '$ip' and port like '$port' order by sdate desc";
      $res=mysql("mvs",$query);
      $nrec=mysql_num_rows($res);
      if ($nrec == 0) {
        $query="insert into errors(sdate,ip,port,inerror,outerror,deltain,deltaout) VALUES (now(),'$ip','$port','$n','$n1',0,0)";
        $res=mysql("mvs",$query);
      } else {
        $inerror=trim(mysql_result($res,0,"inerror"));
        $outerror=trim(mysql_result($res,0,"outerror"));
        $deltain=$n-$inerror;
        $deltaout=$n1-$outerror;
//        echo "nrec=$nrec newinerror=$n newouterror=$n1 inerror=$inerror outerror=$outerror deltain=$deltain deltaout=$deltaout\n";
        
        if (($deltain != 0) || ($deltaout != 0)) {
          $query="insert into errors(sdate,ip,port,inerror,outerror,deltain,deltaout) VALUES (now(),'$ip','$port','$n','$n1',$deltain,$deltaout)";
          $res=mysql("mvs",$query);
        }
      }
    }
//    $this->print_error($mem);
  }

  public function stp_all_switch() {
    $cfg="";
    $query="select * from switch where status=1 order by ip";
    $res=mysql("mvs",$query);
    $num=mysql_num_rows($res);
    for ($i=0;$i<$num;$i++) {
      $ip=mysql_result($res,$i,"ip");
      $community=mysql_result($res,$i,"community");
      $this->community=$community;
      $id=$this->info($ip,$community);
      switch ($id) {
        case "DES-3226S Fast-Ethernet Switch":
          $b=new dlink();
          break;
        case "D-Link DES-3200-28F Fast Ethernet Switch":
          $b=new dlink();
          break;
        case "DES-3200-28F Fast Ethernet Switch":
          $b=new dlink();
          break;
        case "DES-3526 Fast-Ethernet Switch":
          $b=new dlink();
          break;
        case "D-Link DES-3028 Fast Ethernet Switch":
          $b=new dlink();
          break;
        case "Edge-Core FE L2 Switch ES3528M":
          $b=new edgecore3528();
          break;
        case "ES3528M":
          $b=new edgecore3528();
          break;
        case "ES3510MA":
          $b=new edgecore3526();
          break;
        case "Layer2+ Fast Ethernet Standalone Switch ES3510":
          $b=new edgecore3526();
          break;
        case "Layer2+ Fast Ethernet Standalone Switch ES3526XA":
          $b=new edgecore3526();
          break;
        case "PLANET WGSD-1022 - 8+2G Managed Switch":
          $b=new wgsd1022();
          break;
        case "ES4624-SFP Device":
          $b=new edgecore4624();
          break;
        default:
          break;
      }
          $b->community=$community;
          $mem=$b->switch_stp_status($ip);
          $this->print_forward($mem);
    }
    return($cfg);
  }



} // end class
?>