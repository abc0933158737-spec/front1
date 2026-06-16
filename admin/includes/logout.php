<?php
session_start();
// 清空所有 Session
$_SESSION = array();
session_destroy();

// 跳轉回登入頁
header('Location: login.php');
exit;