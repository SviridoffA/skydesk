<?
$host = "localhost";
$user = "root";
$pass = "zabbix";
$dbname = "geocoder";
$mysqli = new mysqli($host, $user, $pass, $dbname);
$mysqli->set_charset("utf8");

if ($_POST){
	$table = $_POST['table'];
	$field = $_POST['field'];
	$id = $_POST['id'];
	$value = $_POST['value'];

	$query = "UPDATE `".$table."` SET `".$field."`='".$value."' WHERE id = '".$id."'";
	$mysqli->query($query);
	echo "Updated success";
	exit();

}

$query = "SELECT * from cable_property";
$table = $mysqli->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Редактор таблиц SkyInet</title>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
</head>
<body>
	
	<div class="container-fluid">
		<h1 class="text-center">Редактирование кабелей</h1>
		<table class="table table-striped table-bordered" id="cable_property">
		<tbody>
			<tr>
				<th>№</th>
				<th>Тип кабеля</th>
				<th>Цветовая гамма</th>
				<th>Начальная точка</th>
				<th>Конечная точка</th>
				<th>Маршрут</th>
				<th>Кол-во волокон</th>
			</tr>
			
			<?foreach ($table as $rows) {?>
				<tr>
					<td class="edit cable_numberid <?=$rows['id']?>"><?=$rows['cable_numberid']?></td>
					<td class="edit cable_type <?=$rows['id']?>"><?=$rows['cable_type']?></td>
					<td class="edit cable_colours <?=$rows['id']?>"><?=$rows['cable_colours']?></td>
					<td class="edit cable_start_pos <?=$rows['id']?>"><?=$rows['cable_start_pos']?></td>
					<td class="edit cable_end_pos<?=$rows['id']?>"><?=$rows['cable_end_pos']?></td>
					<td class="edit cable_route <?=$rows['id']?>"><?=$rows['cable_route']?></td>
					<td class="edit cable_fibre_numbers <?=$rows['id']?>"><?=$rows['cable_fibre_numbers']?></td>
				</tr>
			<?}?>
		</tbody>
		</table>
	</div>

	<script>

		$(document).on('click', 'td.edit', function(){
			$('.ajax').html($('.ajax input').val());
			$('.ajax').removeClass('ajax');
			$(this).addClass('ajax');
			$(this).html('<input id="editbox" size="'+ $(this).text().length+'" value="' + $(this).text() + '" type="text">');
			$('#editbox').focus();
		});

		$(document).on('keydown', 'td.edit', function(event){
		arr = $(this).attr('class').split( " " );
		   if(event.which == 13)
		   {
				var table = $('table').attr('id');
				$.ajax({ type: "POST",
				url:"table-edit.php",
				 data: "value="+$('.ajax input').val()+"&id="+arr[2]+"&field="+arr[1]+"&table="+table,
				 success: function(data){
				 $('.ajax').html($('.ajax input').val());
				 $('.ajax').removeClass('ajax');
				 }});
		 	}

		});

		$(document).on('blur', '#editbox', function(){

				var arr = $('td.edit').attr('class').split( " " );
				var table = $('table').attr('id');
				$.ajax({ type: "POST",
				url:"table-edit.php",
				 data: "value="+$('.ajax input').val()+"&id="+arr[2]+"&field="+arr[1]+"&table="+table,
				 success: function(data){
				 $('.ajax').html($('.ajax input').val());
				 $('.ajax').removeClass('ajax');
				 }});
		});

	</script>
	
</body>
</html>