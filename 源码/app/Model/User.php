<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id 
 * @property string $user 
 * @property string $nick
 * @property string $pass
 * @property string $salt 
 * @property string $mailbox 
 * @property string $phone 
 * @property string $face 
 * @property string $create_time 
 * @property string $login_time 
 * @property string $login_ip 
 * @property int $status 
 */
class User extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * @var bool
     */
    public $timestamps = false;


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer'];
}