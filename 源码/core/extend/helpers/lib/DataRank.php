<?php

namespace Core\extend\helpers\lib;

/**
 * 数据排序
 * Trait DataRank
 * @package swoyx\helpers\lib
 */
trait DataRank
{

    /**
     * 数组无限极分类
     * @param array $array
     * @param string $primary_key
     * @param string $parent_key
     * @return array
     */
    public function generateTree(array $array, string $primary_key = 'id', string $parent_key = 'pid'): array
    {
        $items = array();
        foreach ($array as $row) {
            $items[$row[$primary_key]] = $row;
        }
        $tree = array();
        foreach ($items as $k => $item) {
            if (isset($items[$item[$parent_key]])) {
                $items[$item[$parent_key]]['children'][] = &$items[$k];
            } else {
                $tree[] = &$items[$k];
            }
        }
        return $tree;
    }
}