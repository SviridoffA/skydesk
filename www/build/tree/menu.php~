<?php
$ext=$_GET['ext'];
?>
<html>
<head>
<title>Система документрования и планирования.</title>
<meta http-equiv="Content-Type" content="text/html">
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-type" content="text/html; charset=windows-1251">

<script type="text/javascript" language="JavaScript1.2">
<!-- 

var msie = (navigator.userAgent.indexOf("MSIE") != -1);

/* simplyi */
var is_modern = (document.getElementById);
var is_msie   = (document.all);
var is_nn     = (document.layers);

var MenuArray = new Array('search','agr','bill','act','delnote',
                          'pay','business','icard','admin','reports');

function showSubmenu(name){

 for(var i=0;i<MenuArray.length;i++) { 
	if(is_nn){
		var what = self.document.layers[MenuArray[i]];
		if (name != MenuArray[i]) what.visibility = 'hide';
		if (name == MenuArray[i]) what.visibility = 'show';
	}
	if(is_modern){
                eval('var what = document.getElementById("ms_'+MenuArray[i]+'");');
		if (name != MenuArray[i]) what.style.display = 'none';
		if (name == MenuArray[i]) what.style.display = '';
		continue;
	}
	if(is_msie){
	 	eval('var what = document.all.ms_'+MenuArray[i]+';');
		if (name != MenuArray[i]) what.style.display = 'none';
		if (name == MenuArray[i]) what.style.display = '';
	}
 }

}


function jump(){}

// -->
</script>

<?php
$path = $PHP_SELF;
$root = substr($path, 0, strpos($path, $BASE_DIR)).$BASE_DIR;
echo "<!-- $path $BASE_DIR -->";
?>
<link href="<?php echo $root."boss.css"; ?>" rel="STYLESHEET" type="text/css">

</head>

<body bgcolor="#FFFFFF" text="#000000" marginwidth="0" marginheight="0" leftmargin=0 topmargin=0>
<a href="<?php echo $root; if( $ClientMode == 0 ) { echo "/krasnet/";} ?>" target="_top"><img src="<?php echo $imagePATH.$logo_img; ?>" width=200 height=50 border=0 align="left" alt="logo" hspace="5"></a>
<br><br><br><br>

<?php
echo "clientmode = $ClientMode<br>";
// if($ClientMode != 1){
?>
<!-- Main Menu -->
<layer pagex="229" pagey="8" width=150 height="8" id="menu"> 

<nolayer>
<div id="ms_menu" style="position:absolute; left:229px; top:8px; whidth:5px; height:15px; z-index:9"> 
</nolayer>

<table border="0" cellpadding="3" cellspacing="1" bgcolor=white>
  <tr>
    <td nowrap class="menu">&nbsp;&nbsp;
		<a href="javascript: jump();" class="menu" onClick="showSubmenu('search')" onClick="return false;">Дома</a>&nbsp;&nbsp;|&nbsp;
		<a href="javascript: jump();" class="menu" onClick="showSubmenu('agr')" onClick="return false;">Оптические боксы</a>&nbsp;&nbsp;|&nbsp;
		<a href="javascript: jump();" class="menu" onClick="showSubmenu('bill')" onClick="return false;">Свичи</a>&nbsp;&nbsp;|&nbsp;
		<a href="javascript: jump();" class="menu" onClick="showSubmenu('act')" onClick="return false;">оптические кабеля</a>&nbsp;&nbsp;|&nbsp;
		<a href="javascript: jump();" class="menu" onClick="showSubmenu('delnote')" onClick="return false;">Ящики</a>&nbsp;&nbsp;|&nbsp;
		<a href="javascript: jump();" class="menu" onClick="showSubmenu('pay')" onClick="return false;">Заявки</a>&nbsp;&nbsp;|&nbsp;
		<a href="javascript: jump();" class="menu" onClick="showSubmenu('business')" onClick="return false;">Справочники</a>&nbsp;&nbsp;|&nbsp;
		<a href="javascript: jump();" class="menu" onClick="showSubmenu('icard')" onClick="return false;">Поиск</a>&nbsp;&nbsp;|&nbsp;
		<a href="javascript: jump();" class="menu" onClick="showSubmenu('admin')" onClick="return false;">Аадминистратор</a>&nbsp;|&nbsp;
		<a href="javascript: jump();" class="menu" onClick="showSubmenu('reports')" onClick="return false;">отчеты</a>&nbsp;&nbsp;
	</td>
  </tr>
