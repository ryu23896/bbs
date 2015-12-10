<?php
require_once 'DbManager.php';
require_once('/vagrant/smarty/libs/Smarty.class.php');
require_once 'SmartyCall.php';

//フォームに文字が入力されているかどうか・他ユーザーと重複していないかチェック
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['user_id']) or empty($_POST['password'])) {
        $display_message = 'ユーザーIDとパスワードを入力して下さい。';
    } else {
        if (isset($_POST['user_id']) and isset($_POST['password'])) {
            $db = getDb();
            $stt = $db->prepare("select * from login where user_id = :user_id and password = :password");
            $stt->bindValue(':user_id', $_POST["user_id"]);
            $stt->bindValue(':password', $_POST["password"]);
            $stt->execute();
            $result = $stt->fetch();
            if ($result == false) {
                $user_id = $_POST['user_id'];
                $password = $_POST['password'];
                register_data($user_id, $password);
                $display_message = '登録が完了しました！';
            } else {
                $display_message = 'ユーザーIDが他のユーザーと重複しているので変更して下さい。';
            }
        } else {
            $display_message = 'ユーザーIDとパスワードを入力して下さい。';
        }
    }
}

function register_data($user_id, $password) {

    try {
        $db = getDb();
        $stt = $db->prepare('insert into login(user_id, password) values(:user_id, :password)');

        $stt->bindvalue(':user_id', $user_id);
        $stt->bindvalue(':password', $password);

        $stt->execute();
        $db = NULL;
    } catch (Exception $e) {
        die("エラーメッセージ:{$e->getMessage()}");
    }
}

$smarty = new Smarty();
smarty();
$smarty->assign('display_message', $display_message);
$smarty->assign('ipadress', IPADRESS);
$smarty->display('done.tpl');