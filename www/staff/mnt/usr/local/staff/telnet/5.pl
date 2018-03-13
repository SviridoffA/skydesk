#!/usr/bin/perl
          my ($hostname, $line, $passwd, $pop, $username);

           $hostname = "10.90.90.96";
           $username = "rjycek";
           $passwd = "CaptonOne";

           use Net::Telnet ();
           $pop = new Net::Telnet (Telnetmode => 0);
           $pop->open(Host => $hostname,
                      Port => 23);

           ## Read connection message.
           $line = $pop->getline;
           print $line;
           die $line unless $line =~ /^\Password:/;

           ## Send user name.
           $pop->print("$username");
           $line = $pop->getline;
           die $line unless $line =~ /^\DES/;

           ## Send password.
           $pop->print("show stp");
           $line = $pop->getline;
           die $line unless $line =~ /^\DES/;

           ## Request status of messages.
           $pop->print("list");
           $line = $pop->getline;
           print $line;

           exit;
