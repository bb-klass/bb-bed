<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['moveFields']=='移动') {
    $fieldName = $_POST['fieldName'];
    $afterField = $_POST['after'];
    $sqlobj = new Sql();
    $conn = $sqlobj->connect();
    $fi = mysqli_fetch_array(mysqli_query($conn, 'select id from tb_fields where fieldName = "'.$fieldName.'"'));
    $af = mysqli_fetch_array(mysqli_query($conn, 'select id from tb_fields where fieldName = "'.$afterField.'"'));
    $result = mysqli_query($conn, 'select tableName from tb_industry');
    $result1 = mysqli_query($conn, 'select tableName from tb_industry');
    if ($fi[0] > $af[0]) {
        while ($row = mysqli_fetch_array($result)) {
            $sqlobj->move_field($conn, $fieldName, $afterField, $row[0]);
            echo $row[0];
        }
        mysqli_query($conn, 'update tb_fields set id = "0" where id = "'.$fi[0].'"');        
        for ($i = ($fi[0]-1); $i > $af[0]; $i--) {
            mysqli_query($conn, 'update tb_fields set id = "'.($i+1).'" where id = "'.$i.'"');
        }
        mysqli_query($conn, 'update tb_fields set id ="'.($af[0]+1).'"where id = "0"');
        $sqlobj->close($conn);
        echo "<script>alert('字段移动成功');history.go(-1);</script>";
    }
    if ($fi[0] < $af[0]) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $sqlobj->move_field($conn, $fieldName, $afterField, $row1[0]);
        }
        mysqli_query($conn, 'update tb_fields set id = "0" where id = "'.$fi[0].'"');
        for ($i = ($fi[0]+1); $i <= $af[0]; $i++) {
            mysqli_query($conn, 'update tb_fields set id = "'.($i-1).'" where id = "'.$i.'"');
        }
        mysqli_query($conn, 'update tb_fields set id ="'.($af[0]).'"where id = "0"');
        $sqlobj->close($conn);
        echo "<script>alert('字段移动成功');history.go(-1);</script>";
    }
    if ($fi[0] == $af[0]) {
        echo "<script>history.go(-1);</script>";
    }
}
else {
    echo "<script>history.go(-1);</script>";
}