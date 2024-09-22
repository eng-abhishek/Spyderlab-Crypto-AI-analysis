<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TempSearch;
use App\Models\SearchResult;


class InsertContactNoDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert-contact-details:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert contact details';

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
        set_time_limit(0);
        ini_set('memory_limit', '1G');

        \Log::info('START : Insert Contact details cron');

        try{
            \DB::beginTransaction();

            foreach (\App\Models\TempSearch::cursor() as $key => $value){

                \App\Models\SearchResult::insert([
                    'search_key' => 'phone',
                    'country_code' => 'In',
                    'search_value' => $value->mobile,
                    'result' => json_encode([
                        'names' => array($value->name),
                        'emails' => array($value->email),
                        'addresses' => array($value->city , $value->state, $value->country),
                    ]),
                    'status_code' => 200,
                    'message' => 'Record get successfully.',
                    'record_type' => 'manual_entry',
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);

            }

            //TempSearch::truncate();

            \Log::success('END : Insert Contact details cron');

            \DB::commit();

        }catch(\Exception $e){
           \Log::error('Cron - Fail to Add Contact Number Details : '.$e->getMessage());
           \DB::rollback();
       }

   }
}
