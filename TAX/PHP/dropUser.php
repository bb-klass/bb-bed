<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['dropUser'] =='删除') {
    $user = $_POST['username'];
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    mysqli_query($conn, 'delete from tb_user where USERNAME = "'.$user.'"');
    $sqlobj->close($conn);
    echo '<script>alert("用户删除成功");history.go(-1);</script>';
}
else {
    echo '<script>history.go(-1);</script>';
}