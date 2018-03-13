#!/usr/local/bin/php -q
<?php
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$query="select distinct username from summary";
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
$k=1;
for ($i=0;$i < $num;$i++) {
  $username=mysql_result($res,$i,"username");

  $subquery="select * from summary where username like '$username' and status != 1 order by sdate desc limit 2";
  $subres=mysql("mvs",$subquery);
  $nn=mysql_num_rows($subres);
  echo mysql_error();
  $mb=0;
  $payment=0;
  $cost=0;
  for ($j=0;$j < $nn;$j++) {
    if ($j==0) $abonplata=mysql_result($subres,0,"abonplata");  
    $mb=$mb+mysql_result($subres,0,"mbyte");  
    $payment=$payment+mysql_result($subres,0,"payments");  
    $cost=$cost+mysql_result($subres,0,"cost");  
  }
  if ($mb != 0)  $mb=$mb/($j);
    $mb=sprintf("%d",$mb);
  if ($payment != 0) $payment=$payment/($j);
  if ($cost != 0) $cost=$cost/($j);
//  $cost=sprintf("%8.2f",$cost);
  if (($mb >0)||($payment > 0))   {
    echo "$k,$username,$mb,$payment,$abonplata,$cost\n";
    $k=$k+1;
  
  }
//  exit;
}
?>