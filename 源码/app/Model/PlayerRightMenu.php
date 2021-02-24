<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $pid
 * @property string $title
 * @property string $address
 * @property int $rank
 * Class PlayerRightMenu
 * @package App\Model
 */
class PlayerRightMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'player_right_menu';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer','pid'=>'integer','rank'=>'integer'];

    /**
     * @var bool
     */
    public $timestamps = false;
}