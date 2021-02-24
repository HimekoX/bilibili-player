<?php

namespace Core;

use Core\route\Route;
use Core\extend\helpers\Utility;
use Core\extend\annotation\Annotation;

/**
 * Class Router
 * @package http\lib
 */
class Router
{
    const ALL = '*';
    const GET = 'get';
    const POST = 'post';

    /**
     * 注册路由服务器
     * @throws \ReflectionException
     */
    public static function register(): void
    {
        $scanInfo = [];
        Utility::instance()->scanDirectory($scanInfo, HOME_DIR . 'app/', ['php']);
        $routerInstance = Route::instance();

        foreach ($scanInfo as $item) {

            $classInfo = Annotation::getClassInfo((string)$item);
            //检测类是否为控制器
            $controller = Annotation::get('Controller', (string)$classInfo->info);
            $AutoController = Annotation::get('AutoController', (string)$classInfo->info);

            if ($controller[0] != "" || $AutoController != null) {

                //批量注册控制器
                foreach ($classInfo->methods as $method) {

                    $RequestMapping = Annotation::get('RequestMapping', (string)$method['header']);
                    $GetMapping = Annotation::get('GetMapping', (string)$method['header']);
                    $PostMapping = Annotation::get('PostMapping', (string)$method['header']);

                    //请求限制
                    $requestMode = self::ALL;
                    $arrData = [];
                    if ($RequestMapping != null) {
                        if (empty($RequestMapping[0])) {
                            continue;
                        }
                        if (!empty($RequestMapping[1])) {
                            $requestMode = strtolower($RequestMapping[1]);
                        }
                        $arrData['request'] = $RequestMapping[0];
                    } else if ($GetMapping != null) {
                        if (empty($GetMapping[0])) {
                            continue;
                        }
                        $requestMode = "get";
                        $arrData['request'] = $GetMapping[0];
                    } else if ($PostMapping != null) {
                        if (empty($PostMapping[0])) {
                            continue;
                        }
                        $requestMode = "post";
                        $arrData['request'] = $PostMapping[0];
                    }

                    if ($controller[0] != "") {
                        $arrData['controller'] = $controller[0];
                    } else if ($AutoController != null) {
                        $arrData['controller'] = "/" . $classInfo->className;
                    }

                    $package = $classInfo->package;

                    $routerInstance->set($arrData['controller'] . $arrData['request'], $item, $requestMode, $package, $method['name'], $method['param']);

                }
            }

        }

    }
}