<?php
//Mailer Section


function Send_Mail($to, $subject, $body)
{

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $from = "info@gettingrealwithgod.org";
    $headers .= 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion() . "\r\n";

    mail(
        $to,
        $subject,
        $body,
        $headers
    );
}

?>