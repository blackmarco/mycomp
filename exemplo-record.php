<?php

require_once './config.php';
require_once './lib/record/Connect.class.php';
require_once './lib/record/Transaction.class.php';
require_once './lib/record/Record.class.php';
require_once './UsuarioRecord.class.php';

Transaction::open();

//GRAVADO NO BANCO DE DADOS
//$record = new UsuarioRecord();
//$record->nome = "Berenice";
//$record->email = "bere.com";
//$record->idade = 41;
//if($record->save()){
//    echo 'Inserido com sucesso';
//}

//BUSCA POR ID
//$user = UsuarioRecord::find(1);
//echo $user->nome;

//BUSCA POR ID AO INTANCIAR UM OBJETO
//$usuario = new UsuarioRecord(1);
//echo $usuario->nome;

//DELETAR 
//$delete = new UsuarioRecord(5);
//$delete->delete();
//OU
//$delete2 = new UsuarioRecord();
//$delete2->delete(5);     

//ALTERAR


Transaction::commit();