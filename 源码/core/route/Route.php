<?php


namespace Core\route;

class Route
{

    /**
     * 单例
     * @var self
     */
    protected static $instance = null;

    /**
     * 路由池
     * @var array
     */
    public $router = [
        '*' => [],
        'get' => [],
        'post' => []
    ];

    protected function __clone()
    {
    }

    protected function __construct()
    {
    }


    /**
     * 获取单例
     * @return self
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 注册路由
     * @param string $router
     * @param string $item
     * @param string $requestMode
     * @param string $package
     * @param string $method
     * @param array $param
     */
    public function set(string $router, string $item, string $requestMode, string $package, string $method, array $param = []): void
    {
        $this->router[$requestMode][$this->filter($router)] = [
            'package' => $package,
            'method' => $method,
            'item' => $item,
            'param' => $param
        ];
    }


    /**
     * 过滤路由
     * @param string $router
     * @return string
     */
    public function filter(string $router): string
    {
        $router = trim($router, "/");
        if ($router == "") {
            return "/";
        }
        return $router;
    }


    /**
     * 获取路由
     * @param string $router
     * @param string $requestMode
     * @return array|null
     */
    public function getRouter(string $router, string $requestMode)
    {
        //$requestMode = strtolower($requestMode);
        $router = $this->filter($router);
        //直接取路由
        $routerInfo = $this->router[$requestMode][$router];

        //如果没有取*匹配路由
        if (empty($routerInfo)) {
            $routerInfo = $this->router["*"][$router];
            //如果还没有，使用正则匹配路由
            if (empty($routerInfo)) {
                $routerInfo = $this->matchRouter($requestMode, $router);
            }
        }

        return $routerInfo;
    }


    /**
     * 匹配复杂路由
     * @param $requestMode
     * @param $router
     * @return array
     */
    private function matchRouter($requestMode, $router): array
    {
        $routerInfo = [];

        if (!empty($this->router[$requestMode])) {
            foreach ($this->router[$requestMode] as $route => $item) {
                $ruleMap = $this->getPattern($route);
                if (empty($ruleMap)) {
                    continue;
                }

                $ruleRouter = "/" . $router . "/";
                preg_match($ruleMap['pattern'], $ruleRouter, $match);

                if (!empty($match)) {
                    //检测长度是否一致
                    if (count(explode("/", $route)) != count(explode("/", $this->filter($ruleRouter)))) {
                        continue;
                    }

                    $routerInfo = $item;
                    $this->bindValue($routerInfo, $ruleMap, $match);
                    break;
                }
            }
        }


        //如果没有匹配到进行递归匹配
        if (empty($routerInfo) && $requestMode != '*') {
            return $this->matchRouter('*', $router);
        }

        return $routerInfo;
    }


    /**
     * 绑定值关系
     * @param $routerInfo
     * @param array $ruleMap
     * @param array $match
     */
    private function bindValue(&$routerInfo, array $ruleMap, array $match): void
    {
        foreach ($ruleMap['rule'] as $index => $rule) {
            $routerInfo['param'][$rule]['value'] = $match[$index + 1];
        }
    }


    private function getPattern(string $route): array
    {
        $ruleMap = [];
        $rule = explode('/', $route);
        $matchNum = 0;
        foreach ($rule as $key => $item) {
            if (strpos($item, ":") !== false) {
                $rule[$key] = "(.*?)";
                $ruleMap['rule'][] = trim($item, ':');
                $matchNum++;
            }
        }
        if ($matchNum == 0) {
            return [];
        }
        $ruleMap['pattern'] = "/" . str_replace('/', '\\/', "/" . implode('/', $rule) . "/") . "/";
        return $ruleMap;
    }
}