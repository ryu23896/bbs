<?php
function smarty(){
$smarty->template_dir = '/var/www/html/bbs_smarty/templates';
$smarty->compile_dir = '/var/www/html/bbs_smarty/templates_c/';
$smarty->config_dir = '/var/www/html/bbs_smarty/configs/';
$smarty->cache_dir = '/var/www/html/bbs_smarty/cache/';
}

define('IPADRESS', 'http://192.168.33.10');