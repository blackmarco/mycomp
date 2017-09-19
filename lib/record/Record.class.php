<?php

/* 
 * Classe record, responsável por todas as operaçoes com o banco de dados.
 * Implementação do Design Pattern Active Record.
 */

class Record
{
    //Array de atributos e valores do objeto filho da classe
    private $data;
    //Armazena o comando DML que a ser executado
    private $sql;
    
    
    public function __construct($id = null) 
    {
        
    }
    
    //Método executado sempre que uma propriedade for atribuida
    public function __set($property, $value) 
    {
        //Verifica se se existe o método passado como propriedade
        if(method_exists($this, $property)){
            //Se existeir executa
            call_user_func(array($this, $property), $value);
        }else{
            if($value == null){
                unset($this->data[$property]);
            }else{
                //atribui o valor a propriedade
                $this->data[$property] = $value;
            }
        }
    }
    
    //Armazena novo registro na base de dados
    public function save() 
    {
        //Verifica se data é um array e se não esta vázio
        if(is_array($this->data) && count($this->data) > 0){
            //Monta a query de inserção;
            $this->sql = "INSERT INTO {$this->getTable()} ";
            $this->sql .= "( ".implode(', ', array_keys($this->data)).")";
            $this->sql .= " VALUES ( :".implode(', :', array_keys($this->data)).")";

            //Verifica se a conexão com o banco está ativa
            if($conn = Transaction::getConn()){
                //Usa funçao prepare do PDO para preparar a query e manter segurança
                $stmt = $conn->prepare($this->sql);
                //Executa os Binds da query
                foreach ($this->data as $key => $value){
                    $stmt->bindValue(":{$key}", $value);
                }
                //Executa a operação própiamente dita
                $result = $stmt->execute();
                //Limpa a query sql
                $this->sql = null;
                //Retorna o resultado
                return $result;

            //Se não houver conexão tiva, lança uma exceção    
            }else{
                throw new Exception('Não há transação ativa!');
            }
        }else{
            throw new Exception('O objeto é vazio ou não é do tipo array. Favor inserir suas propriedades');
        }
    }
    
    
    //Obtém o nome da tabela do objeto no banco de dados
    private function getTable() 
    {
        //Obtém o nome da classe que esta realizando operaçãoes no banco
        $class = get_class($this);
        //Retorna o valor da contante
        return $class::TABLENAME;        
    }
    
}