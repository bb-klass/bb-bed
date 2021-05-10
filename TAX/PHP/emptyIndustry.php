<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['emptyTb'] =='清空内容'){
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    $chName = $_POST['tbName'];
    $result = mysqli_query($conn, 'select tableName from tb_industry where industryName ="'.$chName.'"');
    $arr = mysqli_fetch_array($result);
    mysqli_close($conn);
    $sqlobj->truncate_table($arr[0]);
    echo "<script>alert('行业清空成功');history.go(-1);</script>";
}
else{
    echo "<script>history.go(-1);</script>";
}