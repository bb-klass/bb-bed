<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['reviseDetail'] =='修改') {
    $sqlobj = new Sql();
    $change = new ToFloat();
    $conn = $sqlobj->connect();
    $fieldName = $_POST['fieldName'];
    $id = $_POST['contentId'];
    $table = $_POST['table'];
    $newContent = $_POST['reviseContent'];
    $result = mysqli_query($conn, 'select fieldName from tb_fields where id = "1"');
    $fi = mysqli_fetch_array($result);
    if ($fieldName == $fi[0]) {
        $num = $change->num_to_float($newContent);
        mysqli_query($conn, 'update '.$table.' set '.$fieldName.' = "'.$num.'" where id = "'.$id.'"');
    }
    else {
    mysqli_query($conn, 'update '.$table.' set '.$fieldName.' = "'.$newContent.'" where id = "'.$id.'"');
    }
    $sqlobj->close($conn);
    echo '<script>alert("修改成功");history.go(-1);</script>';
}
else {
    echo '<script>history.go(-1);</script>';
}