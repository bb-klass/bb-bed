<?php
include_once 'conn.php';
session_start();
error_reporting( E_ALL&~E_NOTICE );
if ($_SESSION['property'] == 'superAdm'){
?>
<!DOCTYPE html>
<html>
<head>
<title>superAdm</title>
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
ss=document.getElementById('ccc');
mtb=document.getElementById('admTable');
mtb.style.height=h-220+"px";
//alert(w);
ss.style.width=w+"px";
ss.style.height=h+"px";
}
</script>
</head>
<body id='ccc'>
<div id='adm'>
	<h1>超级管理界面</h1>
	<form action="superAddUser.php" onsubmit='return new_user()' method='post' name='addUser'>
		<h3>新增用户</h3>
		<label>用户名</label>
		<input type='text' name='user'/>
		<label>密码</label>
		<input type='password' name='pwd'/>
		<label>确认密码</label>
		<input type='password' name='confirm'/>
		<input type="submit" class='submitButton' name='submit' value='新增'/>
	</form>
	<h3>用户管理</h3>
	<div id='signOut'><a href = "logout.php">注销</a></div>
	<table id='admTable'>
		<tr>
			<th>用户名</th>
			<th>密码</th>
			<th>权限</th>
			<th>描述</th>
			<th>更改权限</th>
			<th>修改描述</th>
			<th>删除用户</th>
		</tr>
		<?php 
		$sqlobj = new Sql();
		$conn = $sqlobj->connect();
		$reDes = mysqli_query($conn, 'select DESCRIPTION from tb_user where PROPERTY ="adm" || PROPERTY ="normal" order by id');
		$result = mysqli_query($conn, 'select * from tb_user where PROPERTY ="adm" || PROPERTY ="normal" order by id');
		while ($row = mysqli_fetch_array($result)) {
		    echo "<tr>";
		    echo "<td>".$row[1]."</td>";
		    echo "<td>".$row[2]."</td>";
		    echo "<td>".$row[3]."</td>";
		    echo "<td>".$row[4]."</td>";
		    echo "<td>";
		    echo "<form action='changeProperty.php' method='post'><select name='property'/><option value = 'normal'>normal</option><option value = 'adm'/>adm</option><input type='hidden' name='username' value='".$row[1]."'/><input type='submit' class='submitButton' name = 'changeProperty' value='更改'/></form>";
		    echo "</td>";
		    echo "<td>";
		    while ($desRow = mysqli_fetch_array($reDes)) {
		    echo "<form action='changeDescription.php' method='post' onsubmit='return confirm_des()'><textarea name='changeDes' cols='10' rows='2'/>".$desRow[0]."</textarea><input type='hidden' name='username' value='".$row[1]."'/><input type='submit' class='submitButton' name = 'changeDescription' value='修改描述'/></form>";
		    break;
		    }
		    echo "</td>";
		    echo "<td>";
		    echo "<form action='dropUser.php' onsubmit='return drop_user()' method='post'><input type='hidden' name='username' value='".$row[1]."'/><input type='submit' class='deleteRow' name = 'dropUser' value='删除'/></form>";
		    echo "</td>";
		    echo "</tr>";
		}?>
	</table>
</div>
</body>
</html>   
<?php }
else {
    header('location:superAdm.php');
}
?>