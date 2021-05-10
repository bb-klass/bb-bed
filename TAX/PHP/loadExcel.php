<?php
error_reporting( E_ALL&~E_NOTICE );
include_once "conn.php";
include_once 'logic.php';
if ($_POST['excelLoad'] =='提交'){
    $allow = 'csv';
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    $industry = $_POST['datalist'];
    if ($_FILES["file"]["error"] > 0)
    {
        echo "<script>alert('出现错误，请重新上传');history.go(-1);</script>";
    }
    else{
        if ($extension == $allow) {
            move_uploaded_file($_FILES["file"]["tmp_name"], "../Upload/".$_FILES["file"]["name"]);
            $path = "../Upload/".$_FILES["file"]["name"];
            $content = new ReadExcel();
            $array = $content->csv_to_array($path);
            $change = new ToFloat();
            $sqlArray = $change->arr_to_float($array);
            $sqlobj = new Sql();
            $conn = $sqlobj->connect();
            $que = mysqli_query($conn, 'select tableName from tb_industry where industryName = "'.$industry.'"');
            $table = mysqli_fetch_array($que);
            $result = mysqli_query($conn, 'select fieldName from tb_fields');
            $v1 = mysqli_num_rows($result);
            $countField = $v1+1;
            $countData = count($sqlArray);
            $countTimes = $countData/$countField;
            $ins = array();
            for ($i = -1,$j = 0; $j < $countData; $j++) {
                if ($j%$countField == 0) {
                    $i++;
                }
                $ins[$i] = $ins[$i].",'".$sqlArray[$j]."'";
            }
            for ($i = 0; $i < $countTimes; $i++) {
                $ins[$i] = preg_replace('/^,/', '', $ins[$i]);
            }
            for ($i = 0; $i < $countTimes; $i++) {
                mysqli_query($conn, "insert into tb_in_".$table[0]." values(".$ins[$i].")");
            }
            echo "<script>alert('文件导入成功');history.go(-1);</script>";
        }
        else {
            echo "<script>alert('上传文件格式错误，请转换excel为csv文件');history.go(-1);</script>";
        }
    }
}
else {
    echo "<script>history.go(-1);</script>";
}