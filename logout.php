<?php
session_start();
$_SESSION = array();
if (isset($_COOKIE[session_name()])){
    setcookie(session_name(), '', time(), - 3600, '/');
}
session_destroy();
header('Location: http://192.168.33.10/bbs_db/DBver.php');
exit;
