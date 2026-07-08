<?php
require_once "vendor/autoload_real.php";
$o=new Endroid\QrCode\Qrcode();
$o->setText("www.D:\wamp64\www\learning\project\QRcode");
$o->setsize(250);
$o->setpadding(10);
$o->render();

?>