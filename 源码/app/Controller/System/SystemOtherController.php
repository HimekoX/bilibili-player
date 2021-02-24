<?php

namespace App\Controller\System;

use App\Controller\SystemBaseController;
use Core\Drive;
use Core\extend\Upload;
use App\Middleware\SystemMiddleware;

/**
 * 文件上传控制器
 * Class SystemOtherController
 * @package App\Controller\System
 * @Controller("/system/other")
 * @Middleware(SystemMiddleware::class)
 */
class SystemOtherController extends SystemBaseController
{
    /**
     * 上传文件
     * @PostMapping("/upload")
     */
    public function upload()
    {
        $config = Drive::$config['Upload'];
        $img_upload = Upload::run($_FILES['file'], HOME_DIR . "run/runtime/upload", $config['suffix'], $config['size']);

        if($img_upload['code'] == 200){
            if ($img_upload['ok'] != Null) {
                $url = "/runtime/upload/" . $img_upload['ok'];
            }

            if (empty($url)) {
                $url = $img_upload;
            }

            return $this->ToJson(200,'success',['path'=>$url]);
        }else{
            return $this->ToJson(100,$img_upload['msg']);
        }
    }
}