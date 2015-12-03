<html>
    <body>
    <center><form method ="post" action="login.php">
            ユーザーID<br>
            <input type="text" name="user_id" required><br><br>
            パスワード<br>
            <input type="password" name="password" required><br><br>
            <input type="submit" value="ログイン">
        </form></center>
</body>

<?php
session_start();
require_once 'DbManager.php';

//フォームに文字が入力されているか・ログイン処理
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['user_id']) or empty($_POST['password'])) {
        print "ログイン名・パスワードが入力されていません";
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
                print '<center>IDもしくはパスワードが違います<br><br><a href="http://192.168.33.10/bbs_db/login.php">ログイン画面に戻る</a></center>';
            } else {
                $_SESSION["user_id"] = $_POST['user_id'];
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
}
?>   
</html>