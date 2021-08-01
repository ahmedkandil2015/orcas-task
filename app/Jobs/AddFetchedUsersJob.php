<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AddFetchedUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $users,$schema;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users , $schema)
    {
        $this->users=$users;
        $this->schema=$schema;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {  
        $data["users"] = (collect($this->users))->map(function($user){

            return [
                "email"=>$user[$this->schema['email']],
                "firstName"=>$user[$this->schema['firstName']],
                "lastName"=>$user[$this->schema['lastName']],
                "avatar"=>$user[$this->schema['avatar']]
            ];
        })->toArray();

        $validator = Validator::make($data, [
            'users.*.email' => 'required|unique:users,email',
            'users.*.firstName' => 'required',
            'users.*.lastName' => 'required',
            'users.*.avatar' => 'required',
        ]);
        $users = $data['users'];
        if($validator->fails()){
            foreach($validator->errors()->all() as $error){
                $explodeError=explode('.',$error);
                unset($users[$explodeError[1]]);
            }
        }
        if(count($users)==0){
            Log::info("not insert");
            return true;

        }
        DB::table('users')->insert($data["users"]); 
        Log::info("insert");
        Log::info("finish");

        
    }
}
