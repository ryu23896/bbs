<?php
session_start();

require_once('/vagrant/smarty/libs/Smarty.class.php');
require_once 'DbManager.php';
require_once 'SmartyCall.php';
ini_set('display_errors', 1);

$smarty = new Smarty();
smarty();

//ログイン状態の判別
if (isset($_SESSION["user_id"])) {
    define('LOGINED', true);
} else {
    define('LOGINED', false);
}

//投稿
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!isset($_POST['user']) or ! isset($_POST['message']) or empty($_POST['user']) or empty($_POST['message'])) {
        $display_message = '文字を入力してください';
    } else {
        $user = $_POST['user'];
        $message = $_POST['message'];
        writeData($user, $message);
    }
}
readData();
$post_data = readData();

$smarty->assign('display_message', $display_message);
$smarty->assign('post_data', $post_data);
$smarty->assign('ipadress', IPADRESS);
function readData() { 
    try {
        $db = getDb();
        $stt = $db->prepare('select * from bbs_data order by no desc');
        $stt->execute();
        while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
            $post_data[] = $row;
        }
        $db = NULL;
    } catch (Exception $e) {
        die("エラーメッセージ：{$e->getMessage()}");
    }
    return $post_data;
}

function writeData($user, $message) {

    if (LOGINED) {
        $user_id = $_SESSION["user_id"];
    } else {
        $user_id = NULL;
    }

    try {
        $db = getDb();

        $stt = $db->prepare('INSERT INTO bbs_data(user,message,user_id) VALUES (:user, :message, :user_id)');

        $stt->bindValue(':user', $user);
        $stt->bindValue(':message', $message);
        $stt->bindValue(':user_id', $user_id);
        $stt->execute();
        $db = NULL;
    } catch (Exception $e) {
        die("エラーメッセージ:{$e->getMessage()}");
    }
}

$smarty->display('DBver.tpl');
