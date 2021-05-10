<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['deleteField'] =='删除字段') {
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    $oldName = $_POST['fieldName'];
    $deo = mysqli_query($conn, 'select tableName from tb_industry');
    $sqlobj->delete_field($conn, $oldName);
    while ($row = mysqli_fetch_array($deo)) {
        $sqlobj->drop_field($conn, $oldName, $row[0]);
    }
    $sqlobj->close($conn);
    echo "<script>alert('行业删除成功');history.go(-1);</script>";
}
else{
    echo "<script>history.go(-1);</script>";
}