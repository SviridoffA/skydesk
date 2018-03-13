#!/usr/bin/perl
          my ($hostname, $line, $passwd, $pop, $username);

           $hostname = "195.58.229.154";
           $username = "sl";
           $passwd = "CaptonOne";

           use Net::Telnet ();
           $pop = new Net::Telnet (Telnetmode => 0);
           $pop->open(Host => $hostname,
                      Port => 110);

           ## Read connection message.
           $line = $pop->getline;
           die $line unless $line =~ /^\+OK/;

           ## Send user name.
           $pop->print("user $username");
           $line = $pop->getline;
           die $line unless $line =~ /^\+OK/;

           ## Send password.
           $pop->print("pass $passwd");
           $line = $pop->getline;
           die $line unless $line =~ /^\+OK/;

           ## Request status of messages.
           $pop->print("list");
           $line = $pop->getline;
           print $line;

           exit;
