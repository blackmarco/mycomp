<?php

/* 
 * Classe record, responsável por todas as operaçoes com o banco de dados.
 * Implementação do Design Pattern Active Record.
 */

class Record
{ 
    /* @var $data = atributos do objeto */
    protected $data;
    /* @var $sql =  comando DML a ser executado */
    private $sql;
    /* @var $id =  id do registro em que sera executada a operação */
    private $id;
    /* @var $nomeId =  nome do campo, caso nao seja id */
    private $nomeId;
    
    //Método construtor, se passado um id ele ja carrega o objeto com suas propriedades
    /* @param $id = valor do id */
    /* @param $nomeCampo = nome do campo no banco, caso nao seja "id" */
    public function __construct($id = null, $nomeCampo = null) 
    {
        //Verifica se foi passado um id como parâmetro
        if($id){
            //Verifica se foi passado o nome do campo id como parâmetro e executa o método loadById
            if(empty($nomeCampo)){
                $object = $this->loadById($id);
            }else{
                $object = $this->loadById($id, $nomeCampo);
            }
            //Atríbui as propriedades do resultado ao objeto instanciado
            if($object){
                $this->data = $object->data;
            }   
        }
    }
    
    //Método executado sempre que uma propriedade for atribuida
    public function __set($property, $value) 
    {
        if($value == null){
            unset($this->data[$property]);
        }else{
            //atribui o valor a propriedade
            $this->data[$property] = $value;
        }
    }
    
    //Método mágico executado sempre que uma propriedade por requerida
    public function __get($property) 
    {
        if(isset($this->data[$property])){
            //Retorna o valor dessa propriedade
            return $this->data[$property];
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
                //Prepara a query
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

            //Se não houver conexão ativa, lança uma exceção    
            }else{
                throw new Exception('Não há conexão ativa!');
            }
        }else{
            //Se objeto estiver vazio retorna uma exceção
            throw new Exception('O objeto é vazio ou não é do tipo array. Favor inserir suas propriedades');
        }
    }
    
    //Busca um registro na base de dados pelo seu id
    /* @param $id = valor do id */
    /* @param $nomeCampo = nome do campo no banco, caso nao seja "id" */
    public function loadById($id, $nomeCampo = null) 
    {
        //Armazena o id selecionado
        $this->id = $id;
        //Monta a query de seleção corretamente
        $this->sql = "SELECT * FROM {$this->getTable()}";
        if($nomeCampo){
            $this->sql .= " WHERE {$nomeCampo} = {$id}"; 
            //Armazena o nome do campo id
            $this->nomeId = $nomeCampo;
        }else{
            $this->sql .= " WHERE id = {$id}";
        }
        
        //Verifica se a conexão com o banco está ativa
        if($conn = Transaction::getConn()){
            //Prepara a query
            $stmt = $conn->prepare($this->sql);
            //Executa
            $result = $stmt->execute();
            //Se obtiver resultado, retornta em forma de objeto
            if($result){
                $obj = $stmt->fetchObject(get_class($this));
            }
            $this->sql = null;
            return $obj;
        //Se não houver conexão ativa, lança uma exceção 
        }else{
            $this->id = null;
            $this->nomeId = null;
            throw new Exception('Não há conexão ativa!');
        }
    }
    
    //Método estático atalho para loadById
    /* @param $id = valor do id */
    /* @param $nomeCampo = nome do campo no banco, caso nao seja "id" */
    public static function find($id, $nomeCampo = null)
    {
        //Obtém o nome da classe filha que está chamando o método
        $classname = get_called_class();
        //Instancia um objeto dessa classe
        $record = new $classname;
        //Verifica se o nome do campo foi informado e retorna o método loadById correto
        if(empty($nomeCampo)){
            return $record->loadById($id);
        }else{
            return $record->loadById($id, $nomeCampo);
        }
    }
    
    //Deleta um registo na base de dados
    /* @param $id = valor do id */
    /* @param $nomeCampo = nome do campo no banco, caso nao seja "id" */
    public function delete($id = null, $nomeCampo = null) 
    {   
        //Verifica se foi passado id como parâmetro
        if($id){
            //Atribui ao atributo id
            $this->id = $id;
            //Verifica se foi passado o nome do id
            if($nomeCampo){
                //Atribui ao atributo id
                $this->nomeId = $nomeCampo;
            }
        }
        
        //Se existir um id começa a montar a query
        if($this->id){
            $this->sql = "DELETE FROM {$this->getTable()}";
            //Verifica se o nome do campo é diferente de id e concatena a query com o comando correto
            if($this->nomeId){
                $this->sql .= " WHERE {$this->nomeId} = {$this->id}";
            }else{
                $this->sql .= " WHERE id = {$this->id}";
            }
            //Limpa os dois atributos da memória
            $this->id = null;
            $this->nomeId = null;
        }else{
            //Lança uma exceção caso nao exista um id
            throw new Exception('Informe um id para ser excluído!');
        }
        
        //Verifica se a conexão está ativa
        if($conn = Transaction::getConn()){
            //Prepara a query
            $stmt = $conn->prepare($this->sql);
            //Executa
            $result = $stmt->execute();
            //Limpa o atributo
            $this->sql = null;
            //Retorna se falhou ou obteve sucesso
            if($result){
                return true;
            }else{
                return false;
            }
        }else{
            //Se não houver conexão ativa, lança uma exceção
            throw new Exception('Não há conexão ativa!');
        }    
    }
    
    //Altera um registo na base de dados
    /* @param $id = valor do id */
    /* @param $nomeCampo = nome do campo no banco, caso nao seja "id" */
    public function update($id = null, $nomeCampo = null) 
    {
        //Verifica se foi passado id como parâmetro
        if($id){
            //Atribui ao atributo id
            $this->id = $id;
            //Verifica se foi passado o nome do id
            if($nomeCampo){
                //Atribui ao atributo id
                $this->nomeId = $nomeCampo;
            }
        }
        
        //Se existir um id começa a montar a query
        if($this->id){
            $this->sql = "UPDATE {$this->getTable()} SET ";
            foreach ($this->data as $key => $value){
                $set[] = "{$key} = :{$key}";
            }
            $this->sql .= implode(', ', $set);
            
            //Verifica se o nome do campo é diferente de id e concatena a query com o comando correto
            if($this->nomeId){
                $this->sql .= " WHERE {$this->nomeId} = {$this->id}";
            }else{
                $this->sql .= " WHERE id = {$this->id}";
            }
            //Limpa os dois atributos da memória
            $this->id = null;
            $this->nomeId = null;
            
            //Verifica a conexão está ativa
            if($conn = Transaction::getConn()){
                //Prepara a query
                $stmt = $conn->prepare($this->sql);
                //executa os binds
                foreach ($this->data as $key => $value){
                    $stmt->bindValue(":{$key}", $value);
                }
                //Executa a query
                $result = $stmt->execute();
                //Libera a variavel sql da memória
                $this->sql = null;
                //Retorna true ou false
                return $result;
             //Se não houver conexão ativa, lança uma exceção    
            }else{
                throw new Exception('Não há conexão ativa!');
            }
        }else{
            //Lança uma exceção caso nao exista um id
            throw new Exception('Informe um id para ser excluído!');
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