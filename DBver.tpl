<html>
    <head><title>テクアカ用練習掲示板</title></head>
    <body>
        <a href="{$ipadress}/bbs_smarty/register.php">新規登録</a>
        <a href="{$ipadress}/bbs_smarty/login.php">ログイン</a>
        <a href="{$ipadress}/bbs_smarty/logout.php">ログアウト</a>
        <a href="{$ipadress}/bbs_smarty/delete.php">投稿削除</a>
        <font size="5"><p><b>テクアカ用練習掲示板</b></p></font>
        <br>
        <form method="POST" action="DBver.php">
            名前(必須)<br>
            <input type="text" name="user" required><br><br><br>
            本文（必須）<br>
            <textarea name="message" rows="8" cols="40" required></textarea><br><br>
            <input type="submit" name="btn1" value="投稿">
        </form>
        {if isset($display_message)}
        {$display_message}
        {/if}
        
        {foreach from=$post_data item=data}
            <strong><p>[No.{$data.no}名前:{$data.user}</strong><br><br>
            {$data.message}</p>
        {/foreach}    
        
    </body>   
</html>