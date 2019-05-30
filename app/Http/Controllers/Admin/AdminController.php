<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IUserRepository;
use App\Traits\Controllers\ResourceController;
use App\User;
use Illuminate\Http\Request;

/**
 * UserController
 * Author: trinhnv
 * Date: 2018/07/16 10:24
 */
class AdminController extends Controller
{
    use ResourceController;

    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.users';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::users';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = User::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'User';

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return view('admin.index');
    }

}
