<?php

$aliapy_config['partner']      = C('pay_partner');
$aliapy_config['key']          = C('pay_key');
$aliapy_config['seller_email'] = C('pay_user');
$aliapy_config['return_url']   = 'index.php/company/return_url';
$aliapy_config['notify_url']   = 'index.php/company/notify_url';
$aliapy_config['sign_type']    = 'MD5';
$aliapy_config['input_charset']= 'utf-8';
$aliapy_config['transport']    = 'https';

?>