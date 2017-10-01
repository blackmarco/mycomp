<?php

require_once './config.php';
require_once './vendor/autoload.php';
require_once './UsuarioRecord.php';

Mylib\Record\Transaction::open();

//GRAVADO NO BANCO DE DADOS
//$record = new UsuarioRecord();
//$record->nome = "Teste log";
//$record->email = "log@gmail.com";
//$record->idade = 21;
//if($record->save()){
//    echo 'Inserido com sucesso';
//}

//BUSCA POR ID
//$user = UsuarioRecord::find(1);
//echo $user->nome;

//BUSCA POR ID AO INTANCIAR UM OBJETO
//$usuario = new UsuarioRecord(1);;
//echo $usuario->nome;

//DELETAR 
//$delete = new UsuarioRecord(5);
//$delete->delete();
//OU
//$delete2 = new UsuarioRecord();
//$delete2->delete(10);     

//ALTERAR
//$update = new UsuarioRecord();
//$update->nome = "Mamba";
//$update->update(9);
//OU 
//$update = new UsuarioRecord(1);
//$update->nome = "Mamba";
//$update->update();

//ALL
//$all = UsuarioRecord::all();
//foreach ($all as $one) {
//    echo "{$one->nome} - {$one->email} <br>";
//}

Mylib\Record\Transaction::commit();