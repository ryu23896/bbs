<?php
require_once 'DbManager.php';

//フォームに文字が入力されているかどうか・他ユーザーと重複していないかチェック
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['user_name']) or empty($_POST['password'])) {
        print '<p><center>ユーザー名かパスワードを入力して下さい。<center></p>';
    } else {
        if (isset($_POST['user_name']) and isset($_POST['password'])) {
            $db = getDb();
            $stt = $db->prepare("select * from login where user_name = :user_name and password = :password");
            $stt->bindValue(':user_name', $_POST["user_name"]);
            $stt->bindValue(':password', $_POST["password"]);
            $stt->execute();
            $result = $stt->fetch();
            if ($result == false) {
                print '<p><center>登録が完了しました！<center></p>';
                $user_name = $_POST['user_name'];
                $password = $_POST['password'];
                register_data();
            } else {
                print '<center>IDとパスワードが他のユーザーと重複しているので変更して下さい。</center>';
            }
        } else {
            print '<p><center>ユーザー名かパスワードを入力して下さい。<center></p>';
        }
    }
}

function register_data() {
    global $user_name;
    global $password;

    try {
        $db = getDb();
        $stt = $db->prepare('insert into login(user_name, password) values(:user_name, :password)');

        $stt->bindvalue(':user_name', $user_name);
        $stt->bindvalue(':password', $password);

        $stt->execute();
        $db = NULL;
    } catch (Exception $e) {
        die("エラーメッセージ:{$e->getMessage()}");
    }
}
?>

<html>
    <head><title>登録完了ページ</title></head>
    <body>
    <center><br><a href="http://192.168.33.10/bbs_db/register.php">登録ページヘ戻る</a></center>
    <center><br><a href="http://192.168.33.10/bbs_db/DBver.php">トップに戻る</a></center>
</body>
</html>