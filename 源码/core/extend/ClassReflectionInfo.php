<?php

namespace Core\extend;

/**
 * Class ClassReflectionInfo
 * @package swoyx\struct
 */
class ClassReflectionInfo
{
    /**
     * 包名
     * @var string
     */
    public $package;

    /**
     * 类信息
     * @var string
     */
    public $info;

    /**
     * 类名
     * @var string
     */
    public $className;

    /**
     * 方法信息
     * @var array
     */
    public $methods;


    /**
     * ClassReflectionInfo constructor.
     * @param string $package
     * @param string $info
     * @param string $className
     * @param array $methods
     */
    public function __construct(string $package, string $info, string $className, array $methods)
    {
        $this->package = $package;
        $this->info = $info;
        $this->className = $className;
        $this->methods = $methods;
    }
}