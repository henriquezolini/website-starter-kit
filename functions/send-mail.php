<?php

header('Content-Type: application/json');


//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require '../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.exemplo.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'automatico@exemplo.com';                     //SMTP username
    $mail->Password   = 'act3w3xfnv42';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('automatico@exemplo.com', 'Exemplo');
    $mail->addAddress('atendimento@exemplo.com', 'Exemplo');   
    $mail->setFrom('automatico@exemplo.com', 'Exemplo');


    $mensagem = '<html><body>';
    $mensagem .= '<h2>Formulário</h2>';
    $mensagem .= '<table border="1" cellpadding="5" cellspacing="0">';
    $mensagem .= '<tr><th>Campo</th><th>Valor</th></tr>';

    foreach ($_POST as $campo => $valor) {
        $mensagem .= '<tr>';
        $mensagem .= '<td>' . htmlspecialchars($campo) . '</td>';
        $mensagem .= '<td>' . htmlspecialchars($valor) . '</td>';
        $mensagem .= '</tr>';
    }

    $mensagem .= '</table>';
    $mensagem .= '</body></html>';



   $mail->isHTML(true);                                  
    $mail->Subject = 'Contato de exemplo.com';
    $mail->Body    = $mensagem;

    $mail->send();
    echo json_encode([
        'success' => true,
        'message' => 'Obrigado! Sua mensagem foi enviada com sucesso!'
    ]);
} catch (Exception $e) {
    http_response_code(400); 
    echo json_encode([
        'success' => false,
        'message' => 'Houve uma falha interna ao processar seu pedido.'
    ]);
}