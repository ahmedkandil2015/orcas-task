<?php

namespace App\Console\Commands;

use App\Jobs\AddFetchedUsersJob;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Nonstandard\Uuid;

class FetchUsersCommand extends Command
{
     
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orcas:fetch-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch New Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client  = new Client();
        $userSources=Config::get('app.user-sources');
        if(!Config::has('app.user-sources') || count( $userSources)==0){
            Log::info("we haven't users sources ");
            return ;
        }
        foreach( $userSources as $userSource){
            try{
                $request = $client->request('get',$userSource['endpoint']);
                $response= json_decode($request->getBody(),true);
                if(count($response)==0){
                    continue;
                }
                $identifire = (string)Uuid::uuid4();
                Cache::add($identifire ,$response,now()->addMinutes(30));
                Log::info($userSource['endpoint']);
                Log::info($response);
                AddFetchedUsersJob::dispatch($response,$userSource['schema']);
             }catch(\Exception $exception){
                 dd($exception);
             }
        }
        return ;
    }
}
