#!/usr/local/bin/php -q
<?php
$str="/bin/ps -xa";
$pp=popen($str,"r");
while (!feof($pp) ) {
  $line=fgets($pp,1024);
  if (strlen(strstr($line,"/usr/local/bin/ipa")) >= 19) { 
//    echo strlen(strstr($line,"/usr/local/bin/ipa"));
    $i++;
  }
} 
if ($i < 1) { 
   mail("msl@mariupol.net","ipa down","ipa down");
}
echo $i;
?>