<?php
class optic_cable extends opticbox {

  public $optic_cable=array();
  public $opticbox=array();
  var $opticboxid="";

  function __construct($id,$opticboxid) {
    $this->opticboxid=$opticboxid;
    if (empty($id)) {
      $id=$this->id;
    } else {
      $this->id=$id;
    }
    parent::__construct($id);
    echo $this->boxname;
    echo $this->idconnect;
    echo $this->address;
    echo $this->building;
    echo $this->opticboxid;
    $this->opticbox=$this->get_opticboxarray($opticboxid);
    $num=count($this->opticbox['optic_cable']);     
    echo "num=$num";  
    for ($i=0;$i<$num;$i++ ) {
      $types=$this->opticbox['optic_cable'][$i]['type'];
      echo "types=$types\n";
      $query="select * from cabletype where id=$types";
      $res=mysql($this->database,$query);
      $color=mysql_result($res,0,"color");
      echo "color=$color\n";
      $query="select * from color where typecolor=$color";
      $res=mysql($this->database,$query);
      $nn=mysql_num_rows($res);
      for ($j=0;$j<$nn;$j++) {
        $k=$j+1;
        $this->opticbox['optic_cable'][$i]['color'][$k]['color']=mysql_result($res,$j,"color");
        $this->opticbox['optic_cable'][$i]['color'][$k]['colornum']=mysql_result($res,$j,"colornum");
      }
      $query="select * from optic_connection where optic_cable_id=".$this->opticbox['optic_cable'][$i]['id'];
      $res=mysql($this->database,$query);
      $kn=mysql_num_rows($res);
      for ($j=0;$j<$kn;$j++) { 
        $colornum=mysql_result($res,$j,"colornum");

        $this->opticbox['optic_cable'][$i]['color'][$colornum]['optic_cable_id']=mysql_result($res,$j,"colornum");
        $this->opticbox['optic_cable'][$i]['color'][$colornum]['type']=mysql_result($res,$j,"type");
        $this->opticbox['optic_cable'][$i]['color'][$colornum]['idconnection']=mysql_result($res,$j,"idconnection");
      }
//    var_dump($this->opticbox);
    }
  }
  function check_colornum($optic_cable_id,$colornum) {
    $query="select * from optic_connection where optic_cable_id=$optic_cable_id and colornum=$colornum";
    $res=mysql($this->database,$query);
    $num=mysql_num_rows($res);
//    echo "num=$num ".$query."\n";
    $query="select * from optic_connection where to_optic_cable_id=$optic_cable_id and to_colornum=$colornum";
    $res=mysql($this->database,$query);
    $num=$num+mysql_num_rows($res);
//    echo "num=$num ".$query."\n";
    return($num);
  }



  function insert_optic($opticbox,$optic_cable_id,$colornum,$to_optic_cable,$to_colornum) {
    $query="insert into optic_connection(colornum,optic_cable_id,to_optic_cable_id,to_colornum) values ($optic_cable_id,$colornum,$to_optic_cable,$to_colornum)"; 
//    echo $query;
    $res=mysql($this->database,$query);
    echo mysql_error();
    echo "updated optic_connection<br>";
  }


  function get_next_opticbox($opticbox,$optic_cable_id,$colornum,$optic_cable_source_id) {
    $query="select * from optic_cable where id=$optic_cable_id";
    $res=mysql($this->database,$query);
    $num=mysql_num_rows($res);
    echo "get_next_opticbox !!!!!!!!!!!!!!!!! num=$num $query\n";
    if ($num > 0) {
      $from_opticbox_id=mysql_result($res,0,"from_opticbox_id");
      $to_opticbox_id=mysql_result($res,0,"to_opticbox_id");
      $types=mysql_result($res,0,"type");
      echo "opticbox=$opticbox from_opticbox_id=$from_opticbox_id to_opticbox_id=$to_opticbox_id types=$types\n";
      if ($opticbox == $from_opticbox_id) {
         $next_opticbox_id=$to_opticbox_id;     
      } else {
         $next_opticbox_id=$from_opticbox_id;     
      }
      echo "!!!! next_opticbox=$next_opticbox_id\n";
      $prefix=$this->get_opticbox($next_opticbox_id);
      echo "prefix=$prefix\n";
      return($prefix);
    } 
  }

  function get_prefix($opticboxid,$optic_cable_id,$colornum,$optic_cable_source_id) {
    $query="select * from optic_cable where to_opticbox_id=$opticboxid and id=$optic_cable_source_id";
    $res=mysql($this->database,$query);
    echo mysql_error();
    $num=mysql_num_rows($res);
    echo "get_prefix_1!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
    echo $query."\n";
    if ($num > 0) {
      $to_opticbox_id=mysql_result($res,0,"from_opticbox_id");
      $prefix=$this->get_opticbox($to_opticbox_id);
      return($prefix);
    } 
    $query="select * from optic_cable where from_opticbox_id=$opticboxid and id=$optic_cable_source_id";
    $res=mysql($this->database,$query);
    echo mysql_error();
    $num=mysql_num_rows($res);
    echo "get_prefix_2!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
    echo $query."\n";
    if ($num > 0) {
      $to_opticbox_id=mysql_result($res,0,"to_opticbox_id");
      $prefix=$this->get_opticbox($to_opticbox_id);
      return($prefix);
    } 
  }

