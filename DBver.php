<?php session_start(); ?>
<html>
    <head><title>テクアカ用練習掲示板</title></head>
    <body>
        <a href="http://192.168.33.10/bbs_db/register.php">新規登録</a>
        <a href="http://192.168.33.10/bbs_db/login.php">ログイン</a>
        <a href="http://192.168.33.10/bbs_db/logout.php">ログアウト</a>
        <font size="5"><p><b>テクアカ用練習掲示板</b></p></font>
        <br>
        <form method="POST" action="DBver.php">
            ユーザー名(必須)<br>
            <input type="text" name="user"><br><br><br>
            本文（必須）<br>
            <textarea name="message" rows="8" cols="40"></textarea><br><br>
            <input type="submit" name="btn1" value="投稿">
        </form>
    </body>

    <?php
    ini_set( 'display_errors', 0 );
    require_once 'DbManager.php';

    //ログイン状態の判別
    if (isset($_SESSION["user_name"])) {
        $status = 'login';
    } else {
        $status = 'logout';
    }

    //投稿
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (empty($_POST['user']) or empty($_POST['message'])) {
            print '文字を入力してください';
        } else {
            if (isset($_POST['user']) and isset($_POST['message'])) {
                $user = $_POST['user'];
                $message = $_POST['message'];
                writeData();
            } else {
                print '文字を入力してください';
            }
        }
    }
    readData();

    
    function readData() {


        try {
            $db = getDb();
            $stt = $db->prepare('select * from bbs_data order by no desc');
            $stt->execute();
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                print "<p>\n";
                //削除ボタンを表示するかどうか判断
                if ($row['post_id'] == NULL) {
                    $delete_button = NULL;
                } else {
                    if ($row['post_id'] == $_SESSION["user_name"]) {
                        $delete_button = '<a href="http://192.168.33.10/bbs_db/delete.php">【削除】</a>';
                    } else {
                        $delete_button = NULL;
                    }
                }
                print '<strong>[No.' . $row['no'] . ']' . '名前:' . htmlspecialchars($row['user'], ENT_QUOTES) . $delete_button . "</strong><br>\n";
                print "<br>\n";
                print nl2br(htmlspecialchars($row['message'], ENT_QUOTES));
                print "</p>\n";
            }
            $db = NULL;
        } catch (Exception $e) {
            die("エラーメッセージ：{$e->getMessage()}");
        }
    }

    function writeData() {
        global $user;
        global $message;
        global $status;

        if ($status == 'login') {
            $post_id = $_SESSION["user_name"];
        } else {
            $post_id = NULL;
        }

        try {
            $db = getDb();

            $stt = $db->prepare('INSERT INTO bbs_data(user,message,post_id) VALUES (:user, :message, :post_id)');

            $stt->bindValue(':user', $user);
            $stt->bindValue(':message', $message);
            $stt->bindValue(':post_id', $post_id);
            $stt->execute();
            $db = NULL;
        } catch (Exception $e) {
            die("エラーメッセージ:{$e->getMessage()}");
        }
    }
    