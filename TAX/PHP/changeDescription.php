<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['changeDescription'] =='修改描述') {
    $description = $_POST['changeDes'];
    $user = $_POST['username'];
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    mysqli_query($conn, 'update tb_user set DESCRIPTION = "'.$description.'" where USERNAME = "'.$user.'"');
  
    $sqlobj->close($conn);
    echo '<script>alert("修改描述成功");history.go(-1);</script>';
}
else {
    echo '<script>history.go(-1);</script>';
}