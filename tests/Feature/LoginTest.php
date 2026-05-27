<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\Login;
use App\Services\UserDatabaseInterface;

class LoginTest extends TestCase
{
    public function test_login_berhasil()
    {
        $mockDatabase = $this->createMock(UserDatabaseInterface::class);

        $mockDatabase->method('findUser')
            ->willReturn([
                'username' => 'admin',
                'password' => '12345'
            ]);

        $login = new Login();

        $hasil = $login->authenticate('admin', '12345', $mockDatabase);

        $this->assertEquals('Login berhasil', $hasil);
    }

    public function test_password_salah()
    {
        $mockDatabase = $this->createMock(UserDatabaseInterface::class);

        $mockDatabase->method('findUser')
            ->willReturn([
                'username' => 'admin',
                'password' => '12345'
            ]);

        $login = new Login();

        $hasil = $login->authenticate('admin', 'salah', $mockDatabase);

        $this->assertEquals('Password salah', $hasil);
    }
}