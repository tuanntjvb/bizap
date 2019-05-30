<?php
/**
 * UserModel class
 * Author: trinhnv
 * Date: 2018/07/16 10:34
 */

namespace App\Models;

use App\Traits\Eloquent\OrderableTrait;
use App\Traits\Eloquent\SearchLikeTrait;
use App\Traits\Models\FillableFields;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes, FillableFields, OrderableTrait, SearchLikeTrait;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'is_admin',
        'logo_number',
    ];

    public function getRecordTitle()
    {
        return $this->attributes['name'];
    }

    public function getLogoPath()
    {
        return "/adminlte/img/avatar_" . rand(1, 5) . ".png";
    }

    public function scopeSearch($query, $searchTerm = '')
    {
        return $query
            ->where('name', 'like', "%" . $searchTerm . "%")
            ->orWhere('email', 'like', "%" . $searchTerm . "%");
    }
}
