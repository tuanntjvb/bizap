<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\IUserRepository;

class HomeController extends Controller
{
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->findBy();

        return view('welcome', compact('users'));
    }
}
