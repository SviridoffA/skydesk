
<form>
<input type=hidden name=make value=addopticbox>
<table>
<tr><td>opticboxtype</td><td><select name=opticboxtype>
<?php
echo selectform("optic_box_description","model","id",0);

?>
</select></td></tr>
<tr><td>address</td><td><select name=idconnect>
<?php

$field[0]="address";
$field[1]="building";
echo selectform("points",$field,"id",$ext);

?>
</select></td></tr>
<tr><td>comment</td><td><input class=field type=text name=comment size=40></td></tr>
<tr><td colspan=2><input class=input value=addbox type=submit></td></tr>
</table>

</table>
</form>
