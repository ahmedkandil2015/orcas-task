<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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
        $users = (collect($this->users))->map(function($user){

            return [
                "email"=>$user[$this->schema['email']],
                "firstName"=>$user[$this->schema['firstName']],
                "lastName"=>$user[$this->schema['lastName']],
                "avatar"=>$user[$this->schema['avatar']]
            ];
        })->toArray();
        DB::table('users')->insert($users); // Query Builder approach

        //
    }
}