</table>

<nolayer>
</div>
</nolayer>

</layer>

<!-- Submenu search -->
<layer id="search" onMouseOut="visibility='hide'" left="230" top="29" width="119" height="8" bgcolor="#006699" visibility="hide" z-index="1"> 

<nolayer>
<div id="ms_search" onClick="style.display='none';" style="position:absolute; left:230px; top:29px; height:19px; z-index:1; background-color:#006699; display: none"> 
</nolayer>

<table cellpadding="2" cellspacing="0" bgcolor="#006699">
  <tr><td nowrap class="menu">
    <a href="<?php echo $root."index.php" ?>" class="menu" target="_top" onClick="visibility='hide';" alt="поиск абонента">&nbsp;&nbsp;В виде дерева&nbsp;&nbsp;|</a>
<!--     <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_demos.inc" ?>" class="menu" target="_top" onClick="visibility='hide';" alt="поиск демо">&nbsp;&nbsp;демо&nbsp;&nbsp;|</a> -->
    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_icard.inc" ?>" class="menu" target="_top" onClick="visibility='hide';" alt="поиск i-карт">&nbsp;&nbsp;i-карт&nbsp;&nbsp;|</a>
    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_dealers.inc" ?>" class="menu" target="_top" onClick="visibility='hide';" alt="поиск i-карт">&nbsp;&nbsp;дилеров i-карт&nbsp;&nbsp;|</a>
    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_domains.inc" ?>" class="menu" target="_top" onClick="visibility='hide';" alt="поиск доменов">&nbsp;&nbsp;доменов&nbsp;&nbsp;|</a>
    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_ll.inc" ?>" class="menu" target="_top" onClick="visibility='hide';" alt="поиск выделенщиков">&nbsp;&nbsp;выделенщиков&nbsp;&nbsp;|</a>
    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_ppp.inc" ?>" class="menu" target="_top" onClick="visibility='hide';" alt="поиск по интернет ip">&nbsp;&nbsp;поиск по интернет ip&nbsp;&nbsp;|</a>
    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_dhcp.inc" ?>" class="menu" target="_top" onClick="visibility='hide';" alt="поиск по внутрисетевому ip">&nbsp;&nbsp;поиск по внутрисетевому ip&nbsp;&nbsp;</a>

  </td></tr>
</table>

<nolayer>
</div>
</nolayer>

</layer>

<!-- Submenu agreement -->
<layer id="agr" onMouseOut="visibility='hide'" left="292"  top="29" height="8" bgcolor="#006699" visibility="hide" z-index="2"> 

<nolayer>
<div id="ms_agr" onClick="style.display='none';" style="position:absolute; left:290px; top:29px; height:19px; z-index:2; background-color:#006699; display: none"> 
</nolayer>

<table cellpadding="2" cellspacing="0" bgcolor="#006699">
  <tr><td nowrap class="menu">
	<a href="<?php echo $root."addbox.php?ext=$ext" ?>" target="_top" class="menu" onClick="visibility='hide';">&nbsp;&nbsp;Добавить&nbsp;&nbsp;</a>|
    <a href="<?php echo $root."addbox.php?ext=$ext" ?>" target="_top" class="menu" onClick="visibility='hide';">&nbsp;&nbsp;частное лицо&nbsp;&nbsp;</a>|
    <a href="<?php echo $root."contract/actions/right.php3?isDealer=1" ?>" target="_top" class="menu" onClick="visibility='hide';">&nbsp;&nbsp;дилер i-карт&nbsp;&nbsp;</a>|
    <a href="<?php echo $root."contract/actions/right.php3?isDomain=1" ?>" target="_top" class="menu" onClick="visibility='hide';">&nbsp;&nbsp;домен&nbsp;&nbsp;</a>
<?
if($ClientMode != 1 && !empty($Id)){
?>
	<a href="<?php echo $root."contract/actions/right.php3?host=$Id" ?>" target="_top" class="menu" onClick="visibility='hide';">|&nbsp;&nbsp;подч. предприятие&nbsp;&nbsp;</a>|
    <a href="<?php echo $root."contract/actions/right2.php3?host=$Id" ?>" target="_top" class="menu" onClick="visibility='hide';">&nbsp;&nbsp;подч. частное лицо&nbsp;&nbsp;</a>
<?
}
?>
<!--     <a href="<?php echo $root."menu2-3.html" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;демо</a> -->
  </td></tr>
