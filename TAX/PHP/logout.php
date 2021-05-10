<?php
session_start();
error_reporting( E_ALL&~E_NOTICE );
$_SESSION = array();
session_destroy();
echo "<script>history.go(-1)</script>;";