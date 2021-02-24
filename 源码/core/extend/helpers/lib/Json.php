<?php

namespace Core\extend\helpers\lib;

trait Json
{
    /**
     * 获取JSON节点数据
     * @param string $path
     * @param string $node
     * @return bool|mixed
     */
    public function getJson(string $path, string $node = "")
    {
        if (!file_exists($path)) {
            return false;
        }

        $file = file_get_contents($path);
        if (empty($file)) {
            return false;
        }

        $json = json_decode($file, true);
        if (!empty($node)) {
            $nodes = explode(".", $node);
            foreach ($nodes as $n) {
                $json = $json[$n];
            }
        }
        return $json;
    }

    /**
     * 设置JSON数据
     * @param string $file
     * @param array $arrayJson
     * @return bool
     */
    public function setJson(string $file, array $arrayJson): bool
    {
        if (!file_exists($file)) {
            $path = explode("/", $file);
            $path = str_replace(end($path), "", $file);
            if (!is_dir($path)) {
                if (!mkdir($path, 0777, true)) {
                    return false;
                }
            }
            $handle = fopen($file, 'w');
            fclose($handle);
        }
        if (!file_put_contents($file, json_encode($arrayJson))) {
            return false;
        }
        return true;
    }

}