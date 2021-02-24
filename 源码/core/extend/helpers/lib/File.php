<?php

namespace Core\extend\helpers\lib;

trait File
{

    /**
     * 扫描目录
     * @param $scanInfo
     * @param string $path
     * @param array $suffix
     */
    public function scanDirectory(&$scanInfo, string $path, array $suffix = []): void
    {
        $str = substr($path, -1);

        if ($str != '/') {
            $path .= '/';
        }

        $list = scandir($path);
        foreach ($list as $item) {
            if ($item != '.' && $item != '..') {
                if (is_dir($path . $item)) {
                    $this->scanDirectory($scanInfo, $path . $item, $suffix);
                } else {
                    //判断文件后缀
                    if (!empty($suffix)) {
                        $fileSuffix = explode('.', $item);
                        if (!in_array(end($fileSuffix), $suffix)) {
                            continue;
                        }
                    }
                    $scanInfo[] = $path . $item;
                }
            }
        }
    }
}