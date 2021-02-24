<?php


namespace Core\lib\socket;

use Throwable;

interface AppExceptionInterface
{
    public function handle(Throwable $throwable): void;
}