<?php

namespace App\Listeners;

use App\Events\BlockchainSearch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\BlockchainSearchHistory;
use App\Models\BlockchainSearchResult;

class SaveBlockchainHistory
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Search  $event
     * @return void
     */
    public function handle(BlockchainSearch $event)
    {
        $user_id = $event->result['user_id'];
        $request_ip = $event->result['request_ip'];
        $user_agent = $event->result['user_agent'];
        $search_id = $event->result['search_id'];
        $user_type = $event->result['user_type'];

        //get visitor's location
        $location = null;
        $visitor_details = get_visitor_details($request_ip);
        if($visitor_details){
            $location = json_encode([
                'city' => $visitor_details['city'],
                'state' => $visitor_details['state'],
                'country' => $visitor_details['country'],
            ]);
        }

        //Save history
        BlockchainSearchHistory::create([
            'search_id' => $search_id,
            'user_id' => $user_id,
            'user_type' => $user_type,
            'ip_address' => $request_ip,
            'user_agent' => $user_agent,
            'location' => $location
        ]);
    }
}
