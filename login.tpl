<html>
    <body>
    <center><form method ="post" action="login.php">
            ユーザーID<br>
            <input type="text" name="user_id" required><br><br>
            パスワード<br>
            <input type="password" name="password" required><br><br>
            <input type="submit" value="ログイン">
        </form>
        {if $display_message !== NULL}
        {$display_message}
        {/if}
    </center>
</body>
</html>