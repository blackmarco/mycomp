<?php

include_once './lib/record/Filter.class.php';

$filtro = new Filter;
$filtro->where("nome", "Marco");
$filtro->orWhere("idade", 24, "<>");
$filtro->setProperty("GROUP BY", "nome");
$filtro->setProperty("ORDER BY", "idade", "ASC");
echo $filtro->mount()."<br>";
var_dump($filtro->getParams());
