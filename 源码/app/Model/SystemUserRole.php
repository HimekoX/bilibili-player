<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id 
 * @property int $user_id 
 * @property int $role_id 
 */
class SystemUserRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_user_role';
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
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'role_id' => 'integer'];

    public $timestamps = false;
}