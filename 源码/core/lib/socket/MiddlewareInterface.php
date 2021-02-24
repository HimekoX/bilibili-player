<?php


namespace Core\lib\socket;

interface MiddlewareInterface
{
    public function handle(): void;
}