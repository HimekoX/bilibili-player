<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property int $cid
 * @property string $type
 * @property string $text
 * @property string $color
 * @property string $size
 * @property string $videotime
 * @property string $ip
 * @property int $time
 * @property string $referer
 * Class BarrageList
 * @package App\Model
 */
class BarrageList extends Model
{
    /**
     * @var string
     */
    protected $table = 'barrage_list';

    /**
     * 主键设置
     * @var string
     */
    protected $primaryKey = 'cid';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = [
        'cid' => 'integer',
        'time' => 'integer'
    ];
}