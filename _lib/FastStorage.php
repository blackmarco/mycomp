<?php

/* 
 * Classe para armazenamento e leitura rápida em arquivos txt.
 */

namespace Mylib;

class FastStorage
{
    //Classe stática para leitura de arquivos txt
    /* @param $file = Nome do arquivo */
    public static function read($file) 
    {
        //Verifica se o arquivo existe
        if(file_exists($file)){
            //Abre o arquivo em modo leitura
            $pointer = fopen($file, 'r');
            //Pega o conteúdo
            $content = fgets($pointer);
            //Fecha o arquivo
            fclose($pointer);
            //Retorna o conteúdo
            return $content;
        }else{
            return "Arquivo não encontrado!";
        }   
    }
    
    //Classe stática para escrita em arquivos txt
    /* @param $file = Nome do arquivo */
    /* @param $string = Conteúdo a ser escrito no arquivo */
    public static function write($file, $string) 
    {
        //Abre o arquivo em modo leitura, se não existir cria
        $pointer = fopen($file, 'w+');
        if($pointer){
            //Escreve no arquivo
            fwrite($pointer, $string);
            //Fecha o arquivo
            fclose($pointer);
            return true;
        }else{
            return false;
        }
    }
    
}

