<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScheduledRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ScheduledRequests:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     *        \Log::info("Cron is working fine!");

     * @return mixed
     */
    public function handle()
    {


           // get only the request that the time is less than the current time - 50 min
  
           // set the current time 
            $now = \Carbon\Carbon::now()->subMinutes(1);


            $requests = \App\UserRequests::where('status','SCHEDULED')->whereDate('schedule_at','<',$now)->get();


            foreach($requests as $request){
               $request->status = 'STARTED';
               $request->save(); 


                $data   = [ 
                    'provider_id'=>$request->provider_id,
                    'request_id'=>$request->id  
                  //  'created_at'=> \Carbon\Carbon::now(),
                   // 'updated_at'=> \Carbon\Carbon::now()
                ];


               \DB::table('request_filters')->insert($data);


               \Log::info("Cron is done it's job :) hamdollah !");
            }
        
        

    }
}
