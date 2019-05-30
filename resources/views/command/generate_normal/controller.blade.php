namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{{$Module}};
use App\Repositories\Contracts\I{{$Module}}Repository;
use App\Traits\Controllers\ResourceController;

/**
 * {{$Module}}Controller
 * Author: trinhnv
 * Date: {{date('Y/m/d H:i')}}
*/
class {{$Module}}Controller extends Controller
{
    use ResourceController;

    /**
     * @var string
    */
    protected $resourceAlias = 'admin.{{strtolower($Module)}}s';

    /**
     * @var string
    */
    protected $resourceRoutesAlias = 'admin::{{strtolower($Module)}}s';

    /**
     * Fully qualified class name
     *
     * @var string
    */
    protected $resourceModel = {{$Module}}::class;

    /**
     * @var string
    */
    protected $resourceTitle = '{{$Module}}';

    /**
     * Controller construct
    */
    public function __construct(I{{$Module}}Repository $repository)
    {
        $this->repository = $repository;
    }

}
