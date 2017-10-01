<?php

require_once './config.php';
require_once './vendor/autoload.php';
try {
    $mail = new Mylib\Facades\Mail;
    $mail->from('marco.belmont6@gmail.com');
    $mail->to('marco.belmont6@gmail.com');
    $mail->attachment('Logs/acessos.txt');
    $mail->content('Teste email', "<b>Olá mundo!</b><br> Este é um email enviado utilizando o PHPMailer");
    if($mail->enviar()) echo 'Sucesso';
} catch (Exception $ex) {
    echo $ex->getMessage();
}