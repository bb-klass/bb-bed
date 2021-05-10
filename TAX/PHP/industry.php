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
<title>信息列表</title>
<?php
$industry = new Sql();
$conn = $industry->connect();
$industryQuery = $industry->search_data($conn, "select industryName from tb_industry");
if ($_GET['submit']) {
    $query = "select tableName from tb_industry where industryName = '".$_GET['datalist']."'";
    $tabResult = $industry->search_data($conn, $query);
    $tabArray = mysqli_fetch_row($tabResult);
    mysqli_free_result($tabResult);
    if (!$tabArray[0]){
        echo "<script>history.go(-1);</script>";
    }
    else {
    $tb = 'tb_in_'.$tabArray[0];
    $datalist = $_GET["datalist"];
    }
}
elseif ($_GET['action']=="back") {
    $tb = $_GET['table'];
    $datalist = $_GET['list'];
}
else {
    $tb = "tb_in_estate";
    $datalist = "房地产行业";
}
?>
<link rel="stylesheet" type="text/css" href="../CSS/table.css"/>
<link rel="stylesheet" type="text/css" href="../CSS/form.css"/>
<link rel="stylesheet" type="text/css" href="../CSS/text.css"/>
<script src="../JS/action.js"></script>
<script>
var ss;
var mtb;
window.onload=function()
{
var w=document.documentElement.clientWidth ;//可见区域宽度
var h=document.documentElement.clientHeight;//可见区域高度
ss=document.getElementById('bbb');
mtb=document.getElementById('mainTable');
mtb.style.height=h-220+"px";
//alert(w);
ss.style.width=w+"px";
ss.style.height=h+"px";
}
</script>
</head>
<body id='bbb'>
<header id="fix1">
<section>
<div id='headerItem'>
	<div class='headerDiv'><span>当前行业是:<b><?php echo $datalist;?></b></span></div>
	<div class='headerDiv'>
	  <div>
	  	<span>选择行业</span>
		<form action="industry.php" method="get" autocomplete="on">
		<input class="textInput" type="text" name="datalist" list="industryList"/>
		<datalist id="industryList" style="dispaly:none">
			<?php while ($row = mysqli_fetch_row($industryQuery)) {		    
		  echo "<option value=".$row[0].">".$row[0]."</option>";}?>
		</datalist>
		<input class="submitButton" type="submit" name="submit" value="进入"/>
		</form>
	  </div>
	</div>
	<?php 
	if ($_SESSION['property'] == 'adm' || $_SESSION['property'] == 'superAdm') {
	    echo "<div class='headerDiv'><div><button type='button' onclick='open_excel()'>excel文件导入</button></div></div>";
	    echo "<div class='headerDiv'><div><button type='button' onclick='open_trade()'>行业管理</button></div></div>";
	    echo "<div class='headerDiv'><div><button type='button' onclick='open_field()'>字段管理</button></div></div>";
	}
	if ($_SESSION['user']) {
	    echo '<div class="headerDiv"><div><a href = "logout.php">注销</a></div></div>';
	}
	
	?>
</div>
</section>
<section id='unfoldPart'>
	<div style='float:left'>
		<table class='titleButton'>
			<tr>
				<td>1级</td>
				<td>2级</td>
				<td>3级</td>
				<td>4级</td>
				<td>5级</td>
			</tr>
			<tr>
				<td><button id='title1' onclick="unfold_title(this)">-</button></td>
				<td><button id='title2' onclick="unfold_title(this)">-</button></td>
				<td><button id='title3' onclick="unfold_title(this)">-</button></td>
				<td><button id='title4' onclick="unfold_title(this)">-</button></td>
				<td><button id='title5' onclick="unfold_title(this)">-</button></td>
			</tr>
		</table>
	</div>
	<div style='float:right'>
		<table class='foldButton'>
		<tr>
			<?php $industryQuery7 = $industry->search_data($conn, "select fieldName from tb_fields order by id ASC");
			while ($row7 = mysqli_fetch_row($industryQuery7)) {
			    echo "<td>".$row7[0]."</td>";
			}
			mysqli_free_result($industryQuery7);?>
		</tr>
		<tr>
			<?php $industryQuery8 = $industry->search_data($conn, "select id from tb_fields order by id ASC");
			
			while ($row8 = mysqli_fetch_row($industryQuery8)){
			    echo "<td><button id='fieldNo".$row8[0]."' onclick='unfold_title(this)'>-</button></td>";
			}
			mysqli_free_result($industryQuery8);?>
		</tr>
		</table>
	</div>
