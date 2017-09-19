<?php

require_once './config.php';
require_once './lib/record/Connect.class.php';
require_once './lib/record/Transaction.class.php';
require_once './lib/record/Record.class.php';
require_once './UsuarioRecord.class.php';

Transaction::open();

$record = new UsuarioRecord();
$record->nome = "Berenice";
$record->email = "bere.com";
$record->idade = 41;

//Grava no banco
if($record->save()){
    echo 'Inserido com sucesso';
}

Transaction::commit();