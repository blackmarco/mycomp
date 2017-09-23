<?php

require_once './config.php';
require_once './vendor/autoload.php';

//Inicia transação
Mylib\Record\Transaction::open();

//Obtém a conexão
$conn = Mylib\Record\Transaction::getConn();

//$conn->exec("INSERT INTO .....");

//Aplica as alterações
Mylib\Record\Transaction::commit();