</section>
</header>
<section id="excelShade" style="display:none">
	<div id="indexWindow">
		<div>
			<h2>导入到已存在行业</h2>
			<form class="excelInput" action="loadExcel.php" method="post" enctype="multipart/form-data" autocomplete="on">
					<div>
						<span>选择行业：</span><input class="newTextInput" type="text" name="datalist" list="newOrOldList"/>
						<datalist id="newOrOldList" style="dispaly:none">
						<?php $industryQuery1 = $industry->search_data($conn, "select industryName from tb_industry");
						while ($row1 = mysqli_fetch_row($industryQuery1)) {		    
		                echo "<option value=".$row1[0].">".$row1[0]."</option>";}
		                mysqli_free_result($industryQuery1);?>
						</datalist>
					</div>
					<div>
						<input class="fileInput" type="file" name="file"/>
						<input class="newSubmitButton" type="submit" name="excelLoad" value="提交"/>
					</div>
			</form>
			<div><a id='excelSM' href='../File/EXCEL.docx'>Excel导入说明</a></div>
		</div>
		<div>
			<button class="backButton" onclick="return hidden_excel()" type="button">返回</button>
		</div>
	</div>
</section>
<section id="tradeShade" style="display:none">
<div id="indexWindow1">
	<div>
		<h2>行业管理</h2>
		<ul>
			<?php $industryQuery2 = $industry->search_data($conn, "select industryName from tb_industry");
			while ($row2 = mysqli_fetch_row($industryQuery2)) {		    
			    echo "<li>".$row2[0]."<form action='reviseIndustry.php' onsubmit='return rename_industry()' method='post'><input type='hidden' name='tbName' value='".$row2[0]."'/><input type='hidden' name='inNewName' value=''/><input class='submitButton' type='submit' name='renameTb' value='重命名'/></form><form action='deleteIndustry.php' onsubmit='return delete_industry()' method='post'><input type='hidden' name='tbName' value='".$row2[0]."'/><input class='submitButton' type='submit' name='dropTb' value='删除行业'/></form><form action='emptyIndustry.php' onsubmit='return truncate_industry()' method='post'><input type='hidden' name='tbName' value='".$row2[0]."'/><input class='submitButton' type='submit' name='emptyTb' value='清空内容'/></form></li>";}
			    mysqli_free_result($industryQuery2);?>
		</ul>
	</div>
	<div>
		<h3>添加新行业</h3>
		<form method="post" action='addIndustry.php'>
		<span>新行业名称：</span><input class="newTextInput" type="text" name='chName' placeholder="如：房地产行业"/>
		<span>英文名称(用于检索)：</span><input class="newTextInput" type="text" name='enName' placeholder="如：estate"/>
		<input class="newSubmitButton" type="submit" name="newInLoad" value="提交"/>
		</form>
	</div>
	<div>
		<button class="backButton" onclick="return hidden_trade()" type="button">返回</button>
	</div>
</div>
</section>
<section id="fieldShade" style="display:none">
<div id="indexWindow2">
	<section>
	<div>
		<h2>字段管理</h2>
		<ul>
			<?php $industryQuery4 = $industry->search_data($conn, "select fieldName from tb_fields order by id ASC");
			$industryQuery12 = $industry->search_data($conn, "select fieldName from tb_fields order by id ASC");
			$plia = array();
			while ($row12 = mysqli_fetch_row($industryQuery12)) {
			    array_push($plia, $row12[0]);
			}
			mysqli_free_result($industryQuery12);
			$row4 = mysqli_fetch_row($industryQuery4);
			echo "<li>".$row4[0]."<form action='reviseField.php' onsubmit='return rename_field()' method='post'><input type='hidden' name='fieldName' value='".$row4[0]."'/><input type='hidden' name='fiNewName' value=''/><input class='submitButton' type='submit' name='renameField' value='重命名'/></form><form action='deleteField.php' method='post' onsubmit='return delete_field()'><input type='hidden' name='fieldName' value='".$row4[0]."'/><input class='disabled' type='submit' name='deleteField' disabled='disabled' value='删除字段'/></form><form action='fieldWidth.php' onsubmit='return field_width()' method='post'><input type='hidden' name='chfieldWidth' value=''/><input type='hidden' name='fieldName' value='".$row4[0]."'/><input class='submitButton' type='submit' name='fieldChangeWidth' value='更改显示宽度'/></form action='moveField.php' method='post'><form><span> \n移动字段到...之后</span><input type='hidden' name='fieldName' value='".$row4[0]."'/><select name='after'>";for ($i = 0; $i < count($plia); $i++) {echo "<option value='".$plia[$i]."'>".$plia[$i]."</option>";}echo "<input class='disabled' type='submit' disabled='disabled' name='moveFields' value='移动'/></form></li>";
		while($row4 = mysqli_fetch_row($industryQuery4)){
		    echo "<li>".$row4[0]."<form action='reviseField.php' onsubmit='return rename_field()' method='post'><input type='hidden' name='fieldName' value='".$row4[0]."'/><input type='hidden' name='fiNewName' value=''/><input class='submitButton' type='submit' name='renameField' value='重命名'/></form><form action='deleteField.php' method='post' onsubmit='return delete_field()'><input type='hidden' name='fieldName' value='".$row4[0]."'/><input class='submitButton' type='submit' name='deleteField' value='删除字段'/></form><form action='fieldWidth.php' onsubmit='return field_width()' method='post'><input type='hidden' name='chfieldWidth' value=''/><input type='hidden' name='fieldName' value='".$row4[0]."'/><input class='submitButton' type='submit' name='fieldChangeWidth' value='更改显示宽度'/></form><form action='moveField.php' method='post'><span> \n移动字段到...之后</span><input type='hidden' name='fieldName' value='".$row4[0]."'/><select name='after'>";for ($i = 0; $i < count($plia); $i++) {echo "<option value='".$plia[$i]."'>".$plia[$i]."</option>";}echo "<input class='submitButton' type='submit'  name='moveFields' value='移动'/></form></li>";
		}
		mysqli_free_result($industryQuery4);?>
		</ul>
	</div>
	</section>
	<section>
	<div>
		<h3>增加字段</h3>
		<form action='addField.php' method='post'>
			<input class="newTextInput" name='fieldName' type="text"/>
			<input class="newSubmitButton" type="submit" name="newField" value="提交"/>
		</form>
	</div>
	<div>
		<button class="backButton" onclick="return hidden_field()" type="button">返回</button>
	</div>
	</section>
