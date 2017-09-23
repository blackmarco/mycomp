<?php

include_once './config.php';
include_once './lib/record/Connect.class.php';
include_once './lib/record/Transaction.class.php';
include_once './lib/record/Filter.class.php';
include_once './lib/record/Repository.class.php';
include_once './lib/record/Record.class.php';
include_once './UsuarioRecord.class.php';

use Mylib\lib\record\Filter;

$filtro = new Filter;
//$filtro->where("nome", "Mamba");
//$filtro->orWhere("nome", "Rafa");
//$filtro->orWhere("nome", "Berenice");
//$filtro->setProperty("ORDER BY", "nome", "ASC");

Transaction::open();

$repo = new Repository('UsuarioRecord');

//LOAD
//$users = $repo->load($filtro);
//foreach ($users as $user) {
//    echo "{$user->nome} - {$user->email} <br>";
//}

//COUNT
//$numUsers = $repo->count($filtro);
//echo $numUsers;

//DELETE
//$del = $repo->delete($filtro);
//if($del){
//    echo "Sucesso";
//}else{
//    echo "Falha";
//}

//FULLREAD
//$full =  $repo->fullLoad("SELECT * FROM usuario WHERE idade = :idade And nome = :nome", "idade=21&nome=Marco");
//echo $full[0]->nome;

Transaction::commit();