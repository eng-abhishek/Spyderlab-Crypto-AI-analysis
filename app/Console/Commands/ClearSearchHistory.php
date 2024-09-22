<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SearchHistory;
use App\Models\BlockchainSearchHistory;
use App\Models\InvestigationTxnHistory;

class ClearSearchHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search-history:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear search history';

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
        try{

            /* Clear Search history 30 day old */
            SearchHistory::whereRaw('created_at < NOW() - INTERVAL 30 DAY')->delete();

            /* Clear Investigation history 30 day old */
            InvestigationTxnHistory::whereRaw('created_at < NOW() - INTERVAL 30 DAY')->delete();

            /* Clear Blockchain Search history 30 day old */
            BlockchainSearchHistory::whereRaw('created_at < NOW() - INTERVAL 30 DAY')->delete();

            \Log::info('Cron - Search History: Search history cleared successfully.');
        } catch (\Exception $e) {
            \Log::error('Cron - Search History: '.$e->getMessage());
        }
    }
}
