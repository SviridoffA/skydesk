#!/usr/local/bin/php -q
<?php
$in = snmpget("195.58.229.229", "tenretni", "interfaces.ifTable.ifEntry.ifInOctets.108");
$out = snmpget("195.58.229.229", "tenretni", "interfaces.ifTable.ifEntry.ifOutOctets.108");
$input=explode(" ",$in);
$output=explode(" ",$out);
$min=$input[1];
$mout=$output[1];
echo "$min $mout";
?>