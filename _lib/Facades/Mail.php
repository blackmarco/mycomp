<?php

/* 
 * Classe para manipulação de emails do componentes PHPMailer
 * Implementação do Design Pattern Facade
 */

namespace Mylib\Facades;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    /* @var $mail = Objeto PHPMailer */
    private $mail;
    
    public function __construct() 
    {
        //Parametro true habilita exceções
        $this->mail = new PHPMailer(true);
        //Define a codificação
        $this->mail->CharSet = 'UTF-8';
        //Nível de debug do email(0 em produção)
        $this->mail->SMTPDebug = 0;
        //Define o uso de SMTP
        $this->mail->isSMTP();      
        //Configurações do SMTP
        $this->mail->Host = SMTPHOST;  
        $this->mail->SMTPAuth = true;                               
        $this->mail->Username = SMTPUSER;                
        $this->mail->Password = SMTPPASS;                           
        $this->mail->SMTPSecure = SMTPSECURE;                 
        $this->mail->Port = SMTPPORT;  
    }
    
    //Define o remetente do email
    /* @param $address = endereço de email */
    /* @param $name = nome do remetente */
    public function from($address, $name = null) 
    {
        //Verifica de foi informado o nome do remetente
        if($name){
            $this->mail->setFrom($address, $name);
        }else{
            $this->mail->setFrom($address);
        }
    }
    
    //Define o destinatário do email
    /* @param $address = endereço de email */
    /* @param $name = nome do destinatário */
    public function to($address, $name = null) 
    {
        //Verifica se foi informado o nome do destinatário e define com ou sem nome
        if($name){
            $this->mail->addAddress($address, $name);
        }else{
            $this->mail->addAddress($address);
        }
    }
    
    //Adiciona um anexo ao email
    /* @param $file = caminho e nome do arquivo */
    public function attachment($file) 
    {
        //Verifica se existe o arquivo
        if(file_exists($file)){
            //Anexa ao email
            $this->mail->addAttachment($file);
        }
    }
    
    //Define o assunto e conteúdo do email
    /* @param $subject = Assunto */
    /* @param $body = Conteúdo */
    /* @param $isHTML = HTML ou não */
    public function content($subject, $body, $isHTML = true) 
    {
        //Verfica se o email vai ser HTML ou não
        if($isHTML = true){
            $this->mail->isHTML(true);
        }else{
            $this->mail->isHTML(false);
        }
        //Define o assunto
        $this->mail->Subject = $subject;
        //Define o conteúdo do email
        $this->mail->Body = $body;
    }
    
    //Envia o email
    public function enviar(): bool 
    {
        //Verifica se o envio ocorreu com sucesso e retorna true
        if($this->mail->send()){
            return true;
        }else{
            return false;
        }
    }
    
}