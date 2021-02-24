<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $user
 * @property string $pass
 * @property string $face
 * @property string $phone
 * @property string $nickname
 * @property string $salt
 * @property string $login_date
 * @property string $create_date
 * @property string $login_ip
 * @property int $status
 * Class Pay
 * @package App\Model
 */
class SystemUser extends Model
{
    /**
     * @var string
     */
    protected $table = 'system_user';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = ['id' => 'integer','status'=>'integer'];

    /**
     * 获取用户下的角色
     */
    public function roles()
    {
        return $this->belongsToMany(SystemRole::class, 'system_user_role', 'user_id', 'role_id');
    }
}