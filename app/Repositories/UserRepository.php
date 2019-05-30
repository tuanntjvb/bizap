<?php 
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;

/**
* UserRepository class
* Author: trinhnv
* Date: 2018/07/16 10:34
*/
class UserRepository extends AbstractRepository implements IUserRepository
{
     /**
     * UserModel
     *
     * @var  string
     */
	  protected $modelName = User::class;
}
