<?php


namespace App\Service;


interface UserAuthServiceInterface
{
    public function LoginAuth(array $data, string $address);
}