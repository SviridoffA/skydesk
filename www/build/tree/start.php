<?php
include('building.inc.php');
include('box.inc.php');
include('optic_cable.inc.php');
include_once('connect.inc');

$a=new optic_cable(20,7);
$a->show_opticbox();
?>