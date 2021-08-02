<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ListRequest;
use App\Http\Requests\Users\LoginRequest;
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

    
    public function login(LoginRequest $request)
    {
        $credentials = ['email'=>$request->email, 'password'=>$request->password];
        if (!$token = auth()->attempt($credentials)) {
            return responder()->error("verify_user", "user not found ")->respond(400);
        }
 

        return $this->respondWithToken($token);
        }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return responder()->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
