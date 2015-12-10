<html>
    <body>
    <center><form method="post" action="delete.php">
            投稿No<br><br>
            <input type="text" name="delete_no" required><br><br>
            <input type="submit" value="削除">           
        </form><br>
        {if isset($display_message)}
            {$display_message}
        {/if}<br><br>
        <a href="{$ipadress}/bbs_smarty/DBver.php">トップページへ戻る</a>
    </center>
</body>    
</html>