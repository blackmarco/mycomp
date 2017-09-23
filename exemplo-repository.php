<?php
require_once './config.php';
require_once './vendor/autoload.php';
require_once './UsuarioRecord.php';

$filtro = new \Mylib\record\Filter;
//$filtro->orWhere("nome", "Rafa");
//$filtro->orWhere("nome", "Bere");
//$filtro->setProperty("ORDER BY", "nome", "ASC");

Mylib\record\Transaction::open();

$repo = new Mylib\record\Repository('UsuarioRecord');

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

Mylib\record\Transaction::commit();