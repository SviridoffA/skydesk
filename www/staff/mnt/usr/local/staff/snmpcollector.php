#!/usr/local/bin/php -q
<?php
/*
SNMPCollector - A small script that collects counters from routers/switches

Check for new versions on www.theworldsend.net

I needed a simple script that collects in and out octects of a switch interface 
counter into a database, so I can later run "average bandwidth" and 95th percentil
and other things on it. 

You will have to have the SNMP stuff in PHP working. If you run Linux, you
can call this script via cron. I use Windows, and use a software called
Firedaemon to run this script as a service. Check out the website at
www.theworldsend.net for more documentation how to call this script every
5 minutes under Windows.

You will need a MYSQL database with 2 tables. The first table is called 
"interfaces", which holds the IP, SNMPRead and Port information.

Table collector:

CREATE TABLE collector (ip varchar(15) NOT NULL ,
                        port varchar(10) NOT NULL,
												snmpread varchar(30) NOT NULL );

Table ifdata:

CREATE TABLE ifdata (id int(11) NOT NULL auto_increment,
  timestamp bigint(20) NOT NULL,
  ip varchar(15) NOT NULL,
  port varchar(10) NOT NULL,
  ifinoctets bigint(20) NOT NULL,
  ifoutoctets bigint(20) NOT NULL,
  indiff bigint(20) NOT NULL ,
  outdiff bigint(20) NOT NULL ,
  PRIMARY KEY  (`id`)
);

The second table ifdata will keep the results, and you can do your caculations on
that one. Default intervall is 300 seconds, if you want to change it remember
to change your cron or firedaemon to reflect this as well.

Questions via email...are welcome, but questions like "It doesn't work, how
to install SNMP support for PHP?" will be redirected to php.net. I might put it 
onto my webpage, www.theworldsend.net when I have TIME TIME TIME.

If you are patient with me, I might add a nice report-form that will query
exactly this table, and gives you average bandwidth/95th percentil, highest
traffic and so on for your time-range. 

Let me know if this would be something you need.
webmaster@theworldsend.net
*/ 
//how often is data reported, 300 = 5 minutes
$time_delta=300;
// database information
$db="noc";
$dbhost="localhost";
$dbuser="root";
$dbpass="#fdnjvfn45";
// end database information
// nothing to add/edit after this line
$dbconnect = mysql_pconnect($dbhost,$dbuser,$dbpass);
// connect to DB and get the data out of collector table
mysql_select_db($db, $GLOBALS["dbconnect"]);
$query="SELECT ip, port, snmpread FROM collector";
$result=mysql_query($query,$GLOBALS["dbconnect"]);
$num_of_rows = mysql_num_rows ($result) or die ("The query: '$query' did not return any data"); 
$now=time();

for ($count = 1; $row = mysql_fetch_row ($result); ++$count) 
    {
			 $prev_query="SELECT ifdata.ifinoctets, ifdata.ifoutoctets " .
			 "FROM ifdata WHERE ifdata.ip = '$row[0]' " .
			 " AND ifdata.port = '$row[1]' ORDER BY ifdata.timestamp DESC"; 
			 $prev_db=mysql_query($prev_query,$GLOBALS["dbconnect"]);  
                         echo mysql_error();
       $prev_row=mysql_fetch_row($prev_db); //or die ("The query: $prev_query did not return any data");

       $inoctets=snmpget($row[0],$row[2],"interfaces.ifTable.ifEntry.ifInOctets.".$row[1]);
       $inoctets=ereg_replace("Counter32: ","",$inoctets);
       $outoctets=snmpget($row[0],$row[2],"interfaces.ifTable.ifEntry.ifOutOctets.".$row[1]);
       $outoctets=ereg_replace("Counter32: ","",$outoctets);
       echo  $inoctets."\n";
       echo  $outoctets."\n";
         
       if ($prev_row[0] == '') {$prev_row[0] = $inoctets;};
       if ($prev_row[1] == '') {$prev_row[1] = $outoctets;};
       $diff_in  = ($inoctets  - $prev_row[0]);
       $diff_out = ($outoctets - $prev_row[1]);
       $update_query="INSERT INTO ifdata VALUES (0,'$now','$row[0]','$row[1]','$inoctets','$outoctets','$diff_in','$diff_out')";
       $update_db=mysql_query($update_query,$GLOBALS["dbconnect"]);
    };
?>