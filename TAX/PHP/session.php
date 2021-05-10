<?php
error_reporting( E_ALL&~E_NOTICE );
function _session_open($save_path,$session_name)
{
    global $handle;
    $handle = mysqli_connect('localhost','root','111') or die('数据库连接失败');		// 连接MYSQL数据库
    mysqli_select_db($handle,'db_tax') or die('数据库中没有此库名');				// 找到数据库
    return(true);
}

function _session_close()
{
    global $handle;
    mysqli_close($handle);
    return(true);
}

function _session_read($key)
{
    global $handle;							// 全局变量$handle 连接数据库
    $time = time();							// 设定当前时间
    $sql = "select session_data from tb_session where session_key = '$key' and session_time < $time";
    $result = mysqli_query($handle,$sql);
    $row = mysqli_fetch_array($result);
    if ($row)
    {
        return($row['session_data']);			// 返回Session名称及内容
    }else
    {
        return(false);
    }
}

function _session_write($key,$data)
{
    global $handle;
    $time = 60*60*24;										// 设置失效时间
    $lapse_time = time() + $time;						// 得到Unix时间戳
    $handle = mysqli_connect('localhost','root','111') or die('数据库连接失败');		// 连接MYSQL数据库
    mysqli_select_db($handle,'db_tax') or die('数据库中没有此库名');				// 找到数据库
    $sql = "select session_data from tb_session where session_key = '$key' and session_time < $lapse_time";
    $result = mysqli_query($handle,$sql);
    if (mysqli_num_rows($result) == 0 )				// 没有结果
    {
        $sql = "insert into tb_session values('$key','$data',$lapse_time)";		// 插入数据库sql语句
        $result = mysqli_query($handle,$sql);
    }else
    {
        $sql = "update tb_session set session_key = '$key',session_data = '$data',session_time = $lapse_time where session_key = '$key'";												// 修改数据库sql语句
        $result = mysqli_query($handle,$sql);
    }
    return($result);
}

function _session_destroy($key)
{
    global $handle;
    $sql = "delete from tb_session where session_key = '$key'";					// 删除数据库sql语句
    $result = mysqli_query($handle,$sql);
    return($result);
}

function _session_gc()
{
    global $handle;
    $lapse_time = time();									// 将参数$lapse_time赋值为当前时间戳
    $sql = "delete from tb_session where session_time < $lapse_time";	// 删除数据库sql语句
    $result = mysqli_query($handle,$sql);
    return($result);
}
session_set_save_handler('_session_open','_session_close','_session_read','_session_write','_session_destroy','_session_gc');

