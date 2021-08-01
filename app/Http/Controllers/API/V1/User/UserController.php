<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ListRequest;
use App\Repositories\User\UserRepository;

class UserController extends Controller
{

    private $userRepository ;
    /**
     * Class constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(ListRequest $request)
    {
        $users = $this->userRepository->list();
        return $this->userRepository->paginate($users, $request->per_page, $request->page, config('app.url'));

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        //
    }

    
}
