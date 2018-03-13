#!/usr/local/bin/php -q
<?php
include('function.inc');
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
if ($argc > 1) {
  $username=$argv[1];
  echo "$username\n";
  balans($username);
  
} else {
  echo "usage: balans.php username\n";
}
?>