#!/usr/bin/perl
## Main program.
           {
               my ($pty, $ssh, @lines);
               my $host = "10.90.90.95";
               my $user = "rjycek";
               my $password = "";
               my $prompt = '/DES~> $/';

               ## Start ssh program.
               $pty = &spawn("ssh", "-l", $user, $host);  # spawn() defined below

               ## Create a Net::Telnet object to perform I/O on ssh's tty.
               use Net::Telnet;
               $ssh = new Net::Telnet (-fhopen => $pty,
                                       -prompt => $prompt,
                                       -telnetmode => 0,
                                       -cmd_remove_mode => 1,
                                       -output_record_separator => "\r");

               ## Login to remote host.
               $ssh->waitfor(-match => '/password: ?$/i',
                             -errmode => "return")
                   or die "problem connecting to host: ", $ssh->lastline;
               $ssh->print($password);
               $ssh->waitfor(-match => $ssh->prompt,
                             -errmode => "return")
                   or die "login failed: ", $ssh->lastline;

               ## Send command, get and print its output.
               @lines = $ssh->cmd("who");
               print @lines;

               exit;
           } # end main program

           sub spawn {
               my(@cmd) = @_;
               my($pid, $pty, $tty, $tty_fd);

               ## Create a new pseudo terminal.
               use IO::Pty ();
               $pty = new IO::Pty
                   or die $!;

               ## Execute the program in another process.
               unless ($pid = fork) {  # child process
                   die "problem spawning program: $!\n" unless defined $pid;

                   ## Disassociate process from existing controlling
terminal.
                   use POSIX ();
                   POSIX::setsid
                       or die "setsid failed: $!";

                   ## Associate process with a new controlling terminal.
                   $tty = $pty->slave;
                   $tty_fd = $tty->fileno;
                   close $pty;

                   ## Make stdio use the new controlling terminal.
                   open STDIN, "<&$tty_fd" or die $!;
                   open STDOUT, ">&$tty_fd" or die $!;
                   open STDERR, ">&STDOUT" or die $!;
                   close $tty;
                   ## Execute requested program.
                   exec @cmd
                       or die "problem executing $cmd[0]\n";
               } # end child process

               $pty;
           } # end sub spawn
