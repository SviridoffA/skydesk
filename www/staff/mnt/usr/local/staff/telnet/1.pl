#!/usr/bin/perl 
           
my ($forecast, $t);

use Net::Telnet ();
$t = new Net::Telnet;
$t->open("10.90.90.96");

           
## Wait for first prompt and "hit return".
##($ret) = $t->waitfor('/\t/');
$ok = $t->cmd("rjycek");
print $ok;
##$t->print("rjycek");

           
## Wait for second prompt and respond with city code.
##$t->waitfor('/DES-2108.*$/');
$t->print("show stp");

## Read and print the first page of forecast.
($forecast) = $t->waitfor('/[ \t]+press return to continue/i');
print $forecast;
exit;