</table>

<nolayer>
</div>
</nolayer>

</layer>

<!-- Submenu bill -->
<layer id="bill" onMouseOut="visibility='hide'" left="361" top="29" height="8" bgcolor="#006699" visibility="hide" z-index="4"> 

<nolayer>
<div id="ms_bill" onClick="style.display='none';" style="position:absolute; left:357px; top:29px; height:19px; z-index:4; background-color:#006699; display: none"> 
</nolayer>

<table cellpadding="2" cellspacing="0" bgcolor="#006699">
  <tr><td nowrap class="menu">
  	<a href="<?php echo $root."switchs.php" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;Добавить&nbsp;&nbsp;</a>|
  	<a href="<?php echo $root."menu3-2.html" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;выделенки&nbsp;&nbsp;</a>|
    <a href="<?php echo $root."menu3-0.html" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;группа риска&nbsp;&nbsp;</a>|
    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_bills.inc" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;список счетов</a>
	</td>
  </tr>
</table>

<nolayer>
</div>
</nolayer>

</layer>

<!-- Submenu act -->
<layer id="act" onMouseOut="visibility='hide'" left="408" top="29" width="65" height="8" bgcolor="#006699" visibility="hide" z-index="5"> 

<nolayer>
<div id="ms_act" onClick="style.display='none';" style="position:absolute; left:403px; top:29px; height:19px; z-index:5; background-color:#006699; display: none"> 
</nolayer>

<table cellpadding="2" cellspacing="0" bgcolor="#006699">
  <tr> 
    <td nowrap class="menu"><a href="<?php echo $root."act/end_p.html" ?>" class="menu" target="_top" onClick="visibility='hide';">выписать</a></td>
  </tr>
</table>

<nolayer>
</div>
</nolayer>

</layer>

<!-- Submenu delivery note -->
<layer id="delnote" onMouseOut="visibility='hide'" left="450" top="29" width="163" height="8" bgcolor="#006699" visibility="hide" z-index="6"> 

<nolayer>
<div id="ms_delnote" onClick="style.display='none';" style="position:absolute; left:442px; top:29px; height:19px; z-index:6; background-color:#006699; display: none"> 
</nolayer>

<table cellpadding="2" cellspacing="0" bgcolor="#006699">
  <tr><td nowrap class="menu">
    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_nakl.inc" ?>" class="menu" target="_top" onClick="visibility='hide';">список&nbsp;&nbsp;</a>|
    <a href="<?php echo $root."menu5-2.html" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;долговая книга&nbsp;&nbsp;</a>|
    <a href="<?php echo $root."menu5-3.html" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;накладные за период</a>
  </td></tr>
</table>

<nolayer>
</div>
</nolayer>

</layer>

<!-- Submenu payment -->
<layer id="pay" onMouseOut="visibility='hide'" left="533" top="29" height="8" bgcolor="#006699" visibility="hide" z-index="7"> 

<nolayer>
<div id="ms_pay" onClick="style.display='none';" style="position:absolute; left:523px; top:29px; height:19px; z-index:7; background-color:#006699; display: none"> 
</nolayer>

<table cellpadding="2" cellspacing="0" bgcolor="#006699" height="13">
  <tr><td nowrap class="menu">
<!--    <a href="<?php echo $root."menu6-1.html" ?>" class="menu" target="_top" onClick="visibility='hide';">безнал&nbsp;&nbsp;</a>|-->
<!--    <a href="<?php echo $root."menu6-2.html" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;наличный&nbsp;&nbsp;</a>|-->
<!--    <a href="<?php echo $root."menu6-3.html" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;разовый&nbsp;&nbsp;</a>|-->
<!--    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_business.inc" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;приход&nbsp;&nbsp;</a>|-->
    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_payments.inc" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;все платежи&nbsp;&nbsp;</a>
  </td></tr>
</table>

<nolayer>
</div>
</nolayer>

</layer>

<!-- Submenu business -->
<layer id="business" onMouseOut="visibility='hide'" left="533" top="29" height="8" bgcolor="#006699" visibility="hide" z-index="7">

<nolayer>
<div id="ms_business" onClick="style.display='none';" style="position:absolute; left:523px; top:29px; height:19px; z-index:7; background-color:#006699; display: none">
</nolayer>

