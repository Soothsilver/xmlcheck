<?php
require_once '../vendor/autoload.php';

/*
[mail]
host = "smtp.gmail.com"
port = "465"
security = "ssl"
user = "xmlcheck@gmail.com"
password = "RedSprite"
from_name = "XMLCheck System"
from_address = "xmlcheck@gmail.com"
 */
$host = "ssl://smtp.gmail.com";
$port = 465;
$security = "ssl";
$user = "xmlcheck@gmail.com";
$password = "RedSprite";
$from_name = "XMLCheck System";
$from_address = "xmlcheck@gmail.com";

$transport = \Swift_SmtpTransport::newInstance("smtp.gmail.com", 465);
if ($security)
{
    $transport->setUsername($user)->setPassword($password);
}
$mailer = \Swift_Mailer::newInstance($transport);
$message = \Swift_Message::newInstance("TEST")
    ->setFrom($from_address, $from_name)
    ->setTo(array("petrhudecek2010@gmail.com"))
    ->setBody("TESTING SUCCESS");

echo $mailer->send($message);