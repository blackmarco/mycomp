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
    private $params;
    
    //Adiciona uma clásura where ao filtro
    /* @param $column = nome da coluna */
    /* @param $value = valor */
    /* @param $operator = valor do operador*/
    public function where($column, $value, $operator = null) 
    {
        //Se o operador for null atribui o valor "="
        $operator = $operator ? $operator : "=";
        //Se a expressão estiver vazia adciona WHERE no inicio
        if(empty($this->expressions)){
            $this->expressions[] = " WHERE ({$column} {$operator} :{$column})";
        //Do contrário adiciona AND no início
        }else{
            $this->expressions[] = " AND ({$column} {$operator} :{$column})";
        }
        //Salva os parâmetros
        $this->params[$column] = $value;
    }
    
    //Adiciona um outro filtro com o comparador OR
    /* @param $column = nome da coluna */
    /* @param $value = valor */
    /* @param $operator = valor do operador*/
    public function orWhere($column, $value, $operator = null) 
    {
        //Se o operador for null atribui o valor "="
        $operator = $operator ? $operator : "=";
        //Se a expressão estiver vazia adciona WHERE no inicio
        if(empty($this->expressions)){
            $this->expressions[] = " WHERE ({$column} {$operator} :{$column})";
        //Do contrário adiciona AND no início
        }else{
            $this->expressions[] = " OR ({$column} {$operator} :{$column})";
        }
        //Salva os parâmetros
        $this->params[$column] = $value;
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
        foreach ($this->expressions as $filter){
            $expression .= $filter;
        }
        //Concatena as propriedades
        foreach ($this->properties as $property){
            $expression .= " " . $property;
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