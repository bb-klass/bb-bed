<?php
include_once "conn.php";
include_once 'logic.php';
session_start();
error_reporting( E_ALL&~E_NOTICE );
if ($_POST['submit'] == '新增') {
    $user = $_POST['user'];
    $pwd = md5($_POST['pwd']);
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    mysqli_query($conn, 'insert into tb_user values("","'.$user.'","'.$pwd.'","normal","")');
    $sqlobj->close($conn);
    echo "<script>alert('用户添加成功');history.go(-1);</script>";
}
else {
    echo "<script>history.go(-1);</script>";;
}