<?php

require_once './config.php';
require_once './vendor/autoload.php';

Mylib\FastStorage::write('Logs/acessos.txt', 6);

$conteudo = Mylib\FastStorage::read('Logs/acessos.txt');

echo $conteudo;