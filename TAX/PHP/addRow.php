<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['addRow'] =='添加行') {
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    $table = $_POST['tbName'];
    $result = mysqli_query($conn, 'select fieldName from tb_fields where id ="1"');
    $row = mysqli_fetch_array($result);
    mysqli_query($conn, 'insert into '.$table.' set '.$row[0].' ="0"');
    $sqlobj->close($conn);
    echo '<script>alert("已成功添加一条空白行于该表格最顶端，请点击空白行添加修改内容。");history.go(-1);</script>';
}
else {
    echo '<script>history.go(-1);</script>';
}