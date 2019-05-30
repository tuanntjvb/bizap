<?php
/**
 * UsersModel class
 * Author: trinhnv
 * Date: 2018/07/13 03:02
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'is_admin',
        'logo_number',
    ];
}