</div>
</section>
<section>
<div>
<section id="fixTable">
	<div>
		<?php 
		$industryQuery6 = $industry->search_data($conn, "select width from tb_fields order by id ASC");
		$industryQuery3 = $industry->search_data($conn, "select fieldName from tb_fields order by id ASC");
		$industryQuery9 = $industry->search_data($conn, "select id from tb_fields order by id ASC");
		while($row3 = mysqli_fetch_row($industryQuery3)){
		    while($row9 = mysqli_fetch_row($industryQuery9)){
		        while ($row6 = mysqli_fetch_row($industryQuery6)) {
		echo '<div style="width:'.$row6[0].'" class=fieldNo'.$row9[0].'>'.$row3[0].'</div>';
		break;  }
		break;
		    }}
		    mysqli_free_result($industryQuery6);
		    mysqli_free_result($industryQuery3);
		    mysqli_free_result($industryQuery9);?>
		<?php if ($_SESSION['property'] == 'adm' || $_SESSION['property'] == 'superAdm'){
		    echo "<div style='width:150px'><form action='addRow.php' method='post'><input type='hidden' name='tbName' value='".$tb."'/><input id='addRow' name='addRow' type='submit' value='添加行'/></form></div>";
            }
        ?>
	</div>
</section>
<section id="mainTable">
<?php
$industryQuery11 = $industry->search_data($conn, "select width from tb_fields order by id ASC");
$push = array();
while ($row11 = mysqli_fetch_row($industryQuery11)) {
    array_push($push, $row11[0]);
}
mysqli_free_result($industryQuery11);
$gta = mysqli_query($conn, 'select fieldName from tb_fields where id ="1"');
$gtab = mysqli_fetch_array($gta);
mysqli_free_result($gta);
$dataArray = $industry->search_data($conn, "select * from $tb order by ".$gtab[0]." ASC");
$dir = new ToNum();
while ($collect = mysqli_fetch_row($dataArray)){
    $arrayNum = $dir->float_to_num($collect[1]);
    echo "<div class=".DiffCss::justice($arrayNum).">";
    echo "<div style='width:".$push[0]."' class='fieldNo1'><a href=details.php?action=showdetail&list=$datalist&table=$tb&id=".$collect[0].">".$arrayNum."</a></div>";
    for ($i = 2; $i < count($collect); $i++) {
        echo "<div style='width:".$push[$i-1]."' class=fieldNo".$i."><a href=details.php?action=showdetail&list=$datalist&table=$tb&id=".$collect[0].">".$collect[$i]."</a></div>"; 
    }
    if ($_SESSION['property'] == 'adm' || $_SESSION['property'] == 'superAdm'){ echo "<div style='width:150px'><form action='deleteRow.php' onsubmit='return delete_row()' method='post'><input type='hidden' name='tbName' value='".$tb."'/><input type='hidden' name='rowId' value='".$collect[0]."'/><input class='deleteRow' name='deleteRow' type='submit' value='删除行'/></form></div>";
        }
    echo "</div>";
}
mysqli_free_result($dataArray);
?>
</section>
</div>
</section>
<?php $industry->close($conn);
}
else {
    header("location:home.php");
}?>
</body>
</html>