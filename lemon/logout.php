<?php
// filepath: c:\Users\97701\Desktop\Lemon\lemon\logout.php

// 启动会话
session_start();

// 取消设置所有的会话变量
$_SESSION = array();

// 销毁会话
session_destroy();

// 重定向到登录页面
header("location: login.html");
exit;
?>