<?php 
include_once "conn.php";
include_once 'logic.php';
session_start();
error_reporting( E_ALL&~E_NOTICE );
if ($_SESSION['user']) {
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" type="text/css" href="../CSS/table.css"/>
<link rel="stylesheet" type="text/css" href="../CSS/form.css"/>
<link rel="stylesheet" type="text/css" href="../CSS/text.css"/>
<script src="../JS/action.js"></script>
<title>信息详情</title>
<?php
$connect = new Sql();
$conn = $connect->connect();
if ($_GET['action']=="showdetail") {   
    $table = $_GET['table'];
    $id = $_GET['id'];
    $datalist = $_GET['list'];
}
elseif ($_GET['action']=='last_item') {
    $table = $_GET['table'];
    $dir = $_GET['direc'];
    $datalist = $_GET['list'];
    $fff2 = mysqli_query($conn, 'select fieldName from tb_fields where id="1"');
    $fname = mysqli_fetch_array($fff2);
    $lastResult = mysqli_query($conn, 'select '.$fname[0].' from '.$table.' where '.$fname[0].' < "'.$dir.'" order by '.$fname[0].' desc limit 1');
    $lastDir = mysqli_fetch_array($lastResult);
    if ($lastDir[0]) {
    $idResult = mysqli_query($conn, 'select id from '.$table.' where '.$fname[0].' = "'.$lastDir[0].'"');
    $idArray = mysqli_fetch_array($idResult);
    $id = $idArray[0]; 
    }
    else {
        echo "<script>alert('已经翻到开头了！');history.go(-1);</script>";
    }
}
elseif ($_GET['action']=='next_item') {
    $table = $_GET['table'];
    $dir = $_GET['direc'];
    $datalist = $_GET['list'];
    $fff2 = mysqli_query($conn, 'select fieldName from tb_fields where id="1"');
    $fname = mysqli_fetch_array($fff2);
    $lastResult = mysqli_query($conn, 'select '.$fname[0].' from '.$table.' where '.$fname[0].' > "'.$dir.'" order by '.$fname[0].' asc limit 1');
    $lastDir = mysqli_fetch_array($lastResult);
    if ($lastDir[0]) {
        $idResult = mysqli_query($conn, 'select id from '.$table.' where '.$fname[0].' = "'.$lastDir[0].'"');
        $idArray = mysqli_fetch_array($idResult);
        $id = $idArray[0];
    }
    else {
        echo "<script>alert('已经翻到结尾了！');history.go(-1);</script>";
    }
}
else {
    $table = "tb_in_estate";
    $id = "1";
    $datalist = "房地产行业";
}
$result = mysqli_query($conn, "select * from $table where id =$id");
if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
$row = mysqli_fetch_row($result);
$count = count($row);
$query = mysqli_query($conn, "select fieldName from tb_fields order by id ASC");
$row1 = mysqli_fetch_row($query);
$directory = new ToNum();
$fff1 = mysqli_query($conn, 'select fieldName from tb_fields where id="1"');
$fname1 = mysqli_fetch_array($fff1);
$res1 = mysqli_query($conn, 'select '.$fname1[0].' from '.$table.' where id ="'.$id.'"');
$direc = mysqli_fetch_array($res1);
?>
<link rel="stylesheet" type="text/css" href="../CSS/table.css"/>
<link rel="stylesheet" type="text/css" href="../CSS/form.css"/>
<link rel="stylesheet" type="text/css" href="../CSS/text.css"/>
</head>
<body id='detailMain'>
<header id='detailHeader'>
	<div><?php echo "<a href=industry.php?action=back&list=$datalist&table=".$table.">返回上级</a>"?></div>
</header>
<aside id='lastButton'><?php echo "<a href=details.php?action=last_item&list=".$datalist."&table=".$table."&direc=".$direc[0].">上一项</a>"?></aside>
<section id="detailMain">
	<div>
		<div>
			<h3><?php echo $row1[0];?></h3>
			<p><?php 
			$numX = $directory->float_to_num($row[1]);
			    if ($_SESSION['property'] == 'normal') {
			    echo $directory->float_to_num($row[1]);
			   
			}
			    if ($_SESSION['property'] == 'adm' || $_SESSION['property'] == 'superAdm') {
			    echo "<form onsubmit='return revise_content()' action='reviseContent.php' method='post'><textarea class='chContent' name='reviseContent' cols='10' rows='2'/>".$numX."</textarea><input type='hidden' name='fieldName' value='".$row1[0]."'/><input type='hidden' name='table' value='".$table."'/><input type='hidden' name='contentId' value='".$id."'/><input class='submitButton' type='submit' name='reviseDetail' value='修改'/></form>";
    		}
    		?></p>
		</div>
		<?php for ($i = 2; $i <= $count; $i++) {
		    while ($row1 = mysqli_fetch_row($query)) {
		        echo '<div><h3>'.$row1[0].'</h3>';
		        if ($_SESSION['property'] == 'normal') {
		            echo '<p>'.$row[$i];
		            
		        }
		        if ($_SESSION['property'] == 'adm' || $_SESSION['property'] == 'superAdm') {
		            echo "<form onsubmit='return revise_content()' action='reviseContent.php' method='post'><textarea class='chContent' name='reviseContent' cols='10' rows='2'/>".$row[$i]."</textarea><input type='hidden' name='fieldName' value='".$row1[0]."'/><input type='hidden' name='table' value='".$table."'/><input type='hidden' name='contentId' value='".$id."'/><input class='submitButton' type='submit' name='reviseDetail' value='修改'/></form>";		            
		        }
		    echo '</p></div>';
		    break;
		    }
		}?>
	</div>
</section>
<aside id='nextButton'><?php echo "<a href=details.php?action=next_item&list=$datalist&table=".$table."&direc=".$direc[0].">下一项</a>"?></aside>
<?php 
}
else {
    header("location:industry.php");
}?></body>
</html>