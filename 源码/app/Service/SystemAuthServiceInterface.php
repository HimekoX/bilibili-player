<?php

namespace App\Service;

interface SystemAuthServiceInterface
{
    public function LoginAuth(array $data,string $address);
}