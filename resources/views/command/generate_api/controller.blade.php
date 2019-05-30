namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\RESTActions;
use App\Traits\ParseRequestSearch;
use Illuminate\Http\Request;
use App\Repositories\Contracts\I{{$Module}}Repository;
use App\Transformers\{{$Module}}Transformer;

/**
* {{$Module}}Controller
* Author: trinhnv
* Date: {{date('Y/m/d H:i')}}
*/
class {{$Module}}Controller extends Controller
{
    use RESTActions;
    use ParseRequestSearch;

    public function __construct(I{{$Module}}Repository $repository, {{$Module}}Transformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        $criteria = $this->parseRequest($request);
        $collections = $this->repository->findBy($criteria);
        return $this->respondTransformer($collections);
    }
}
