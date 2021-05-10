<?php
include_once 'conn.php';
session_start();
error_reporting( E_ALL&~E_NOTICE );
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>superAdm</title>
<link rel="stylesheet" type="text/css" href="../CSS/table.css"/>
<link rel="stylesheet" type="text/css" href="../CSS/form.css"/>
<link rel="stylesheet" type="text/css" href="../CSS/text.css"/>
<?php 
?>
</head>
<body id='homeBody'>
<div id="homeLogin">
	<div>
    	<h2>超级管理登陆</h2>
    	<form id="loginInput" name="loginInput" action="superAdmLogin.php" method="post" onsubmit="validateLogin()">
			<span>用户名</span><input class="textInput" name="username" type="text"/>
			<span>密码</span><input class="textInput" name="password" type="password"/>
			<input class="submitButton" type="submit" name="login" value="登陆"/>
		</form>
    </div>
</div>
</body>
</html>