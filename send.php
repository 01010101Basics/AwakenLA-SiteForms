<?php
function send($to,$subject,$html,$file){
$bound =md5(time());
$eol = PHP_EOL;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: multipart/mixed; boundary="'.$bound.'"'  . "\r\n";
$from = "info@gettingrealwithgod.org";
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion()."\r\n";

$body = "--$bound" . "\r\n";
$body .= "Content-type: text/html; charset=utf-8" . "\r\n\r\n";
$body .= $html.$eol;

$body .= "--$bound" . "\r\n";
$body .= "Content-Type: application/octet-stream; name=\"{$file}\"" . "\r\n";
$body .= "Content-Transfer-Encoding: base64" . "\r\n";
$body .= "Content-Disposition: attachment" . "\r\n\r\n";
$body .= chunk_split(base64_encode(file_get_contents( "{$file}" ))) . "\r\n";
$body .= "--$bound--";

mail($to,$subject, $body, $headers);

}
//send("closerwalk@gmail.com","test","<html><body><h1>Testing HTML</h1></body></html>","visitors.csv");
