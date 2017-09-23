<?php

/* 
 * Class responsável pela manipulação de coleções de dados
 * Implementação do Design Pattern Repository
 */

namespace Mylib\Record;

use Exception;
use Mylib\Record\Transaction;
use Mylib\Record\Filter;
use Mylib\Facades\Log;
use PDO;

class Repository
{
    /* @var $classname = nome da classe */
    private $classname;
    /* @var $sql =  comando DML a ser executado */
    private $sql;
    /* @var $log =  salva o comando DML executado em um arquivo de log*/
    private $log;
    
    //Método construtor
    /* @param $classnamen = nome da classe */
    public function __construct($classname) 
    {
        //Atribui o nome da classe ao atributo classname
        $this->classname = $classname;
        //Instancia o objeto log
        $this->log = new Log('logTransacoes');
        //Define o caminho do log
        $this->log->logDB(__DIR__.'/Logs/logDataBase.log');
    }
    
    //Carrega uma coleção de dados
    /* @param $filter Filter */
    public function load(Filter $filter) 
    {
        //Instancia um objeto filho de Record
        $ar = new $this->classname;
        //Começa a montar a query
        $this->sql = "SELECT * FROM {$ar->getTable()} ";
        $this->sql .= $filter->mount();
        //Verifica se existe uma transação ativa
        if($conn = Transaction::getConn()){
            //Prepara a query
            $stmt = $conn->prepare($this->sql);
            //Faz os binds
            if(count($filter->getParams()) >= 1){
                foreach ($filter->getParams() as $param) {
                    $stmt->bindValue(":".$param[0], $param[1]);
                }
            }
            //Executa
            $result = $stmt->execute();
            $obj = array();
            //Verifica se teve resultado
            if($result){
                //Salva os resultados em um array de objetos
                while($row = $stmt->fetchObject($this->classname)){
                    $obj[] = $row;
                }
            }
            //Salva a query sql no log
            $this->log->addInfo($this->sql);
            $this->sql = null;
            //Retorna os objetos
            return $obj;
        //Se não houver conexão ativa, lança uma exceção 
        }else{
            throw new Exception('Não há conexão ativa!');
        }   
    }
    
    //Conta o numero de resultados de uma query
    /* @param $filtro Filter */
    public function count(Filter $filter) 
    {
        //Instancia um objeto filho de Record
        $ar = new $this->classname;
        //Começa a montar a query
        $this->sql = "SELECT COUNT(*)FROM {$ar->getTable()} ";
        $this->sql .= $filter->mount();
        //Verifica se existe uma transação ativa
        if($conn = Transaction::getConn()){  
            //Prepara a query
            $stmt = $conn->prepare($this->sql);
            //Faz os binds
            if(count($filter->getParams()) >= 1){
                foreach ($filter->getParams() as $param) {
                    $stmt->bindValue(":".$param[0], $param[1]);
                }
            }
            //Executa
            $stmt->execute();
            //Salva a query sql no log
            $this->log->addInfo($this->sql);
            $this->sql = null;
            //Obtém o numero de linhas
            $numRows = $stmt->fetch(PDO::FETCH_NUM)[0];
            //Retorna
            return $numRows;
        //Se não houver conexão ativa, lança uma exceção 
        }else{
            throw new Exception('Não há conexão ativa!');
        }  
    }
    
    //Deleta vários registros, baseado nos filtros
    /* @param $filter Filter */
    public function delete(Filter $filter) 
    {
        //Instancia um objeto filho de Record
        $ar = new $this->classname;
        //Começa a montar a query
        $this->sql = "DELETE FROM {$ar->getTable()} ";
        $this->sql .= $filter->mount();
        
        //Verifica se existe uma transação ativa
        if($conn = Transaction::getConn()){  
            //Prepara a query
            $stmt = $conn->prepare($this->sql);
            //Faz os binds
            if(count($filter->getParams()) >= 1){
                foreach ($filter->getParams() as $param) {
                    $stmt->bindValue(":".$param[0], $param[1]);
                }
            }
            //Executa
            $result = $stmt->execute();
            //Salva a query sql no log
            $this->log->addInfo($this->sql);
            $this->sql = null;
            //Retorna true ou false
            if($result){
                return true;
            }else{
                return false;
            }
        //Se não houver conexão ativa, lança uma exceção 
        }else{
            throw new Exception('Não há conexão ativa!');
        }   
    }
    
    //Executa uma query manual
    public function fullLoad($query, $binds = null) {
        //Salva a query
        $this->sql = $query;
        //faz um parse da string de termos e salva em um array
        $terms = array();
        parse_str($binds, $terms);
        //Verifica se existe uma conexão ativa
        if($conn = Transaction::getConn()){
            //Prepara a query
            $stmt = $conn->prepare($this->sql);
            //Faz os binds
            foreach ($terms as $bind => $value) {
                $stmt->bindValue(":{$bind}", $value);
            }
            //Executa
            $result = $stmt->execute();
            $obj = array();
            //Verifica se teve resultado
            if($result){
                //Salva os resultados em um array de objetos
                while($row = $stmt->fetchObject($this->classname)){
                    $obj[] = $row;
                }
            }
            //Salva a query sql no log
            $this->log->addInfo($this->sql);
            $this->sql = null;
            //Retorna os objetos
            return $obj;
        //Se não houver conexão ativa, lança uma exceção 
        }else{
            throw new Exception('Não há conexão ativa!');
        }   

    }
}

