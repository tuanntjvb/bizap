<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Repositories\Contracts\IAdminRepository;
use App\Traits\Controllers\ResourceController;

/**
 * AdminController
 * Author: trinhnv
 * Date: 2018/09/03 01:52
 */
class AdminBaseController extends Controller
{
    use ResourceController;

    /**
     * Controller construct
     */
    public function __construct()
    {
    }

    public function authorize($ability, $arguments = [])
    {

    }

    public function getResourceIndexPath()
    {
        return 'admin._resources.index';
    }

    public function getResourceCreatePath()
    {
        return 'admin._resources.create';
    }

    public function getResourceEditPath()
    {
        return 'admin._resources.edit';
    }
}
