<?php
session_start();
require_once 'DbManager.php';

//フォームに文字が入力されているか・ログイン処理
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['user_id']) or empty($_POST['password'])) {
        $display_message = "ログイン名・パスワードが入力されていません";
        session_destroy();
        exit();
    } else {
        if (isset($_POST['user_id']) and isset($_POST['password'])) {
            $db = getDb();
            $stt = $db->prepare("select * from login where user_id = :user_id and password = :password");
            $stt->bindValue(':user_id', $_POST["user_id"]);
            $stt->bindValue(':password', $_POST["password"]);
            $stt->execute();
            $result = $stt->fetch();

            if ($result == false) {
                $display_message = 'IDもしくはパスワードが違います<br><br><a href="http://192.168.33.10/bbs_smarty/login.php">ログイン画面に戻る</a>';
            } else {
                $_SESSION["user_id"] = $_POST['user_id'];
                $_SESSION["password"] = $_POST['password'];
                header('Location: http://192.168.33.10/bbs_db/DBver.php');
                exit;
            }
        } else {
            $display_message = "ログイン名・パスワードが入力されていません";
            session_destroy();
            exit();
        }
    }
}
//未定義エラーを無くすため
if (!isset($display_message)){
    $display_message = NULL;
}

require_once('/vagrant/smarty/libs/Smarty.class.php');

$smarty = new Smarty();

$smarty->template_dir = '/var/www/html/bbs_smarty/templates';
$smarty->compile_dir = '/var/www/html/bbs_smarty/templates_c/';
$smarty->config_dir = '/var/www/html/bbs_smarty/configs/';
$smarty->cache_dir = '/var/www/html/bbs_smarty/cache/';

$smarty->assign('display_message', $display_message);
$smarty->display('login.tpl');