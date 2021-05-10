<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['fieldChangeWidth'] =='更改显示宽度') {
    $sqlobj = new Sql();
    $field = $_POST['fieldName'];
    $width = $_POST['chfieldWidth'];
    $sqlobj->change_width($field, $width);
    echo "<script>alert('显示宽度修改成功');history.go(-1);</script>";
}
else {
    echo '<script>history.go(-1);</script>';
}