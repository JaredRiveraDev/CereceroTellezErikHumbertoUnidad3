<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

date_default_timezone_set('America/Mexico_City');
$rutaAVendor = "Ingenieria/desarrollowebp/unidad3/StyleSpectrum/";
require 'autoload.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = "ssl://smtp.gmail.com";
$mail->Port = 465;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//$mail->SMTPDebug = 4;
$mail->SMTPAuth = true;
$mail->AuthType = 'XOAUTH2';

$email = $correoEmisor;
$clientId = "525093042451-76veue64cl86q6anvfrquqjajtb3t9k6.apps.googleusercontent.com";
$clientSecret = "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";
$refreshToken = "1//0fYTyzxuMf5p2CgYIARAAGA8SNwF-L9IrW0PQjTf6deJsO4dNyf2MzeEemvF4WXtHEz9LgxjqqYKPQ0_cLl0j1fzEMRs10rE5Ti4";

$provider = new Google(
    [
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]
);

$mail->setOAuth(
    new OAuth(
        [
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $email,
        ]
    )
);

$mail->setFrom($email, $nombreEmisor);
$mail->addAddress($destinatario, $nombreDestinatario);
$mail->Subject = $asunto;
$mail->CharSet = PHPMailer::CHARSET_UTF8;
$mail->Body = $cuerpo;
$mail->AltBody = 'This is a plain text message body';

if(!$mail->send()){
    echo "Mailer Error: ".$mail->ErrorInfo;
    
}else{
    echo $aviso;
}