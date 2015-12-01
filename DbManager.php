<?php
function getDb() {
    $dsn = 'mysql:dbname=bbs; host=127.0.0.1';
    $usr = 'ryuya';
    $passwd = '1234';
    
    try {
        $db = new PDO($dsn, $usr, $passwd);
        $db->exec('SET NAME utf8');
    }   catch (Exception $e) {
        die("接続エラー：{$e->getMessage()}");
    }
    return $db;
}