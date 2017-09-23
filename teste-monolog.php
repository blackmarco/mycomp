<?php

require_once './vendor/autoload.php';

$log = new Monolog\Logger('Meu log');
$log->pushHandler(new Monolog\Handler\StreamHandler(__DIR__."/logs", Monolog\Logger::DEBUG));
$log->pushHandler(new \Monolog\Handler\FirePHPHandler());

$log->info("Teste com monolog!");