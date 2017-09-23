<?php

/* 
 * Classe para a manipulação do componente Monolog
 * Implementação do Design Pattern Facade
 */

namespace Mylib\Facades;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Log
{
    
    //Armazena o Logger
    /* @var $nomeLoag = Logger */
    private $log;
    
    //Recebe o nome do log e instância um objeto Logger
    /* @param $$nomeLog = Nome do log */
    public function __construct($nameLog) 
    {
        $this->log = new Logger($nameLog);
    }
    
    //Log de transações com o Banco de dados
    /* @param $pathLog = caminho/nome.log */
    public function logDB($pathlog)
    {
        $this->log->pushHandler(new StreamHandler($pathlog, Logger::DEBUG));
        $this->log->pushHandler(new FirePHPHandler());
    }
    
    //Log de warnings de execução
    /* @param $pathLog = caminho/nome.log */
    public function logWarning($pathlog)
    {
        $this->log->pushHandler(new StreamHandler($pathlog, Logger::WARNING));
        $this->log->pushHandler(new FirePHPHandler());
    }
    
    //Log de erros de execução
    /* @param $pathLog = caminho/nome.log */
    public function logError($pathlog)
    {
        $this->log->pushHandler(new StreamHandler($pathlog, Logger::ERROR));
        $this->log->pushHandler(new FirePHPHandler());
    }
    
    //Adicionar informação ao log
    /* @param $message mensagem para ser adicionada */
    public function addInfo($message, $params = null) {
        //Verifica se tem parâmetros extras
        if($params){
            $log = $this->log->info($message, $params);
        }else{
            $log = $this->log->info($message);
        }
        
        //Retorna true ou false
        if($log){
            return true;
        }else{
            return false;
        }
        
    }

    //Adicionar warning ao log
    /* @param $message mensagem para ser adicionada */
    public function addWarn($message, $params = null) {
        //Verifica se tem parâmetros extras
        if($params){
            $log = $this->log->warn($message, $params);
        }else{
            $log = $this->log->warn($message);
        }
        
        //Retorna true ou false
        if($log){
            return true;
        }else{
            return false;
        }
        
    }
    
    //Adicionar error ao log
    /* @param $message mensagem para ser adicionada */
    public function addError($message, $params = null) {
        //Verifica se tem parâmetros extras
        if($params){
            $log = $this->log->err($message, $params);
        }else{
            $log = $this->log->err($message);
        }
        
        //Retorna true ou false
        if($log){
            return true;
        }else{
            return false;
        }
        
    }
    
}

