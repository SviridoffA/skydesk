<?php
$fp=fopen("users2.log","r");
$i=0;
while (!feof($fp)) {
  $str=fgets($fp,1024);
  $mem=explode(" ",$str);
  $tm=(float)$mem[0];
  if ($i==0) $now=$tm;
  $v1=$mem[1];
  $v2=$mem[2];
  $v3=$mem[3];
  $v4=$mem[4];
  $k=($now-$tm)/86400;
  $s=100/($k+100);
  $vv1=sprintf("%d",$v1*$s);
  $vv2=sprintf("%d",$v2*$s);
  $vv3=sprintf("%d",$v3*$s);
  $vv4=sprintf("%d",$v4*$s);
//  var_dump($mem);
  if ($k > 100 ) {
      if ($tm > 0) echo "$tm 0 0 0 0\n";
  } else {
    if ($tm > 0) {
       if (!empty($vv3)) {
         echo "$tm $vv1 $vv2  $vv3 $vv4\n";
       } else {
         echo "$tm $vv1 $vv2  \n";
       }
  }     
  }
//  echo $str;
//  exit;
  $i++;
}

?>
