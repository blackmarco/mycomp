<?php

/* 
 * Classe de transações com a base de dados, responsável por iniciar a conexão,
 * e dar commit nas operações com a na base de dados.
 */

namespace Mylib\record;

use Mylib\record\Connect;

final class Transaction
{
    //Conexão ativa com a base de dados
    private static $conn;
    
    private function __construct() {}
    
    //Abre uma conexão com o banco de dados
    public static function open()
    {
        self::$conn = Connect::open();
        //Inicia uma transação
        self::$conn->beginTransaction();
    }
    
    //Retorna a conexão ativa com a base de dados
    public static function getConn() 
    {
        return self::$conn;
    }
    
    //Aplica as alteraçãoes de fecha a conexão
    public static function commit()
    {
        self::$conn->commit();
        self::$conn = null;
    }
    
    //Reverte todas a alterações e fecha a conexão
    public static function rollback()
    {
        self::$conn->rollback();
        self::$conn = null;
    }
}