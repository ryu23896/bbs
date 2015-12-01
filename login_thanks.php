<?php
session_start();
require_once 'DbManager.php';

//フォームに文字が入力されているか・ログイン処理
if (empty($_POST['user_name']) or empty($_POST['password'])) {
    print "ログイン名・パスワードが入力されていません";
    session_destroy();
    exit();
} else {
    if (isset($_POST['user_name']) and isset($_POST['password'])) {
        $db = getDb();
        $stt = $db->prepare("select * from login where user_name = :user_name and password = :password");
        $stt->bindValue(':user_name', $_POST["user_name"]);
        $stt->bindValue(':password', $_POST["password"]);
        $stt->execute();
        $result = $stt->fetch();
        
        if ($result == false){
            print '<center>IDもしくはパスワードが違います<br><br><a href="http://192.168.33.10/bbs_db/login.php">ログイン画面に戻る</a></center>';
        }else{
            $_SESSION["user_name"] = $_POST['user_name'];
            $_SESSION["password"] = $_POST['password'];
            header('Location: http://192.168.33.10/bbs_db/DBver.php');
            exit;
            
        }
        
    } else {
        print "ログイン名・パスワードが入力されていません";
        session_destroy();
        exit();
    }
}




