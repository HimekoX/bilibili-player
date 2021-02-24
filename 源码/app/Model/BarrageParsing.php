<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $av
 * @property string $remarks
 * Class BarrageParsing
 * @package App\Controller\System
 */
class BarrageParsing extends Model
{
    /**
     * @var string
     */
    protected $table = 'barrage_parsing';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];
}