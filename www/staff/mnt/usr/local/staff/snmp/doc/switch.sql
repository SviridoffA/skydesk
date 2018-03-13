-- MySQL dump 10.11
--
-- Host: 195.72.157.242    Database: mvs
-- ------------------------------------------------------
-- Server version	5.0.37-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `switch`
--

DROP TABLE IF EXISTS `switch`;
CREATE TABLE `switch` (
  `id` int(11) NOT NULL auto_increment,
  `idswitch` int(11) NOT NULL default '0',
  `port` int(11) NOT NULL default '0',
  `ip` char(80) NOT NULL default '',
  `type` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `address` varchar(80) NOT NULL,
  `snmpget` char(100) NOT NULL default '',
  `community` char(80) NOT NULL default '',
  `rwcommunity` varchar(64) NOT NULL,
  `snmpname` char(80) NOT NULL default '',
  `connected_to` int(11) NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `status` int(11) NOT NULL default '0',
  `stpstatus` int(11) NOT NULL default '0',
  `level` int(11) NOT NULL,
  `connected_switch` varchar(60) NOT NULL,
  `connected_port` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `switch`
--

LOCK TABLES `switch` WRITE;
/*!40000 ALTER TABLE `switch` DISABLE KEYS */;
INSERT INTO `switch` VALUES (6,0,0,'10.90.90.31',2,'edgecore3528','Ëåíèíà 74','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(7,0,0,'10.90.90.33',2,'edgecore3528','Ëåíèíà 74','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(3,2,6,'10.90.89.92',2,'edgecore3528','Õìåëüíèöêîãî 18','','tenretni','rwtenretni','',1,'2006-12-23',1,1,0,'',0),(46,0,0,'10.40.10.100',2,'DLINK3226S','Øåâ÷åíêî 80','','public','private','',0,'0000-00-00',0,0,0,'',0),(5,0,0,'10.90.89.93',2,'edgecore3526','Ëåíèíà 105','','tenretni','rwtenretni','',0,'0000-00-00',1,0,0,'',0),(8,0,0,'10.42.4.100',2,'edgecore3528','Øåâ÷åíêî 64','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(11,0,0,'10.44.8.100',2,'edgecore3526','Ìåòàëëóðãîâ 113','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(13,0,0,'10.90.90.96',2,'DLINK3028','Àðòåìà 56','','public','private','',0,'0000-00-00',0,0,0,'',0),(14,0,0,'10.41.3.100',2,'DLINK3526','Ìåòàëëóðãîâ 79','','public','private','',0,'0000-00-00',0,0,0,'',0),(15,0,0,'10.43.1.100',2,'edgecore3528','Øåâ÷åíêî 91','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(16,0,0,'10.21.1.100',2,'edgecore3528','Ìåòàëëóðãîâ 43','','tenretni','rwtenretni','',0,'2001-12-17',0,0,0,'',0),(17,0,0,'10.46.4.100',2,'WGSD1022','Àðòåìà 144','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(19,0,0,'10.90.91.20',2,'edgecore3528','Ëåíèíà 85','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(20,0,0,'10.90.89.200',2,'edgecore3526','Àïàòîâà 140','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(21,0,0,'195.72.157.250',3,'Cisco3560','Ëåíèíà 85','','public','private','',0,'0000-00-00',0,0,0,'',0),(25,0,0,'10.90.91.10',2,'edgecore3528','Ëåíèíà 85','','tenretni','rwtenretni','',0,'0000-00-00',0,0,3,'',0),(23,0,0,'10.90.89.99',2,'edgecore3510','Íàõèìîâà 99','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(31,0,0,'10.90.89.130',2,'DLINK3526','Ëàâèöêîãî 10','','public','private','',0,'0000-00-00',0,0,0,'',0),(27,0,0,'10.90.89.54',2,'edgecore3526','Ëåíèíà 87à','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(74,0,0,'10.50.6.100',2,'edgecore3510','Ìåòàëëóðãîâ 56','','tenretni','rwtenretni','',0,'2010-07-08',0,0,0,'',0),(26,0,0,'10.19.2.100',2,'edgecore3528','Ëåíèíà 42','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(29,0,0,'10.37.1.200',2,'DLINK3526','ïð.Ìåòàëëóðãîâ 92','','public','private','',0,'0000-00-00',0,0,0,'',0),(30,0,0,'10.37.1.201',2,'DLINK3226S','óë.Êàôôàéñêàÿ 4','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(32,0,0,'10.90.90.19',2,'edgecore3528','Íèêîëàåâñêàÿ 80','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(33,0,0,'10.90.89.131',2,'DLINK3526','Íàõèìîâà 154','','public','private','',0,'0000-00-00',0,0,0,'',0),(35,0,0,'10.90.89.135',2,'DLINK3526','Õìåëüíèöêîãî 2','','public','private','',0,'0000-00-00',0,0,0,'',0),(36,0,0,'10.90.89.52',2,'DLINK3028','Ëåíèíà 90','','public','private','',0,'0000-00-00',0,0,0,'',0),(37,0,0,'10.90.90.99',2,'edgecore3510','Ìèòðîïîëèòñêàÿ 53','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(38,0,0,'10.33.2.100',2,'DLINK3226S','Âàðãàíîâà 5','','public','private','',0,'0000-00-00',0,0,0,'',0),(39,0,0,'10.90.89.53',2,'DLINK3028','Íàõèìîâà 178','','public','private','',0,'0000-00-00',0,0,0,'',0),(40,0,0,'10.35.3.100',2,'DLINK3028','Àðòåìà 58','','public','private','',0,'0000-00-00',0,0,0,'',0),(41,0,0,'10.90.89.55',2,'DLINK3526','Çåëèíñêîãî 13','','public','private','',0,'0000-00-00',0,0,0,'',0),(42,0,0,'10.17.2.100',2,'DLINK3526','Ëåíèíà 62','','public','private','',0,'0000-00-00',0,0,0,'',0),(43,0,0,'10.39.4.100',2,'DLINK3028','Àðòåìà 82','','public','private','',0,'0000-00-00',0,0,0,'',0),(44,0,0,'10.28.2.100',2,'edgecore3528','Ëåíèíà 1','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(45,0,0,'10.90.89.57',2,'edgecore3510','Ëåíèíà 97','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(47,0,0,'10.90.89.70',2,'DLINK3028','Õìåëüíèöêîãî 10/9','','public','private','',0,'0000-00-00',0,0,0,'',0),(52,0,0,'10.90.89.76',2,'edgecore3528','ïð.Ëåíèíà 104','','public','private','',0,'0000-00-00',0,0,0,'',0),(49,0,0,'10.90.89.73',2,'edgecore3528','Áàõ÷èâàíäæè 10/6','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(51,0,0,'10.90.89.75',2,'edgecore3528','ïð.Ñòðîèòåëåé 84','','public','private','',0,'0000-00-00',0,0,0,'',0),(53,0,0,'10.26.7.100',2,'edgecore3528','Çåëèíñêîãî 19á ','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(54,0,0,'10.90.89.77',2,'edgecore3528','Çåëèíñêîãî 21','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(55,0,0,'10.15.2.100',2,'edgecore3528','Àðòåìà 48','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(56,0,0,'10.90.89.78',2,'edgecore3528','Áàõ÷èâàíäæè 14','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(57,0,0,'10.90.89.80',2,'edgecore3528','Ëåíèíà 90','','tenretni','rwtenretni','',0,'2010-03-30',0,0,0,'',0),(58,0,0,'10.90.89.79',2,'edgecore3510','Ëåíèíà 96','','tenretni','rwtenretni','',0,'2010-03-30',0,0,0,'',0),(59,0,0,'195.72.157.254',4,'Cisco7201','Ëåíèíà 85','','public','private','',0,'0000-00-00',0,0,2,'',0),(60,0,0,'10.21.1.102',2,'DLINK3526','Ëåíèíà 24','','public','private','',0,'2010-04-09',0,0,0,'',0),(61,0,0,'10.23.1.100',2,'edgecore3528','Ëåíèíà 10/20','','tenretni','rwtenretni','',0,'2010-04-09',0,0,0,'',0),(62,0,0,'10.90.89.81',2,'edgecore3510','Íàõèìîâà 194','','tenretni','rwtenretni','',0,'2010-04-12',0,0,0,'',0),(63,0,0,'10.90.91.40',2,'DLINK3028','Ëåíèíà 85','','tenretni','rwtenretni','',0,'2010-04-16',0,0,1,'',0),(64,0,0,'10.90.89.82',2,'edgecore3528','Ëåíèíà 90','','tenretni','rwtenretni','',0,'2010-04-21',0,0,0,'',0),(65,0,0,'10.90.89.83',2,'edgecore3528','Ëåíèíà 93','','tenretni','rwtenretni','',0,'2010-04-21',0,0,0,'',0),(66,0,0,'10.90.89.84',2,'edgecore3510','Ëåíèíà 94','','tenretni','rwtenretni','',0,'2010-04-21',0,0,0,'',0),(75,0,0,'10.9.5.200',2,'edgecore3828','Õìåëüíèöêîãî 31','','tenretni','rwtenretni','',0,'0000-00-00',0,0,0,'',0),(72,0,0,'10.90.91.60',2,'edgecore3528','Øåâ÷åíêî 80','','tenretni','rwtenretni','',0,'2010-06-15',0,0,0,'',0),(71,0,0,'10.90.91.50',2,'edgecore3528','Øåâ÷åíêî 80','','tenretni','rwtenretni','',0,'2010-06-14',0,0,0,'',0),(73,0,0,'10.34.3.100',2,'edgecor3528','óë.Èòàëüÿíñêàÿ 116à','','tenretni','rwtenretni','',0,'2010-06-16',0,0,0,'',0),(76,0,0,'10.37.1.100',2,'DLINK3526','Ìåòàëëóðãîâ 84','','public','private','',0,'2010-12-10',0,0,0,'',0),(77,0,0,'10.40.4.30',2,'WGSD1022','','','tenretni','rwtenretni','',0,'2010-12-18',0,0,0,'',0);
/*!40000 ALTER TABLE `switch` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-01-04 20:01:27
