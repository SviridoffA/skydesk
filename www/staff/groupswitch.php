<?php

class groupswitch {
//  private $sysDescroid="SNMPv2-MIB::sysDescr.0";
  private $sysDescroid="iso.3.6.1.2.1.1.1.0";

   public function info($ip,$community) {
      echo "ip=$ip community=$community\n";
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
      $res=mysql("sky_switch",$query);
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


  public function cfg_mrtg_all_switch() {
    $cfg="";
    $query="select * from switch where status=1  and ip not like '10.77.77.3' order by ip";
    $res=mysql("mvs",$query);
    $num=mysql_num_rows($res);
    for ($i=0;$i<$num;$i++) {
      $ip=mysql_result($res,$i,"ip");
      $community=mysql_result($res,$i,"community");
      $this->community=$community;
/*
      echo "ip=$ip\n";
      echo $this->info($ip,$community);
      echo "\n";
*/
//      $cfg=$cfg.$this->cfg_mrtg_port_all($ip,$community);
    }
    return($cfg);
  }


  public function error_all_switch() {

    $cfg="";
    $query="select * from switch where status=1 order by ip";
    $res=mysql("sky_switch",$query);
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
          $template="edgecore3528";
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

          $b=new switchoid();
          break;
      }
      $b->community=$community;
      $mem=$b->ports_error($ip);
      $this->save_db_error($mem);

    }
    return($cfg);
  }



  public function mrtg_all_switch() {
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
          $template="dlink";
          $b=new dlink();
          break;
        case "D-Link DES-3200-28F Fast Ethernet Switch":
          $template="dlink";
          $b=new dlink();
          break;
        case "DES-3200-28F Fast Ethernet Switch":
          $template="dlink";
          $b=new dlink();
          break;
        case "DES-3526 Fast-Ethernet Switch":
          $template="dlink";
          $b=new dlink();
          break;
        case "D-Link DES-3028 Fast Ethernet Switch":
          $template="dlink";
          $b=new dlink();
          break;
        case "Edge-Core FE L2 Switch ES3528M":
          $template="edgecore3528";
          $b=new edgecore3528();
          break;
        case "ES3528M":
          $template="edgecore3528";
          $b=new edgecore3528();
          break;
        case "ES3510MA":
          $template="edgecore3526";
          $b=new edgecore3526();
          break;
        case "Layer2+ Fast Ethernet Standalone Switch ES3510":
          $template="edgecore3526";
          $b=new edgecore3526();
          break;
        case "Layer2+ Fast Ethernet Standalone Switch ES3526XA":
          $template="edgecore3526";
          $b=new edgecore3526();
          break;
        case "PLANET WGSD-1022 - 8+2G Managed Switch":
          $template="wgsd1022";
          $b=new wgsd1022();
          break;
        case "ES4624-SFP Device":
          $template="edgecore4624";
          $b=new edgecore4624();
          break;
        default:
          if (strlen(strstr($id,"ES4624-SFP Device, Compiled Aug 24 15:32:08 2009" )) > 10) {
            $template="edgecore4624";
            $b=new edgecore4624();
          } else 
//          195.72.157.250 default Cisco IOS Software, C3750 
//          195.72.157.251 default Switch Device, Compiled Jan 07 10:04:24 2011
//          195.72.157.252 default Cisco IOS Software, 3800 
//          195.72.157.254 default Cisco IOS Software, 7200
          if (strlen(strstr($id,"Switch Device, Compiled Jan 07 10:04:24 2011" )) > 10) {
            $template="edgecore4624";
            $b=new edgecore4624();
          } else 
          if (strlen(strstr($id,"Cisco IOS Software, C3750" )) > 10) {
            $template="cisco3750";
            $b=new cisco3750();
          } else 
          if (strlen(strstr($id,"Cisco IOS Software, 3800" )) > 10) {
            $template="cisco";
            $b=new cisco();
          } else 
          if (strlen(strstr($id,"Cisco IOS Software, 7200" )) > 10) {
            $template="cisco";
            $b=new cisco();
          } else 
          
          {
            $template="default";
            $b=new switchoid();
          }          
          break;
      }
      $fp=fopen("desc.txt","a");
      fputs($fp,"$ip $template $id\n");
      fclose($fp);
      $b->community=$community;
      $cfg=$cfg.$b->cfg_mrtg_port_all($ip,$community);

    }
    return($cfg);
  }

  public function info_all_switch() {
    $cfg="";
    $query="select * from switch where status=1 order by ip";
    $res=mysql("mvs",$query);
    $num=mysql_num_rows($res);
    for ($i=0;$i<$num;$i++) {
      $ip=mysql_result($res,$i,"ip");
      $name=mysql_result($res,$i,"name");
      $community=mysql_result($res,$i,"community");
      $this->community=$community;
      $id=$this->info($ip,$community);
      $b=new switchoid();
      $b->community=$community;
      echo "$ip $name ".$b->info($ip)."\n";
    }
    return($cfg);
  }

  public function save_all_cfg() {

    $cfg="";
    $query="select * from switch where status=1  order by ip";
    $res=mysql("mvs",$query);
    $num=mysql_num_rows($res);
    for ($i=0;$i<$num;$i++) {
      $ip=mysql_result($res,$i,"ip");
      $community=mysql_result($res,$i,"rwcommunity");
      $this->community=$community;
      $id=$this->info($ip,$community);
      echo "ip=$ip id=$id\n";
      $size=0;
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
          $answer=1;
          $b=new dlink();
          break;
        case "D-Link DES-3028 Fast Ethernet Switch":
          $answer=1;
          $b=new dlink();
          break;
       case "Edge-Core FE L2 Switch ES3528M":
          $answer=1;
          $b=new edgecore3528();
          break;
       case "ES3528M":
          $answer=1;
          echo "selected ES3528\n";
          $b=new edgecore3528();
          break;
        case "ES3510MA":
          $b=new edgecore3526();
          break;
        case "Layer2+ Fast Ethernet Standalone Switch ES3510":
          $answer=1;
          $b=new edgecore3526();
          break;
        case "Layer2+ Fast Ethernet Standalone Switch ES3526XA":
          $answer=1;
          $b=new edgecore3526();
          break;
        case "PLANET WGSD-1022 - 8+2G Managed Switch":
          $answer=1;
          $b=new wgsd1022();
          break;
        case "ES4624-SFP Device":
          $b=new edgecore4624();
          break;
        case "":
          $answer=0;
          break;  
        default:
//          $b=new switchoid();
          break;
      }
      if ($answer) {
        $b->community=$community;
        if (file_exists("/tftpboot/$ip")) {
          } else {
          $fp=fopen("/tftpboot/$ip","w");
          fclose($fp);
          chmod("/tftpboot/$ip",0666);
          echo "file $ip created\n";
          
        }
        $cfg=$cfg.$b->savetotftp($ip,$ip,"195.72.157.253");
        sleep(30);
        $size=filesize("/tftpboot/$ip");
        echo "size $ip =$size bytes\n";
        if ( $size > 2000 ) {
          copy("/tftpboot/$ip","/tftpboot/base/$ip");
        } 
        if ($size < 2000) {
          $cfg=$cfg.$b->savetotftp($ip,$ip,"10.90.90.4");
//          sleep(30);
          $size=filesize("/tftpboot/$ip");
          echo "size $ip =$size bytes\n";
          if ( $size > 2000 ) {
            copy("/tftpboot/$ip","/tftpboot/base/$ip");
          } 
          if ($size < 2000) {
            $cfg=$cfg.$b->savetotftp($ip,$ip,"10.195.58.248");
//            sleep(30);
            $size=filesize("/tftpboot/$ip");
            echo "size $ip =$size bytes\n";
            if ( $size > 2000 ) {
              copy("/tftpboot/$ip","/tftpboot/base/$ip");
            } 
          }
        }
      }

    }
  }



}
?>