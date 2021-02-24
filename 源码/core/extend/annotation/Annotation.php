<?php

namespace Core\extend\annotation;

use Core\extend\ClassReflectionInfo;

class Annotation
{
    /**
     * 获取注解
     * @param string $method
     * @param string $annotation
     * @return array
     */
    public static function get(string $method, string $annotation): array
    {
        preg_match("/@{$method}([\s\S]+?)\*/", $annotation, $match);

        if (!isset($match[1])) {
            return [];
        }
        $arg = (string)$match[1];
        $arg = explode(",", trim(trim(trim(trim($arg), ")"), "("), "\""));
        foreach ($arg as $key => $val) {
            $arg[$key] = trim(trim($val, '"'));
        }

        return $arg;
    }


    /**
     * 获取类的信息
     * @param string $class_path
     * @return ClassReflectionInfo|bool
     * @throws \ReflectionException
     */
    public static function getClassInfo(string $class_path)
    {
        if (file_exists($class_path)) {
            $clazz = file_get_contents($class_path);

            $suf = trim(end(explode('/', $class_path)), '.php');

            //搜索包信息
            $packageInfo = self::get('package', $clazz);

            if (!isset($packageInfo[0])) {
                return false;
            }

            $class = $packageInfo[0] . '\\' . $suf;

            $ref = new \ReflectionClass($class);

            //正则获取所有方法
            preg_match_all("/public function.*?\(.*?\)/", $clazz, $match);

            $methodInfos = [];

            foreach ($match[0] as $item) {
                //继续匹配每个方法的详细信息
                preg_match("/public function (.*?)\(.*?\)/", $item, $func);
                preg_match("/public function.*?\((.*?)\)/", $item, $arg);
                //方法名称
                $method = $func[1];
                //方法所需要的参数
                $argData = explode(',', $arg[1]);

                $param = [];
                //获取传参
                foreach ($argData as $datum) {
                    $var = explode('$', trim($datum));
                    //至少拥有变量
                    if ($var[1] != '') {
                        //如果是2表示强制类型
                        if (count($var) == 2) {
                            $type = trim($var[0]);
                            $param[trim($var[1])] = [
                                'type' => ($type ? $type : "mixed")
                            ];
                        } else {
                            //如果是1表示弱类型传参
                            $param[trim($var[0])] = [
                                'type' => 'mixed'
                            ];
                        }
                    }
                }

                $methodInfos[] = [
                    'name' => $method,
                    'param' => $param,
                    'header' => $ref->getMethod($method)->getDocComment()
                ];
            }
            $classReflectionInfo = new ClassReflectionInfo($class, $ref->getDocComment(), $suf, $methodInfos);

            return $classReflectionInfo;
        }
        return false;
    }
}