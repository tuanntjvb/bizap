<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\Users;

/**
* UsersTransformer class
* Author: trinhnv
* Date: 2018/07/13 03:02
*/
class UsersTransformer extends Fractal\TransformerAbstract
{
    public function transform(Users $item)
	{
		return $item->toArray();
	}
}
