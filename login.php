<?php
session_start();
require_once 'DbManager.php';
require_once('/vagrant/smarty/libs/Smarty.class.php');
require_once'SmartyCall.php';

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
                $display_message = 'IDもしくはパスワードが違います。';
            } else {
                $_SESSION["user_id"] = $_POST['user_id'];
                $_SESSION["password"] = $_POST['password'];
                header('Location: http://192.168.33.10/bbs_smarty/DBver.php');
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

$smarty = new Smarty();
smarty();
$smarty->assign('display_message', $display_message);
$smarty->assign('ipadress', IPADRESS);
$smarty->display('login.tpl');