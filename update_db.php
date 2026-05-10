<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$p1 = App\Models\Pengaturan::firstOrCreate(['key'=>'email']);
$p1->value = 'osis@alkausar.sch.id';
$p1->save();

$p2 = App\Models\Pengaturan::firstOrCreate(['key'=>'telepon']);
$p2->value = '+62 821-1814-3180';
$p2->save();
echo "Done";
