<?php

/* 
 * Classe para a manipulação dos filtros de seleção de dados no banco de dados.
 */

class Filter
{
    /* @var $expressions = filtros da cláusura where da seleção */
    private $expressions;
    /* @var $preperties =  propriedades da seleção */
    private $properties;
    /* @var $params =  parametros da seleção */
    private $params = array();
    
    //Adiciona uma clásura where ao filtro
    /* @param $column = nome da coluna */
    /* @param $value = valor */
    /* @param $operator = valor do operador*/
    public function where($column, $value, $operator = null) 
    {
        //Se o operador for null atribui o valor "="
        $operator = $operator ? $operator : "=";
        //Se ja exixtir um parametro com o mesmo nome, adiciona um numero randomico ao bind
        $bind = $column;
        foreach ($this->params as $param) {
            if(in_array($bind, $param)){
                $bind = $bind.rand(1, 100);
            }
        }
        //Se a expressão estiver vazia adciona WHERE no inicio
        if(empty($this->expressions)){
            $this->expressions[] = " WHERE {$column} {$operator} :{$bind}";
        //Do contrário adiciona AND no início
        }else{
            $this->expressions[] = " AND {$column} {$operator} :{$bind}";
        }
        //Salva os parâmetros
        $this->params[] = [$bind, $value];
    }
    
    //Adiciona um outro filtro com o comparador OR
    /* @param $column = nome da coluna */
    /* @param $value = valor */
    /* @param $operator = valor do operador*/
    public function orWhere($column, $value, $operator = null) 
    {
        //Se o operador for null atribui o valor "="
        $operator = $operator ? $operator : "=";
        //Se ja exixtir um parametro com o mesmo nome, adiciona um numero randomico ao bind
        $bind = $column;
        foreach ($this->params as $param) {
            if(in_array($bind, $param)){
                $bind = $bind.rand(1, 100);
            }
        }
        //Se a expressão estiver vazia adciona WHERE no inicio
        if(empty($this->expressions)){
            $this->expressions[] = " WHERE {$column} {$operator} :{$bind}";
        //Do contrário adiciona AND no início
        }else{
            $this->expressions[] = " OR {$column} {$operator} :{$bind}";
        }
        //Salva os parâmetros
        $this->params[] = [$bind, $value];
    }
    
    //Adiciona uma propriedade para o filtro. Ex: ORDER BY, GROUP BY.
    /* @param $property = nome da propriedade */
    /* @param $value = coluna a ser aplicada */
    /* @param $extra = alguma informação extra */
    public function setProperty($property, $value, $extra = null) 
    {
        //Salva no array de propriedades
        $this->properties[] = " {$property} {$value} {$extra}";
    }
    
    //Monta a expressão de filtro
    public function mount() 
    {
        $expression = '';
        //Concatena s filtros
        if(count($this->expressions) > 1){
            foreach ($this->expressions as $filter){
                $expression .= $filter;
            }
        }else{
            $expression .= $this->expressions[0];
        }
        //Concatena as propriedades
        if(count($this->properties) > 1){
            foreach ($this->properties as $property){
                $expression .= " " . $property;
            }
        }else{
            $expression .= " " . $this->properties[0];
        }
        //Retorna a expressão
        return $expression;
    }
            
    //Retorna os parâmetros
    public function getParams() 
    {
        return $this->params;
    }
}