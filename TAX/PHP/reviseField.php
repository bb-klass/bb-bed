<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['renameField'] =='重命名') {
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    $oldname = $_POST['fieldName'];
    $newname = $_POST['fiNewName'];
    $test = 'select fieldName from tb_fields where fieldName="'.$newname.'"';
    $testResult = $sqlobj->search_data($conn, $test);
    $query = 'update tb_fields set fieldName = "'.$newname.'" where fieldName = "'.$oldname.'"';
    $justice = mysqli_fetch_array($testResult);
    if (!$justice[0]) {
        $sqlobj->update($conn,$query);
        $deo = mysqli_query($conn, 'select tableName from tb_industry');
        $de1 = mysqli_query($conn, 'select tableName from tb_industry');
        $jiu = mysqli_query($conn, 'select id from tb_fields where fieldName = "'.$newname.'"');
        $jus = mysqli_fetch_array($jiu);
        if ($jus[0]=='1'){
            while ($row1 = mysqli_fetch_array($de1)) {
                mysqli_query($conn, 'alter table tb_in_'.$row1[0].' CHANGE COLUMN '.$oldname.' '.$newname.' float NOT NULL');          
            }
        mysqli_close($conn);
        echo '<script>alert("修改成功");history.go(-1);</script>';
        }
        else{
        while ($row = mysqli_fetch_array($deo)) {
            $sqlobj->rename_col($conn, $oldname, $newname, $row[0]);
            }
        mysqli_close($conn);
        echo '<script>alert("修改成功");history.go(-1);</script>';
        }
    }
    else {
        echo '<script>history.go(-1);alert("新名称已被占用，请重新选择新名称");</script>';
    }
}
else {
    echo '<script>history.go(-1);</script>';
}