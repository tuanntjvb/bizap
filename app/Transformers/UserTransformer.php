<?php 
namespace App\Transformers;

use League\Fractal;
use App\Models\User;

/**
* UserTransformer class
* Author: trinhnv
* Date: 2018/07/16 10:34
*/
class UserTransformer extends Fractal\TransformerAbstract
{
    public function transform(User $item)
	{
		return $item->toArray();
	}
}
