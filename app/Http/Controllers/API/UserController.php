<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\RESTActions;
use App\Traits\ParseRequestSearch;
use Illuminate\Http\Request;
use App\Repositories\Contracts\IUserRepository;
use App\Transformers\UserTransformer;

/**
 * UserController
 * Author: trinhnv
 * Date: 2018/07/16 10:34
 */
class UserController extends Controller
{
    use RESTActions;
    use ParseRequestSearch;

    public function __construct(IUserRepository $repository, UserTransformer $transformer)
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
