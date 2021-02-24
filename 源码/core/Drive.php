<?php

namespace Core;

use App\Utils\BasicUtil;
use Core\extend\exception\JSONException;
use Core\extend\exception\NotFoundException;
use Core\extend\exception\ViewException;
use Core\route\Route;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class Drive
{
    public static $config = []; //配置文件

    /**
     * 运行框架核心
     */
    public function CoreRun()
    {
        $app = require(HOME_DIR . 'core/config/exception.php');
        try {
            $this->Iinitialize();
        } catch (\Throwable $e) {
            if (class_exists($app['exception'])) {
                $exception = new $app['exception'];
                if ($e instanceof NotFoundException) {
                    $exception->handle($e);
                } elseif ($e instanceof JSONException) {
                    header('content-type:application/json;charset=utf-8');
                    $exception->handle($e);
                } elseif ($e instanceof ViewException) {
                    header("Content-type: text/html; charset=utf-8");
                    $exception->handle($e);
                } else {
                    $exception->handle(new RuntimeException($e->getMessage()));
                }
            } else {
                throw new RuntimeException($e->getMessage(), $e->getCode(), $e->getPrevious());
            }
        }
    }

    /**
     * 初始化框架配置
     * @throws \ReflectionException
     * @throws JSONException
     */
    private function Iinitialize()
    {
        $this->LoadContainer();
        $this->LoadFeatures();
        $this->LoadConfig();
        $this->LoadSql();
        $this->LoadRoute();
    }

    /**
     * 加载容器
     */
    private function LoadContainer()
    {
        $dependencies = require(HOME_DIR . 'core/config/dependencies.php');

        $dependencies[RequestInterface::class] = \Laminas\Diactoros\Request::class;
        $dependencies[ResponseInterface::class] = \Laminas\Diactoros\Response::class;

        foreach ($dependencies as $key=>$val){
            Container::bind($key,new $val);
        }

    }

    /**
     * 加载功能
     */
    private function LoadFeatures()
    {
        header("Content-type: text/html; charset=utf-8");//设置网页编码
        header("Server:Tomcat-9.0");//隐藏环境名
        date_default_timezone_set('PRC');//初始化时区
        session_start();//启用session
    }

    /**
     * 加载配置文件
     */
    private function LoadConfig()
    {
        require(HOME_DIR . 'core/extend/Helper.php');//导入出错页
        self::$config = require(HOME_DIR . 'core/store/Config.php');//配置文件
        $this->Debug();
    }

    /**
     * 调试模式
     */
    private function Debug()
    {
        if (self::$config['Debug']) {
            error_reporting(0);
        }
    }

    /**
     * 加载数据库
     */
    private function LoadSql()
    {
        if (self::$config['Mysql_Status']) {
            //初始化数据库
            $capsule = new \Illuminate\Database\Capsule\Manager();
            // 创建链接
            $capsule->addConnection(self::$config['Mysql']);
            // 设置全局静态可访问
            $capsule->setAsGlobal();
            // 启动Eloquent
            $capsule->bootEloquent();
        }
    }

    /**
     * 加载路由
     * @throws \ReflectionException
     * @throws JSONException
     */
    private function LoadRoute()
    {

        Router::register();

        $requestMode = strtolower($_SERVER['REQUEST_METHOD']);
        $route = BasicUtil::get('route');
        $router = Route::instance()->getRouter((string)$route, $requestMode);

        //判断路由是否存在
        if (empty($router)) {
            throw new JSONException('Routing error,The reason may be the wrong type or non-existent', 0);
        }

        $controller = new $router['package'];
        $arg = [];

        Middleware::register($router);

        foreach ($router['param'] as $name => $item) {
            if (!isset($item['value'])) {
                $arg[] = $this->getRequestParams($name, $item['type'], $requestMode);
            } else {
                $arg[] = $this->typeConvert($item['type'], $item['value']);
            }
        }

        $Dependencies = Container::register($router);

        foreach ($Dependencies as $name => $dependency) {
            $controller->$name = $dependency;
        }

        echo call_user_func_array([$controller, $router['method']], $arg);
    }

    /**
     * 获取请求参数
     * @param string $name
     * @param string $type
     * @param string $requestMode
     * @return array|float|int|string
     */
    private function getRequestParams(string $name, string $type, string $requestMode)
    {
        switch ($requestMode) {
            case 'get':
                $input = BasicUtil::string_remove_xss($_GET[$name]);
                break;
            case 'post':
                $input = BasicUtil::string_remove_xss($_POST[$name]);
                break;
        }

        return $this->typeConvert($type, $input);
    }

    /**
     * 类型自动转换
     * @param $type
     * @param $value
     * @return array|float|int|string
     */
    private function typeConvert($type, $value)
    {
        switch ($type) {
            case 'string':
                $input = (string)$value;
                break;
            case 'array':
                $input = (array)$value;
                break;
            case 'int':
                $input = (int)$value;
                break;
            case 'float':
                $input = (float)$value;
                break;
        }

        return $input;
    }

}