namespace App\Repositories;

use App\Models\{{$Module}};
use App\Repositories\Contracts\I{{$Module}}Repository;

/**
* {{$Module}}Repository class
* Author: trinhnv
* Date: {{date('Y/m/d H:i')}}
*/
class {{$Module}}Repository extends AbstractRepository implements I{{$Module}}Repository
{
     /**
     * {{$Module}}Model
     *
     * @var string
     */
	  protected $modelName = {{$Module}}::class;
}