<table cellpadding="2" cellspacing="0" bgcolor="#006699" height="13">
  <tr><td nowrap class="menu">
    <a href="<?php echo $root."opticbox.php" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;Оптических боксов&nbsp;&nbsp;</a>|
    <a href="<?php echo $root."switches.php" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp; Свичей &nbsp;&nbsp;</a>|
    <a href="<?php echo $root."cable.php" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp; Оптических кабелей&nbsp;&nbsp;</a>
  </td></tr>
</table>

<nolayer>
</div>
</nolayer>

</layer>

<!-- Submenu icard -->
<layer id="icard" onMouseOut="visibility='hide'" left="486" top="29" width="3" height="8" bgcolor="#006699" visibility="hide" z-index="6"> 

<nolayer>
<div id="ms_icard" onClick="style.display='none';" style="position:absolute; left:486px; top:29px; height:19px; z-index:6; background-color:#006699; display: none"> 
</nolayer>

<table cellpadding="2" cellspacing="0" bgcolor="#006699">
  <tr><td nowrap class="menu">
    <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_icard.inc" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;&nbsp;состояние&nbsp;&nbsp;</a>|
<!--     <a href="<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_dealers.inc" ?>" class="menu" target="_top" onClick="visibility='hide';" alt="поиск i-карт">&nbsp;&nbsp;дилеры&nbsp;&nbsp;</a>| -->
	<a href="<?php echo $root."icard/icard_gen.php3" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;генерация&nbsp;</a>|
	<a href="<?php echo $root."icard/export/cardsheet.html";?>" class="menu" target="_blank" onClick="visibility='hide';">&nbsp;учет движения&nbsp;</a>
  </td></tr>
</table>

<nolayer>
</div>
</nolayer>

</layer>

<!-- Submenu administrator -->
<layer id="admin" onMouseOut="visibility='hide'" left="270" top="29" height="8" bgcolor="#006699" visibility="hide" z-index="8"> 

<nolayer>
<div id="ms_admin" onClick="style.display='none';" style="position:absolute; left:265px; top:29px; height:19px; z-index:8; background-color:#006699; display: none"> 
</nolayer>

<table cellpadding="2" cellspacing="0" bgcolor="#006699">
  <tr><td nowrap class="menu">
        <a class=abw HREF="javascript:" onClick="visibility='hide'; WindowURL(740,400,'<?php echo $root ?>other/index.html'); return false;"> TOOLS&nbsp;</a>|
<!--    <a href=<?php echo $root."rp_src/rp_control.php3?rpconfigfile=rp_config_duser.inc";?> class="menu" target="_top" onClick="visibility='hide';">&nbsp;м/души&nbsp;</a>| -->
<!--     <a href="<?php echo $root."view_client_time.php3" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;клиент&nbsp;</a>| -->
	<!--a href="<?php echo $root."stat/" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;аналитика&nbsp;</a>|-->
    <!--a href="<?php echo $root."other/test-user.php3" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;postbox&nbsp;</a>|-->
	<a href="<?php echo $root."pbank/index.php3" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;банк&nbsp;</a>|
    <a href="<?php echo $root."options.php3" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;настройка&nbsp;</a>|
    <a href="<?php echo $root."/stat" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;аналитика&nbsp;</a>
  </td></tr> 
</table>

<nolayer>
</div>
</nolayer>

</layer>

<!-- Submenu reports -->
<layer id="reports" onMouseOut="visibility='hide'" left="600" top="29" height="8" bgcolor="#006699" visibility="hide" z-index="10">

<nolayer>
<div id="ms_reports" onClick="style.display='none';" style="position:absolute; left:600px; top:29px; height:19px; z-index:10; background-color:#006699; display: none">
</nolayer>

<table cellpadding="2" cellspacing="0" bgcolor="#006699">
  <tr><td nowrap class="menu">
    <a href="<?php echo $root."reports/index.php3" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;наработка&nbsp;</a>|
    <a href="<?php echo $root."reports/PPP.php3" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;наработка PPP&nbsp;</a>|
    <a href="<?php echo $root."reports/LL.php3" ?>" class="menu" target="_top" onClick="visibility='hide';">&nbsp;наработка LL&nbsp;</a>

  </td></tr>
</table>

<nolayer>
</div>
</nolayer>

</layer>
<?
;}
?>
