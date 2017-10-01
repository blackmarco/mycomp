<?php

/* 
 * Arquivo de configurações gerais do sistemas
 * 
 * DEFINA SUAS CONFIGURAÇÕES E RENOMEIE O ARQUIVO PARA "config.php"
 */

/* Definições de acesso ao banco de dados */
define('DBTYPE', 'mysql'); // Tipo do banco de dados. Ex: mysql pgsql
define('DBPORT', 3306); // Porta do Banco de dados
define('DBHOST', 'localhost'); // Caminho do banco de dados
define('DBNAME', ''); // Nome do banco de dados
define('DBUSER', 'root'); // Usuário do banco de dados
define('DBPASS', ''); // Senha do banco de dados

/* Tratamento de erros */
function myErrorHandler($code, $message, $file, $line) 
{
    switch ($code){
        //Se for Fatal error
        case E_USER_ERROR:
            //Exibe na tela
            $error = "<b>ERROR: {$message}</b><br>";
            $error .= "Fatal error na linha '{$line}' no arquivo '{$file}'";
            echo $error;
            //Salva em um log
            $log = new Mylib\Facades\Log('errors');
            $log->logError('Logs/errors.log');
            $log->addError($error);
            //Para a execução da aplicação
            exit(1);
            break;
        //Se for Notice
        case E_USER_NOTICE:
            //Salva em um log
            $error = "NOTICE: {$message}";
            $log = new Mylib\Facades\Log('notices');
            $log->logWarning('Logs/notices.log');
            $log->addWarn($error);
            break;
        //Se for Warning
        case E_USER_WARNING:
            //Salva em um log
            $error = "WARNING: {$message}";
            $log = new Mylib\Facades\Log('warnings');
            $log->logWarning('Logs/warnings.log');
            $log->addWarn($error);
            break;     
    }
}
//Define a função myErrorHandler como padrão para tratamento de erros
set_error_handler("myErrorHandler");