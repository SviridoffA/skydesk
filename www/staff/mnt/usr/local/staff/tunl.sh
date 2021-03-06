#!/bin/sh
/sbin/ifconfig gif0 destroy
/sbin/ifconfig gif0 create inet 10.195.64.1 10.195.64.2 netmask 255.255.255.252 tunnel 195.58.229.154 195.58.237.19 mtu 1500 up
/sbin/ifconfig gif1 destroy
/sbin/ifconfig gif1 create inet 10.195.64.5 10.195.64.6 netmask 255.255.255.252 tunnel 10.195.59.2 10.195.59.254 mtu 1500 up
/sbin/route add 10.195.64.1 127.0.0.1
/sbin/route add 10.195.64.5 127.0.0.1
#ifconfig xl0 delete 10.195.59.2
#arp -d 10.195.59.2[A
#route delete 10.195.59.0/24
#route add 10.195.59.0/24 10.195.64.2
/sbin/ipfw delete 2
/sbin/ipfw add 2 divert 8668 ip from 10.195.64.2 to any out xmit xl0
/sbin/ipfw delete 48000 48001 48002
/sbin/ipfw add 48000 divert 8668 ip from 192.168.201.0/24 to any out xmit xl0
/sbin/ipfw add 48001 divert 8668 ip from 192.168.202.2 to any out xmit xl0
/sbin/ipfw add 48002 divert 8668 ip from 192.168.202.6 to any out xmit xl0
/sbin/ipfw add 48003 divert 8668 ip from 192.168.202.10 to any out xmit xl0
/sbin/ipfw add 48004 divert 8668 ip from 192.168.202.14 to any out xmit xl0
/sbin/route delete 195.58.234.180
/sbin/route delete 195.58.234.164
/sbin/route delete 195.58.234.160
/sbin/route delete 192.168.201.0
#/sbin/route add 195.58.234.180/30 10.195.64.2
/sbin/route add 195.58.234.164/30 10.195.64.2
/sbin/route add 195.58.234.160/30 10.195.64.2
/sbin/route add 195.58.234.180/30 10.195.64.2
#/sbin/route add 195.58.241.240/28 10.195.64.2
/sbin/route add 195.58.241.224/28 10.195.64.2
/sbin/route add 192.168.201.0/24 10.195.64.2
