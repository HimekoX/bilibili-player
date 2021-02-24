<?php

namespace Core\extend\helpers\lib;

trait Replace
{
    /**
     * 批量搜索建且替换值
     * @param array $array
     * @param array $replace
     * @return array
     */
    public function findKeyAndReplace(array $array, array $replace): array
    {
        foreach ($array as $key => $val) {
            foreach ($replace as $item => $value) {
                if (strpos((string)$val, $item) !== false) {
                    $array[$key] = str_replace($item, $value, $val);
                }
            }
        }
        return $array;
    }


    /**
     * 批量搜索替换字符串
     * @param string $str
     * @param array $replace
     * @return string
     */
    public function findStringAndReplace(string $str, array $replace): string
    {
        foreach ($replace as $item => $value) {
            if (strpos($str, $item) !== false) {
                $str = str_replace($item, $value, $str);
            }
        }
        return $str;
    }

}