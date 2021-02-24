<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $key
 * @property int $player_video_info
 * @property int $player_random_av
 * @property string $player_random_av_content
 * @property string $player_background
 * @property string $player_color
 * @property int $player_autoplay
 * @property int $player_barrage_switch
 * @property string $player_barrage_block
 * @property int $player_barrage_interval
 * @property string $player_barrage_etiquette
 * @property string $player_barrage_etiquette_address
 * @property string $player_logo
 * @property int $player_wait_time
 * @property int $player_advertising_switch
 * @property string $player_advertising_image_address
 * @property string $player_advertising_address
 * @property string $player_marquee_occlude
 * @property string $player_marquee_customize
 * @property int $player_status
 * Class Player
 * @package App\Model
 */
class Player extends Model
{
    /**
     * @var string
     */
    protected $table = 'player';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'player_video_info' => 'integer',
        'player_random_av' => 'integer',
        'player_autoplay' => 'integer',
        'player_barrage_switch' => 'integer',
        'player_barrage_interval' => 'integer',
        'player_status' => 'integer',
    ];

}