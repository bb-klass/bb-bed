<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['newInLoad'] =='提交'){
    $chName = $_POST['chName'];
    $enName = $_POST['enName'];
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    $result1 = $sqlobj->search_data($conn, 'select industryName from tb_industry where industryName="'.$chName.'"');
    $arr1 = mysqli_fetch_array($result1);
    $result2 = $sqlobj->search_data($conn, 'select tableName from tb_industry where tableName="'.$enName.'"');
    $arr2 = mysqli_fetch_array($result2);
    $sqlobj->close($conn);
    if ($arr1[0]) {
        echo "<script>alert('中文名称重复');history.go(-1);</script>";
    }
    elseif ($arr2[0]) {
        echo "<script>alert('英文名称重复');history.go(-1);</script>";
    }
    else {
        $sqlobj->create_industry($chName, $enName);
        echo "<script>alert('行业添加成功');history.go(-1);</script>";
    }
}
else {
    echo "<script>history.go(-1);</script>";;
}