<?php


namespace App\Service\impl;


use App\Model\SystemDict;
use App\Service\SystemDictServiceInterface;
use App\Utils\CategoryUtil;
use Core\Drive;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Capsule\Manager as DB;

class SystemDictService implements SystemDictServiceInterface
{

    /**
     * 获取字典列表
     * @param string $dictName
     * @param string $keywords
     * @param string $where
     * @return mixed
     */
    public function getDict(string $dictName, string $keywords = '', string $where = '')
    {
        $dict = explode(",", $dictName);

        $dictLength = count($dict);

        if ($dictLength == 1) {

            //普通字典查询
            $list = SystemDict::with(['dicts' => function (Relation $relation) use ($keywords) {
                if ($keywords != '') {
                    $relation->whereRaw("name like '%{$keywords}%'");
                }
                $relation->where("status", 1)
                    ->orderBy("rank", "asc")
                    ->select(['val as id', 'dict_id', 'name']);
            }])->where("code", $dict[0])->first();

            return $list->dicts->toArray();

        } elseif ($dictLength >= 3) {
            //远程表字典查询
            $prefix = Drive::$config['Mysql']['prefix'];
            $table = explode('->', $dict[0]);

            try {
                $field = "{$dict[1]} as id,{$dict[2]} as name" . (array_key_exists(3, $dict) ? ",{$dict[3]} as pid" : '');
                $whereX = '';
                if ($keywords != '') {
                    $whereX .= " {$dict[2]} like '%{$keywords}%' and ";
                }

                if (count($table) == 2) {
                    $whereX .= "{$table[1]} and ";
                }

                if ($where != '') {
                    $whereX .= "{$where}";
                }

                if ($whereX != '') {
                    $whereX = 'where ' . $whereX;
                    $whereX = trim(trim(trim($whereX), 'and'));
                }
                $select = DB::select("select {$field} from {$prefix}{$table[0]} {$whereX} order by id asc");

                if (array_key_exists(3, $dict)) {
                    $select = CategoryUtil::generateTree($select, 'id', 'pid', 'children');
                }

            } catch (\Exception $e) {
                return null;
            }
            return $select;
        }

        return null;
    }
}