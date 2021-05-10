<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['deleteRow'] =='删除行') {
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    $table = $_POST['tbName'];
    $id = $_POST['rowId'];
    mysqli_query($conn, 'delete from '.$table.' where id ="'.$id.'"');
    $sqlobj->close($conn);
    echo '<script>alert("删除成功");history.go(-1);</script>';
}
else {
    echo '<script>history.go(-1);</script>';
}