
<? 
/* 
   ������ � ������� �� ��������� Nested Sets. 
   ���������� ������� � ������. 
   ������������ ����� dbtree.php 
   ����� ��� �����: http://dev.e-taller.net/dbtree/ 

    --------------------- 
    Author: Maxim Matykhin. 
    mailto: max@webscript.ru 
*/ 

$table="categories"; // ������� ��������� 
$id_name="cid";     // ��� ���� ���������� ����� 
$field_names = array( // ����� ����� ������� 
   'left' => 'cleft', 
   'right'=> 'cright', 
   'level'=> 'clevel', 
); 

require_once "cd.php"; 
require_once "dbtree.php"; 

$dbh=new CDataBase("mvs", "localhost", "root", "#fdnjvfn45"); 
$Tree = new CDBTree($dbh, $table, $id_name, $field_names); 
// ������� "��������" ������ (��. ��������� � ������) 
$id=$Tree->clear(array("title"=>"������ 74")); 

$level_2=array(); 
$level_2[0]=$Tree->insert($id,array("title"=>"��.������ 72")); 
$level_2[1]=$Tree->insert($id,array("title"=>"��.��������� 22�")); 
$level_2[2]=$Tree->insert($id,array("title"=>"��.������ 87")); 
$level_2[3]=$Tree->insert($id,array("title"=>"��.����������� 97")); 
$level_2[4]=$Tree->insert($id,array("title"=>"��.������ 9")); 

// ������ �������� ��������� ������� �������� ������ 
$level_3=array(); 
$level_3[0]=$Tree->insert($level_2[0],array("title"=>"��.������ 81")); 

$level_3[3]=$Tree->insert($level_2[1],array("title"=>"��.�������� 206")); 

$level_3[4]=$Tree->insert($level_2[2],array("title"=>"��.������ 87�")); 

$level_3[6]=$Tree->insert($level_2[3],array("title"=>"�.�������� 70")); 
$level_3[7]=$Tree->insert($level_2[3],array("title"=>"��.����������� 95")); 
                                               
// � ��� ��������� ������� ��������� ������� 
$Tree->insert($level_3[0],array("title"=>"��.��������� 19�")); 
$Tree->insert($level_3[0],array("title"=>"��.������ 75�")); 
$Tree->insert($level_3[3],array("title"=>"��.�������� 204")); 
$Tree->insert($level_3[6],array("title"=>"��.����������� 91")); 
$Tree->insert($level_3[6],array("title"=>"�.�������� 68")); 
echo "������� ���������."; 
?> 