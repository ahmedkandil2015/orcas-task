<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ListRequest;
use App\Http\Requests\Users\searchRequest;
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
    public function search(searchRequest $request)
    {
        $filterAttributes=[];
        if(isset($request->firstName)){
            $filterAttributes['firstName']=$request->firstName;
        }
        if(isset($request->lastName)){
            $filterAttributes['lastName']=$request->lastName;
        }
        if(isset($request->email)){
            $filterAttributes['email']=$request->email;
        }
        $users = $this->userRepository->list($filterAttributes);
        return $this->userRepository->paginate($users, $request->per_page, $request->page, config('app.url'));
 
    }

    
}
