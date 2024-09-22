<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TelegramService;
use App\Models\BlockchainSearch;
use App\Models\BlockchainSearchResult;
use App\Libraries\Telegram\TelegramApp;
use App\Models\TelegramUser;
use App\Models\TelegramPackage;
use App\Models\TelegramSubscription;
use App\Models\TelegramTmpChat;
use App\Models\TelegramTransaction;
use App\Libraries\PaymentGateways\CoinPayment;
use \PsychoB\Ethereum\AddressValidator;

class TelegramCommends extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:message';

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
    	$this->coin_payment = new CoinPayment();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

    	
    }
}
