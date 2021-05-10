<?php
include_once 'conn.php';
session_start();
error_reporting( E_ALL&~E_NOTICE );
if ($_POST['login'] == '登陆') {
    $test = new Sql();
    $conn = $test->connect();
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $result = mysqli_query($conn, 'select PROPERTY from tb_user where USERNAME="'.$username.'" and PASSWORD="'.$password.'"');
    $array = mysqli_fetch_array($result);
    if ($array[0]) {
        $_SESSION['user'] = $username;
        $_SESSION['pwd'] = $password;
        $_SESSION['property'] = $array[0];
        if ($_SESSION['property'] == 'superAdm'){
            header("location:superAdmMain.php");
        }
        else {
            echo "<script>alert('用户名或密码不正确！') ;history.go(-1);</script>";
        }
    }
    else {
        echo "<script>alert('用户名或密码不正确！') ;history.go(-1);</script>";
    }
}
?>
    