<html>
    <head><title>登録完了ページ</title></head>
    <body>
<?php
require_once 'DbManager.php';

//フォームに文字が入力されているかどうか・他ユーザーと重複していないかチェック
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['user_id']) or empty($_POST['password'])) {
        print '<p><center>ユーザーIDとパスワードを入力して下さい。<center></p>';
    } else {
        if (isset($_POST['user_id']) and isset($_POST['password'])) {
            $db = getDb();
            $stt = $db->prepare("select * from login where user_id = :user_id and password = :password");
            $stt->bindValue(':user_id', $_POST["user_id"]);
            $stt->bindValue(':password', $_POST["password"]);
            $stt->execute();
            $result = $stt->fetch();
            if ($result == false) {
                print '<p><center>登録が完了しました！<center></p>';
                $user_id = $_POST['user_id'];
                $password = $_POST['password'];
                register_data($user_id, $password);
            } else {
                print '<center>ユーザーIDが他のユーザーと重複しているので変更して下さい。</center>';
            }
        } else {
            print '<p><center>ユーザーIDとパスワードを入力して下さい。<center></p>';
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
?>
    <center><br><a href="http://192.168.33.10/bbs_db/register.php">登録ページヘ戻る</a></center>
    <center><br><a href="http://192.168.33.10/bbs_db/DBver.php">トップに戻る</a></center>
</body>
</html>