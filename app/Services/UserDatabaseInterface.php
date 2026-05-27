<?php

namespace App\Services;

interface UserDatabaseInterface
{
    public function findUser($username);
}