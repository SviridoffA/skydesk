<?php
function packets($user,$interface) {
  $str="rsh -l sl 195.72.157.254 show int $interface"; 
  $pp=popen($str,"r");
  while (!feof($pp)) {
    $s=fgets($pp,1024);
    $s=trim($s);
//    echo $s."\n";
    preg_match("/5 minute input rate ([\d]+) bits\/sec, ([\d]+) packets/",$s,$matches);
    $n=count($matches);
    if ($n > 2 ) {
//       var_dump($matches);
       $bytesin=$matches[1];
       $packetin=$matches[2];
       if ($packetin > 0 ) {
         $lenin=sprintf("%d",(int)$bytesin/(int)$packetin/8);
       } else {
         return;
       }
    }
    preg_match("/5 minute output rate ([\d]+) bits\/sec, ([\d]+) packets/",$s,$matches);
    $n=count($matches);
    if ($n > 2 ) {
//       var_dump($matches);
       $bytesout=$matches[1];
       $packetout=$matches[2];
       $lenout=$bytesout/$packetout/8;
       if ($packetout > 0 ) {
         $lenout=sprintf("%d",(int)$bytesout/(int)$packetout/8);
       } else {
         return;
       }
    }

  }
  if (($bytesin > 1000000) | ($bytesout > 1000000)) {
    echo "$interface $user $bytesin $packetin $lenin $bytesout $packetout $lenout\n";
  }
}

$str="rsh -l sl 195.72.157.254 show users";
$pp=popen($str,"r");
while (!feof($pp)) {
  $s=trim(fgets($pp,1024));
  preg_match("/([Vi\d]+)([\w\W\d]+)PPPoVPDN([\w\W]+)/",$s,$matches);
  if ($i > 8) {
//    echo $s;
    $interface=$matches[1];
    $user=trim($matches[2]);
//    var_dump($matches);
    packets($user,$interface);

  }
  $i++;
//  if ($i >10 ) exit;  
}
?>