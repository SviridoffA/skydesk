<?php
class mrtg {
   private $cfg="/usr/local/etc/mrtg/mrtg.cfg";
   var $config="";
   function get_cfg() {
     $fp=fopen($this->cfg,"r");
     while (!feof($fp)) {
       $str=$str.fgets($fp,1024);
     }
       $this->config=$str;
     return $this->config;
   }

}
$a=new mrtg();
$cfg=$a->get_cfg();
// echo $cfg;
// preg_match_all("/^Target\[([\d]+).([\d]+).([\d]+).([\d]+)_([\d]+)\]/",$cfg,$mem);
// Target[10.90.89.200_5093]: 5093:tenretni@10.90.89.200:
// Target[loadcpu]: 1.3.6.1.4.1.9.2.1.58.0&1.3.6.1.4.1.9.2.1.58.0:public@195.72.157.254

// preg_match_all("/Target\[([\d]+)\.([\d]+)\.([\d]+)\.([\d]+)_([\d]+)\]: ([.&\d]+):([\w]+)@([\d]+)\.([\d]+)\.([\d]+)\.([\d]+)/",$cfg,$mem);
preg_match_all("/Target\[([_.\w\d]+)\]: ([.&\d]+):([\w]+)@([\d]+)\.([\d]+)\.([\d]+)\.([\d]+)/",$cfg,$mem);
$num=count($mem[0]);

for ($i=0;$i<$num;$i++) {



$str=$mem[1][$i].$mem[2][$i].$mem[3][$i].$mem[4][$i].$mem[5][$i].$mem[6][$i].$mem[7][$i].":".$mem[8][$i].$mem[9][$i].$mem[10][$i].$mem[11][$i];
  echo "$str\n";
}

// var_dump($mem);
?>