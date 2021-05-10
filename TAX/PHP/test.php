<?php
$path = parse_url( "http://localhost/index.php/index/hi");
$path2 = parse_url( "http://localhost/Advance/index.php/index/hi");
var_dump($path);
var_dump($path2);
if (strpos($path['path'], 'index.php') == 0) {
    $urlR0 = $path['path'];
}
else {
    $urlR0 = substr($path['path'], strpos($path['path'],'index.php') + strlen('index.php'));  //strlen的用法
}
echo $urlR0."<br/>";
if (strpos($path2['path'], 'index.php') == 0) {
    $urlR = $path2['path'];
}
else {
    $urlR = substr($path2['path'], strpos($path2['path'],'index.php') + strlen('index.php'));  //strlen的用法
}
echo $urlR."<br/>";
echo strpos($path2['path'],'index.php');
