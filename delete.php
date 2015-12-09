<?php
session_start();
require_once 'DbManager.php';

//フォームから渡された数値をチェック
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['delete_no'])) {
        $display_message = '投稿Noを入力して下さい。';
    } else {
        if (isset($_POST['delete_no'])) {
            if (is_numeric($_POST['delete_no'])) {
                delete();
                $display_message = '削除しました';
            } else {
                $display_message = '数字を入力して下さい。';
            }
        } else {
            $display_message = '投稿Noを入力して下さい。';
        }
    }
}

//投稿の削除
function delete() {
    try {
        $delete_no = $_POST['delete_no'];
        $db = getDb();
        $stt = $db->prepare("delete from bbs_data where no = :delete_no and user_id = :user_id");
        $stt->bindValue(':delete_no', $delete_no);
        $stt->bindValue(':user_id', $_SESSION['user_id']);
        $stt->execute();
    } catch (Exception $e) {
        die("エラーメッセージ:{$e->getMessage()}");
    }
}

require_once('/vagrant/smarty/libs/Smarty.class.php');

$smarty = new Smarty();

$smarty->template_dir = '/var/www/html/bbs_smarty/templates';
$smarty->compile_dir = '/var/www/html/bbs_smarty/templates_c/';
$smarty->config_dir = '/var/www/html/bbs_smarty/configs/';
$smarty->cache_dir = '/var/www/html/bbs_smarty/cache/';

$smarty->assign('display_message', $display_message);
$smarty->display('delete.tpl');