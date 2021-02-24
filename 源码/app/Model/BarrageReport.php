<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cid
 * @property string $id
 * @property string $text
 * @property string $type
 * @property string $time
 * @property string $ip
 * @property string $referer
 * Class BarrageReport
 * @package App\Model
 */
class BarrageReport extends Model
{
    /**
     * @var string
     */
    protected $table = 'barrage_report';

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
        'cid' => 'integer'
    ];
}