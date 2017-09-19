<?php

require_once './config.php';
require_once './lib/record/Transaction.class.php';
include_once './lib/record/Connect.class.php';

//Inicia transação
Transaction::open();

//Obtém a conexão
$conn = Transaction::getConn();

//$conn->exec("INSERT INTO .....");

//Aplica as alterações
Transaction::commit();
