<?php

namespace Core;

use Core\lib\Request;
use ReflectionClass;

class Container
{
    protected static $container = [];

    /**
     * 获取注入信息
     * @param $item
     * @return array
     * @throws \ReflectionException
     */
    public static function register($item) :array
    {
        $rp = new ReflectionClass($item['package']);
        $source = file_get_contents($rp->getFileName());
        $properties = $rp->getProperties();

        $propertyDependencies = [];

        foreach ($properties as $property) {
            preg_match('/@var(.*)+?/', $property->getDocComment(), $b);
            //拿到var
            $var = trim((string)$b[1]);
            //拿到service地址
            preg_match("/use (.*){$var};/", $source, $c);
            //拿到service的命名空间
            $namespace = trim((string)$c[1]) . $var;
            //检测接口是否存在
            if (interface_exists($namespace) && strpos($property->getDocComment(), '@Inject') !== false) {
                //进行依赖注入
                $propertyDependencies[$property->getName()] = self::make($namespace);
            }
        }

        return $propertyDependencies;
    }

    public static function bind($name, $resolver)
    {
        static::$container[$name] = $resolver;
    }

    public static function make($name)
    {
        if (isset(static::$container[$name])) {
            return static::$container[$name];
        }
        throw new \Exception('Binding does not exist in container');
    }
}