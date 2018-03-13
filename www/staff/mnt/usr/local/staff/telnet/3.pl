#!/usr/bin/perl
          my ($hostname, $line, $passwd, $pop, $username);

           $hostname = "10.90.90.95";
           $username = "rjycek";
           $passwd = "show stp";

           use Net::Telnet ();
           $pop = new Net::Telnet (Telnetmode => 0);
           $pop->open(Host => $hostname,
                      Port => 23);

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
