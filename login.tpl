<html>
    <body>
    <center><form method ="post" action="login.php">
            ユーザーID<br>
            <input type="text" name="user_id" required><br><br>
            パスワード<br>
            <input type="password" name="password" required><br><br>
            <input type="submit" value="ログイン">
        </form>
        {if isset($display_message)}
        {$display_message}
        {/if}
        <br><a href="{$ipadress}/bbs_smarty/login.php">ログイン画面に戻る</a>
    </center>
</body>
</html>