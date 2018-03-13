#!/usr/local/bin/php -q
<?php
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");

function get_comm($ip) {
  $query="select * from switch where ip like '$ip'";
  $res=mysql_query($query);
  echo mysql_error();
  $comm=mysql_result($res,0,"community");
  return($comm);
}

function snmpportnagios($switch,$ip,$port,$nameport,$community) {
$str="define service {
        use                     generic-service ; Inherit values from a template
        host_name               $switch
        service_description     $nameport Link Status 
        check_command           check_snmp!-C $community -o ifOperStatus.".$port." -r 1 -m RFC1213-MIB
                                
}
";

return($str);
}
function descsnmp($ip,$port,$community) {
 $patterns[0]='/STRING: /';
 $replacement[0]='';

 $desc=snmpget($ip,$community,"IF-MIB::ifAlias.$port");
 $desc=trim(preg_replace($patterns,$replacement,$desc))." port $port";

 $patterns[0]='/Wrong Type \(should be OCTET STRING\): NULL/';
 $replacement[0]='';

 $desc=trim(preg_replace($patterns,$replacement,$desc));
 return($desc);
}

function snmpport($ip,$switch) {
  $cfg="";
  $query="SELECT ipswitch, port, count( * ) as macs FROM switchmac1 WHERE cdate > '2014-10-21' AND ipswitch LIKE '$ip' AND port < 25  and port >0 GROUP BY ipswitch, port"; 
  $res=mysql_query($query);
  $num=mysql_num_rows($res);
  for ($i=0;$i<$num;$i++) {
    $port=mysql_result($res,$i,"port");
    $portcount=mysql_result($res,$i,"macs");
    if ($portcount > 1)  {
      $community=get_comm($ip); 
      $n=descsnmp($ip,$port,$community);
      if (strlen(strstr($n,"client")) < 5) {
        $cfg=$cfg.snmpportnagios($switch,$ip,$port,$n,$community);
//      echo "switch=$switch ip=$ip port=$port count=$portcount desc=$n\n";
      }
    }
  }
  return($cfg);
}

function rus2translit($string){    
$converter = array('à' => 'a',   'á' => 'b',   'â' => 'v',        'ã' => 'g',   'ä' => 'd',   'å' => 'e',        '¸' => 'e',   'æ' => 'zh',  'ç' => 'z',        'è' => 'i',   'é' => 'y',   'ê' => 'k',        'ë' => 'l',   'ì' => 'm',   'í' => 'n',        'î' => 'o',   'ï' => 'p',   'ð' => 'r',        'ñ' => 's',   'ò' => 't',   'ó' => 'u',        'ô' => 'f',   'õ' => 'h',   'ö' => 'c',        '÷' => 'ch',  'ø' => 'sh',  'ù' => 'sch',        'ü' => "",  'û' => 'y',   'ú' => "",        'ý' => 'e',   'þ' => 'yu',  'ÿ' => 'ya',         'À' => 'A',   'Á' => 'B',   'Â' => 'V',        'Ã' => 'G',   'Ä' => 'D',   'Å' => 'E',        '¨' => 'E',   'Æ' => 'Zh',  'Ç' => 'Z',        'È' => 'I',   'É' => 'Y',   'Ê' => 'K',        'Ë' => 'L',   'Ì' => 'M',   'Í' => 'N',        'Î' => 'O',   'Ï' => 'P',   'Ð' => 'R',        'Ñ' => 'S',   'Ò' => 'T',   'Ó' => 'U',        'Ô' => 'F',   'Õ' => 'H',   'Ö' => 'C',        '×' => 'Ch',  'Ø' => 'Sh',  'Ù' => 'Sch',        'Ü' => "",  'Û' => 'Y',   'Ú' => "",        'Ý' => 'E',   'Þ' => 'Yu',  'ß' => 'Ya', );    
return strtr($string, $converter);
}

function adr($address) {
$patterns[0]='/ /';
$replacement[0]='_';
  $len=strlen($address);
  if ($len > 2) {
    $str=preg_replace($patterns,$replacement,$address);
//    echo "len=$len $address\n";
//    exit;
  } else {
    $str=$address;
  }
  return($str);
}


function host($name,$ip) {
$str="
define host{
	use			generic-host		; Name of host template to use

	host_name		$name
	alias			$name
	address			$ip
	parents			statmvs
	check_command		check-host-alive
	max_check_attempts	10
	notification_interval	120
	notification_period	workhours
	notification_options	d,u,r
        contact_groups		admins
	}
";
  return($str);
}




function service($name) {
$str="
define service{
	use				generic-service		; Name of service template to use

	host_name			$name
	service_description		PING
	is_volatile			0
	check_period			24x7
	max_check_attempts		3
	normal_check_interval		5
	retry_check_interval		1
	contact_groups			admins
	notification_interval		240
	notification_period		workhours
	notification_options		c,r
	check_command			check_ping!100.0,20%!500.0,60%
	}
";

    return($str);
}

function hostgroup($hosts) {

$str="define hostgroup{
	hostgroup_name	equipment
	alias		equipment
        members		$hosts
}
";
  return($str);
} 

function names($ip,$address) {
 $patterns[0]='/.100/';
 $replacement[0]='';
  $ip=preg_replace($patterns,$replacement,$ip);

 $patterns[0]='/10./';
 $replacement[0]='';

  $ip=preg_replace($patterns,$replacement,$ip);
  $str=adr($address)."-".$ip;
  return($str);
}

mysql_select_db("mvs");
$query="select * from switch where status=1 and statusnagios=1 and ip !='10.10.10.10' order by address";
$res=mysql_query($query);
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $ip=mysql_result($res,$i,"ip");
  $address=mysql_result($res,$i,"address");
  $name=names($ip,$address);
  $name=rus2translit($name);
  $cfgport=snmpport($ip,$name);
  echo host($name,$ip);
  echo service($name);
  echo $cfgport;
  if ($i==0) {
    $str=$name;
  } else {
    $str=$str.",".$name;
  }
}
echo hostgroup($str);
?>
