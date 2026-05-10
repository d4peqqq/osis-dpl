<?php
require 'vendor/autoload.php';
$q = new chillerlan\QRCode\QRCode();
$result = $q->render('test');
echo "Output begins with:\n";
echo substr($result, 0, 50) . "\n";
echo strpos($result, '<svg') !== false ? "Has SVG" : "No SVG";
