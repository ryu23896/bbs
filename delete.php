<?php session_start(); ?>
<html>
    <body>
    <center><form method="post" action="delete.php">
            投稿No<br><br>
            <input type="text" name="delete_no"><br><br>
            <input type="submit" value="削除">           
        </form><br>
    <a href="http://192.168.33.10/bbs_db/DBver.php">トップページへ戻る</a></center>
</body>    
</html>


<?php
require_once 'DbManager.php';

//フォームから渡された数値をチェック
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST['delete_no'])) {
        print '投稿Noを入力して下さい。';
    } else {
        if (isset($_POST['delete_no'])) {
            if (is_numeric($_POST['delete_no'])) {
                delete(); 
                print '<center>削除しました</center>';
            } else {
                print '数字を入力して下さい。';
            }
        } else {
            print '投稿Noを入力して下さい。';
        }
    }
}

//投稿の削除
function delete(){
$delete_no = $_POST['delete_no'];
$db = getDb();
$stt = $db->prepare("delete from bbs_data where no = :delete_no and post_id = :user_name");
$stt->bindValue(':delete_no', $delete_no);
$stt->bindValue(':user_name', $_SESSION['user_name']);
$stt->execute();
}
