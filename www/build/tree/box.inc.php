<?php
class opticbox extends building {
  public $opticbox=array();
  public $boxname="test";
  public $opticboxone=array();

  function __construct($id) {
    if (empty($id)) {
      $id=$this->id;
    } else {
      $this->id=$id;
    }
    parent::__construct($id);
    $query="select * from opticbox where idconnect=$id";
    $res=mysql($this->database,$query);
    $num=mysql_num_rows($res);
//    echo "num=$num\n $query\n";
    for ($i=0;$i<$num;$i++) {
      $this->opticbox[$i]['id']=mysql_result($res,$i,"id");
      $this->opticbox[$i]['opticboxtype']=mysql_result($res,$i,"opticboxtype");
      $this->opticbox[$i]['comment']=mysql_result($res,$i,"comment");
      $query="select * from optic_box_description where id=".$this->opticbox[$i]['opticboxtype'];
      $res1=mysql($this->database,$query);
      $this->opticbox[$i]['model']=mysql_result($res1,0,"model");
      $this->opticbox[$i]['for_output']=mysql_result($res1,0,"for_output");    
      $query="select * from optic_cable where (from_opticbox_id=".$this->opticbox[$i]['id'].") or (to_opticbox_id=".$this->opticbox[$i]['id'].")";;
      echo $query;
      $res2=mysql($this->database,$query);      
      $nn=mysql_num_rows($res2);
      for ($j=0;$j<$nn;$j++) {
         $this->opticbox[$i]['optic_cable'][$j]['id']=mysql_result($res2,$j,"id");
         $this->opticbox[$i]['optic_cable'][$j]['from_opticbox_id']=mysql_result($res2,$j,"from_opticbox_id");

         $this->opticbox[$i]['optic_cable'][$j]['from']=$this->get_opticbox($this->opticbox[$i]['optic_cable'][$j]['from_opticbox_id']);
         $this->opticbox[$i]['optic_cable'][$j]['to_opticbox_id']=mysql_result($res2,$j,"to_opticbox_id");

         $this->opticbox[$i]['optic_cable'][$j]['to']=$this->get_opticbox($this->opticbox[$i]['optic_cable'][$j]['to_opticbox_id']);
         $this->opticbox[$i]['optic_cable'][$j]['type']=mysql_result($res2,$j,"type");
      }    
    }
//    var_dump($this->opticbox);
  }
  
  function get_opticbox_comment($opticboxid) {
    $query="select * from opticbox where id=$opticboxid";
    $res=mysql($this->database,$query);
    $comment=mysql_result($res,0,"comment");
    return($comment);
  }

  function get_opticboxarray($opticboxid) {
    $query="select * from opticbox where id=$opticboxid";
    $res=mysql($this->database,$query);
    $num=mysql_num_rows($res);
    echo "num=$num\n $query\n";
    for ($i=0;$i<$num;$i++) {
      $this->opticboxone['id']=mysql_result($res,$i,"id");
      $this->opticboxone['opticboxtype']=mysql_result($res,$i,"opticboxtype");
      $this->opticboxone['comment']=mysql_result($res,$i,"comment");
      $query="select * from optic_box_description where id=".$this->opticboxone['opticboxtype'];
      $res1=mysql($this->database,$query);
      $this->opticboxone['model']=mysql_result($res1,0,"model");
      $this->opticboxone['for_output']=mysql_result($res1,0,"for_output");    
      $query="select * from optic_cable where (from_opticbox_id=".$this->opticboxone['id'].") or (to_opticbox_id=".$this->opticboxone['id'].")";;
      $res2=mysql($this->database,$query);      
      $nn=mysql_num_rows($res2);
      for ($j=0;$j<$nn;$j++) {
         $this->opticboxone['optic_cable'][$j]['id']=mysql_result($res2,$j,"id");
         $this->opticboxone['optic_cable'][$j]['from_opticbox_id']=mysql_result($res2,$j,"from_opticbox_id");


         $this->opticboxone['optic_cable'][$j]['from']=$this->get_opticbox($this->opticboxone['optic_cable'][$j]['from_opticbox_id']);
         $this->opticboxone['optic_cable'][$j]['to_opticbox_id']=mysql_result($res2,$j,"to_opticbox_id");


         $this->opticboxone['optic_cable'][$j]['to']=$this->get_opticbox($this->opticboxone['optic_cable'][$j]['to_opticbox_id']);
         $this->opticboxone['optic_cable'][$j]['type']=mysql_result($res2,$j,"type");
      }    
    }
//    var_dump($this->opticbox);
    return($this->opticboxone);
  }

  function show_opticbox() {
//    var_dump($this->opticbox);
//    echo "id=$this->id $this->address $this->building\n";
  } 

  function get_opticbox($opticboxid) {
    $query="select * from opticbox where id=$opticboxid";
    $res=mysql($this->database,$query);
    echo mysql_error();
    echo $query."\n";
    $idconnect=mysql_result($res,0,"idconnect");
    $address=$this->get_building($idconnect);
    return($address);
  }

  function add_opticbox($opticboxtype,$address,$comment) {
    $query="insert into opticbox (opticboxtype,idconnect,address,comment) values ($opticboxtype,$this->id,'$address','$comment')";
    $res=mysql($this->database,$query);
  }

  function delete_opticbox($opticboxid) {
    $query="select * from optic_cable where (from_opticbox_id=$opticboxid or to_opticbox_id=$opticboxid)";    
    $res=mysql($this->database,$query);
    $num=mysql_num_rows($res);
    if ($num > 0) {
      $str="delete cable from opticbox";       
    } else {
      $query="delete from opticbox where id=$opticboxid";
      $res=mysql($this->database,$query);
      $str="";
    }
    return($str);
  }
}
?>