  function get_color($optic_cable_id,$numcolor) {
//    echo "get_color!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
    $query="select * from optic_cable where id=$optic_cable_id";
//    echo $query."\n";
    $res=mysql($this->database,$query);
    $types=mysql_result($res,0,"type");
    $query="select * from cabletype where id=$types";
    $res=mysql($this->database,$query);
    $types=mysql_result($res,0,"color");

    $query="select * from color where typecolor=$types and colornum=$numcolor";
//    echo $query."\n";
    $res=mysql($this->database,$query);
    $color=mysql_result($res,0,"color");
    return($color);
  }

  function select_cable_setting($opticboxid,$optic_cable_id,$colornum) {
    $query="select * from optic_connection where optic_cable_id=$optic_cable_id and colornum=$colornum";
    $res=mysql($this->database,$query);
    $num=mysql_num_rows($res);
    echo "select_cable_setting_1!!!!!!!!!!!!!!!!!!!!! num=$num ".$query."\n";
    if ($num > 0 ) {
      $to_optic_cable_id=mysql_result($res,0,"to_optic_cable_id");
      $to_colornum=mysql_result($res,0,"to_colornum");
      echo "opticboxid=$opticboxid optic_cable_id=$optic_cable_id colornum=$colornum to_optic_cable_id=$to_optic_cable_id to_colornum=$to_colornum\n";
      $prefix=$this->get_prefix($opticboxid,$to_optic_cable_id,$to_colornum,$optic_cable_id);

      $prefix=$this->get_next_opticbox($opticboxid,$optic_cable_id,$colornum $to_optic_cable_id,$to_colornum);
      $color=$this->get_color($optic_cable_id,$to_colornum)." ($to_colornum)";
      echo "<option value=\"$to_optic_cable_id,$to_colornum\">$color $prefix</option>\n";
      
    } else {
      $query="select * from optic_connection where to_optic_cable_id=$optic_cable_id and to_colornum=$colornum";
      $res=mysql($this->database,$query);
      $num=mysql_num_rows($res);
      echo "select_cable_setting_2!!!!!!!!!!!!!!!!!!!!! num=$num ".$query."\n";
      $from_optic_cable_id=mysql_result($res,0,"optic_cable_id");
      $from_colornum=mysql_result($res,0,"colornum");
      $prefix=$this->get_prefix($opticboxid,$from_optic_cable_id,$from_colornum,$optic_cable_id);

      $prefix=$this->get_next_opticbox($opticboxid,$from_optic_cable_id,$from_colornum,$optic_cable_id,$colornum);
      $color=$this->get_color($optic_cable_id,$colornum)." ($colornum)";
      echo "opticboxid=$opticboxid optic_cable_id=$optic_cable_id colornum=$colornum to_optic_cable_id=$to_optic_cable_id to_colornum=$to_colornum\n";
//      $color="($colornum)";
      echo "<option value=\"$optic_cable_id,$colornum\">$color $prefix</option>\n";
    }
//    exit;

  }

  function select_cable($opticboxid,$optic_cable_id,$colornum) {
    echo "<form method=get>\n";
    echo "<input type=hidden name=opticboxid value=$opticboxid>\n";
    echo "<input type=hidden name=optic_cable_id value=$optic_cable_id>\n";
    echo "<input type=hidden name=colornum value=$colornum>\n";
    echo "<select name=idconnect>";
    if ($this->check_colornum($optic_cable_id,$colornum) > 0 ) {
       $this->select_cable_setting($opticboxid,$optic_cable_id,$colornum);
       echo "</select></form>";
       return;
    } 
    $query="select * from end_optic where type=1";
    $res=mysql($this->database,$query);
    $num=mysql_num_rows($res);
    for ($i=0;$i<$num;$i++) {
      $connector=mysql_result($res,$i,"connector");
      $idconnector=mysql_result($res,$i,"id");
      echo "<option value=\"-1,$idconnector\">$connector</option>";
    }
    $num=count($this->opticbox['optic_cable']);
    for ($i=0;$i<$num;$i++) {
      $idcable=$this->opticbox['optic_cable'][$i]['id'];
      $nn=count($this->opticbox['optic_cable'][$i]['color']);
      for ($j=1;$j<=$nn;$j++) {
        $ncolor=$this->opticbox['optic_cable'][$i]['color'][$j]['colornum'];
//        echo "optic_cable_id=$optic_cable_id idcable=$idcable ncolor=$ncolor colornum=$colornum<br>";
        if (($idcable == $optic_cable_id) && ($ncolor == $colornum)) {
        } else {
          $from_opticbox_id=$this->opticbox['optic_cable'][$i]['from_opticbox_id'];
          $to_opticbox_id=$this->opticbox['optic_cable'][$i]['to_opticbox_id'];
          if ($opticboxid == $to_optic_box) {
            $prefix=$this->opticbox['optic_cable'][$i]['from'];
//            $prefix=$this->get_prefix($opticboxid,$optic_cable_id,$colornum);
          } else {
            $prefix=$this->opticbox['optic_cable'][$i]['to'];
//            $prefix=$this->get_prefix($opticboxid,$optic_cable_id,$colornum);
          }
            $color=$this->opticbox['optic_cable'][$i]['color'][$j]['color']."($j)";
            $showcolor=$this->opticbox['optic_cable'][$i]['color'][$j]['colornum'];
            if ($this->check_colornum($idcable,$showcolor) == 0 ) {
              echo "<option value=\"$idcable,$showcolor\">$color $prefix</option>\n";
            } 
        }
      }
    }
    echo "</select><input type=submit value=set></form>\n";
  } 
}
?>