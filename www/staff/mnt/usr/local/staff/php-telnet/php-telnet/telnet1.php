<?php
require_once ("PHPTelnet.php");  

    

// $JsHttpRequest =& new JsHttpRequest("windows-1251");  

    

 $Telnet = new PHPTelnet();  
 echo $Telnet->loginprompt;
// $Telnet->loginprompt="Password:";
    

 /*10.1.11.43 - ����� ������� D-LINK AP2100*/ 

 $result = $Telnet->Connect("10.41.3.100","admin", "rjycek");  
 echo $Telnet->loginprompt;

    

 switch ($result) {  

 case 0:  

    

 /*��������� ������� - help*/ 

 $Telnet->DoCommand("show fdb", $result);  
 $Telnet->DoCommand(" ", $result);  
 $Telnet->DoCommand(" ", $result);  
 $Telnet->DoCommand(" ", $result);  

 echo "<p style='text-align: left;'>".str_replace("\n", "<br/>",$result)."</p>";  

 break;  

 }  

    

$Telnet->Disconnect(); 
?>