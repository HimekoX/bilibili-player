<?php

namespace Core\extend;

class Upload
{
    /**
     * 文件上传
     * @param $upload
     * @param $dir
     * @param $type
     * @param int $size
     * @return array|string
     */
    public static function run($upload, $dir, $type, $size = 10000)
    {
        //单文件处理
        if (count($upload) == count($upload, 1)) {
            $load = self::error($upload, $type, $size);
            if (is_array($load)) {
                //上传文件
                return self::move($load, $dir);
            } else {
                return ["code" => 100, "msg" => $load];
            }
        } else {
            //多文件初始化
            $list = array();
            $error_list = array();
            //多文件处理
            for ($i = 0; $i < count($upload); $i++) {

                $load = self::error($upload[$i], $type, $size);

                if (is_array($load)) {
                    //上传文件
                    $move = self::move($load, $dir);
                    //上传成功加入数组
                    if (is_array($move)) {
                        $list[] = $move;
                    }
                } else {
                    $error_list[] = $load;
                }

            }
            return ["success" => $list, "error" => $error_list];
        }

    }

    //抛异常
    private static function error($upload, $type, $size)
    {
        //异常代码处理
        if ($upload['error'] > 0) {
            switch ($upload['error']) {
                case 1:
                    $err_info = "上传失败,请修改php.ini中 upload_max_filesize";
                    break;
                case 2:
                    $err_info = "上传失败,文件超过表单最大值,请在php.ini中修改";
                    break;
                case 3:
                    $err_info = "上传失败,文件可能损坏";
                    break;
                case 4:
                    $err_info = "上传失败,请选择需要上传的文件";
                    break;
                case 6:
                    $err_info = "上传失败,请检查是否临时目录有权限";
                    break;
                case 7:
                    $err_info = "上传失败,文件写入失败";
                    break;
                default:
                    $err_info = "未知的上传错误";
                    break;
            }
            return $err_info;
        }
        //文件类型处理
        $exp = explode(".", $upload['name']);

        //判断文件数组是否大于2
        if (count($exp) < 2) return "文件无后缀无法识别";

        //最后一个值必定是后缀
        $fix = $exp[count($exp) - 1];
        if (!in_array($fix, $type)) return '不支持该后缀的文件';

        //文件大小限制
        $upload_size = $upload['size'] / 1024;
        if ($upload_size > $size) return '文件太大';

        return array('tmp' => $upload['tmp_name'], 'size' => $upload_size, 'name' => $upload['name'], 'fix' => $fix);
    }

    //开始处理文件

    private static function move($array, $dir)
    {

        //检测目录是否存在，不存在则创建目录
        if (!file_exists($dir)) mkdir(iconv("UTF-8", "GBK", $dir), 0777, true);

        $fileName = date("YmdHis") . mt_rand(1000000, 9999999) . '.' . $array['fix'];

        //文件名生成
        $uniqueName = $dir . '/' . $fileName;

        if (move_uploaded_file($array['tmp'], $uniqueName)) {
            return array("code" => 200, 'dir' => $uniqueName, 'size' => $array['size'], 'name' => $array['name'], 'fix' => $array['fix'], 'ok' => $fileName);
        } else {
            return ["code" => 100, "msg" => "文件上传失败"];
        }

    }
}