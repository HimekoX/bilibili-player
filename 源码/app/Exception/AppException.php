<?php


namespace App\Exception;

use Core\extend\exception\JSONException;
use Core\lib\socket\AppExceptionInterface;
use Throwable;

class AppException implements AppExceptionInterface
{
    public function handle(Throwable $throwable): void
    {
        if ($throwable instanceof JSONException) {

          echo json_encode([
              "code" => $throwable->getCode(),
              "msg" => $throwable->getMessage()
          ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        }else{
            dd($throwable);
        }
    }
}