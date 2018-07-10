<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$active_group = 'server';
$query_builder = TRUE;

$db['server'] = array(
	'dsn'	=> 'mysql:host=localhost; dbname=trade_association; charset=utf8;',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'trade_association',
	'dbdriver' => 'pdo',
	'dbprefix' => 'smcta_',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => 'application/cache/smcta_dev',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_unicode_ci',
	'swap_pre' => '{pre}',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
