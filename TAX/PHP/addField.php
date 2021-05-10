<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['newField'] =='提交'){
    $newField = $_POST['fieldName'];
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    $result1 = $sqlobj->search_data($conn, 'select fieldName from tb_fields where fieldName="'.$newField.'"');
    $arr1 = mysqli_fetch_array($result1);
    if ($arr1[0]) {
        echo "<script>alert('字段名称重复');history.go(-1);</script>";
    }
    else {
        $test = 'select tableName from tb_industry';
        $testResult = $sqlobj->search_data($conn, $test);
        $sqlobj->add_field($conn, $newField);
        while ($row = mysqli_fetch_row($testResult)) {
            $sqlobj->add_col($conn, $newField, $row[0]);
        }
        $sqlobj->close($conn);
        echo "<script>alert('字段添加成功');history.go(-1);</script>";
    }
}
else {
    echo "<script>history.go(-1);</script>";;
}