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
class MasterController extends Controller
{
    /**
     * Controller construct
     */
    public function __construct()
    {
    }

    public function index()
    {
        return view('admin.master');
    }

}
