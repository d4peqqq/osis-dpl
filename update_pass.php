<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::where('email', 'admin@osis.sch.id')->first();
if (!$user) {
    echo "Admin user not found. Did you run the seeder?\n";
} else {
    $user->password = Illuminate\Support\Facades\Hash::make('Osis0525#');
    $user->save();
    echo "Password changed successfully for admin@osis.sch.id.\n";
}
