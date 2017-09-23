<?php

require_once './vendor/autoload.php';

$log = new \Mylib\Facades\Log('logteste');
$log->logWarning('teste.log');
$log->addWarn("Olá mundo, este é um log de 22/09/2017");
//$log->logError('teste.log');
//$log->addError("Olá mundo, este é um log de 22/09/2017");

if($log){
    echo "Log registrado com sucesso";
}
