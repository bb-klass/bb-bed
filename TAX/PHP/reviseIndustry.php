<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['renameTb'] =='重命名') {
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    $oldname = $_POST['tbName'];
    $newname = $_POST['inNewName'];
    $test = 'select industryName from tb_industry where industryName="'.$newname.'"';
    $testResult = $sqlobj->search_data($conn, $test);
    $query = 'update tb_industry set industryName="'.$newname.'" where industryName="'.$oldname.'"';
    $justice = mysqli_fetch_array($testResult);
    if (!$justice[0]) {
        $sqlobj->update($conn,$query);
        mysqli_close($conn);
        echo '<script>alert("修改成功");</script>';
        echo $_POST['renameTb'];
        echo $_POST['tbName'];
        echo $_POST['inNewName'];
    }
    else {
        echo '<script>history.go(-1);alert("新名称已被占用，请重新选择新名称");</script>';
    }
}
else {
    echo '<script>history.go(-1);</script>';
}