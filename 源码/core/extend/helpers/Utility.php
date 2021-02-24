<?php

namespace Core\extend\helpers;

use Core\extend\helpers\lib\DataRank;
use Core\extend\helpers\lib\File;
use Core\extend\helpers\lib\Json;
use Core\extend\helpers\lib\Replace;

/**
 * 工具类
 * Class Utility
 * @package small\extend
 */
class Utility
{

    /**
     * @var Utility
     */
    private static $instance = null;

    use File, Replace, Json, DataRank;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function instance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}