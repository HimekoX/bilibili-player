<?php

namespace Core;

use Core\extend\annotation\Annotation;
use ReflectionClass;

class Middleware
{
    /**
     * 中间件验证器
     * @param $item
     * @throws \ReflectionException
     */
    public static function register($item): void
    {
        $classInfo = Annotation::getClassInfo((string)$item['item']);

        $Middleware = Annotation::get('Middleware', (string)$classInfo->info);
        if ($Middleware[0]) {
            self::Interceptor($classInfo,$Middleware);
        } else {
            foreach ($classInfo->methods as $method) {
                $Middleware = Annotation::get('Middleware', (string)$method['header']);

                if ($Middleware[0]) {
                    if ($method['name'] == $item['method']) {
                        self::Interceptor($classInfo,$Middleware);
                    }
                }
            }
        }
    }

    /**
     * 拦截器
     * @param object $classInfo
     * @param array $Middleware
     * @throws \ReflectionException
     */
    private static function Interceptor(object $classInfo,array $Middleware)
    {
        $interceptorName = explode("::", $Middleware[0])[0];

        $rp = new ReflectionClass($classInfo->package);
        //获取源代码
        $source = file_get_contents($rp->getFileName());
        //获取拦截器地址
        preg_match("/use (.*){$interceptorName};/", $source, $q);
        $namespace = trim((string)$q[1]) . $interceptorName;
        if (class_exists($namespace)) {
            //调用拦截器
            call_user_func([new $namespace, 'handle']);
        }

    }
}