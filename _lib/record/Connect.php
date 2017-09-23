<?php

/* 
 * Classe de conexão com o banco de dados;
 * Utilizando a classe PDO, de abstração do banco de dados, virar gerar uma api de conexão,
 * capaz de interagir com diversos SGBDs.
 */

namespace Mylib\record;

use PDO;

final class Connect
{
    //Define como private para evitar que seja instanciado um objeto de conexão
    private function __construct() {}
    
    //Método definido como estático para que seja retornada sempre a mesma conexão em todo o sistema
    public static function open() 
    {
        $type = DBTYPE;
        $host = DBHOST;
        $port = DBPORT;
        $dbname = DBNAME;
        $user = DBUSER;
        $pass = DBPASS;
        
        //Verifica o tipo do banco de dados e cria a DSN monta a DSN correta
        //Poderão ser adicionados mais tipos
        switch ($type){            
            case 'mysql':
                $conn = new PDO("mysql:host={$host};port={$port};dbname={$dbname}", 
                        $user, $pass);
                break;
            case 'pqsql':
                $conn = new PDO("pgsql:dbname={$dbname};{host=$host}", $user, $pass);
                break;
        }
        //Define que o pdo lance exceções quando ocorrerem erros
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    
    
}

