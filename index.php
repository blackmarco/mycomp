<?php

require_once './config.php';
require_once './lib/record/Connect.class.php';

$conn = Connect::open();
if($conn){
    echo "Conexão realizada com sucesso!";
}