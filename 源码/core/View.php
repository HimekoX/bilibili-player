<?php

namespace Core;

class View
{

    private static $instance = null;

    private $Small;


    /*
     * 获取单例
     */
    public static function instance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    private function __clone()
    {
    }

    /**
     * view constructor.
     */
    private function __construct()
    {
        $this->Small = new \Smarty();
        //启动模板缓存
        $this->Small->caching = \Smarty::CACHING_LIFETIME_CURRENT;
        $this->Small->left_delimiter = "#{";
        $this->Small->right_delimiter = "}";
        //模板缓存时间
        $this->Small->cache_lifetime = 1;
        //模板修改后刷新缓存
        $this->Small->compile_check = true;
    }

    /**
     * 渲染视图
     * @param string $file
     * @param array $data
     * @throws \SmartyException
     */
    public function display(string $file, array $data = [])
    {
        $this->Small->setTemplateDir(HOME_DIR . "storage/view/");
        $this->Small->setCompileDir(HOME_DIR . "run/runtime/temp/templates_c/");
        $this->Small->setConfigDir(HOME_DIR . "run/runtime/temp/configs/");
        $this->Small->setCacheDir(HOME_DIR . "run/runtime/temp/cache/");
        $this->Small->cache_id = str_replace('/', '_', $file);

        //循环加入普通参数
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->Small->assign($key, $value);
            }
        }

        //渲染
        return $this->Small->display($file . '.html');
    }
}