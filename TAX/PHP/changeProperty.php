<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['changeProperty'] =='更改') {
    $property = $_POST['property'];
    $user = $_POST['username'];
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    mysqli_query($conn, 'update tb_user set PROPERTY = "'.$property.'" where USERNAME = "'.$user.'"');
    $sqlobj->close($conn);
    echo '<script>alert("权限更改成功");history.go(-1);</script>';
}
else {
    echo '<script>history.go(-1);</script>';
}