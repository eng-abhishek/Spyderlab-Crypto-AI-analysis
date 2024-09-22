<?php

namespace App\Listeners;

use App\Events\Search;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\SearchHistory;
use App\Models\SearchResult;

class SaveHistory
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
    public function handle(Search $event)
    {
        $user_id = $event->result['user_id'];
        $request_ip = $event->result['request_ip'];
        $user_agent = $event->result['user_agent'];
        $search_result_id = $event->result['search_result_id'];

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
        SearchHistory::create([
            'search_result_id' => $search_result_id,
            'user_id' => $user_id,
            'ip_address' => $request_ip,
            'user_agent' => $user_agent,
            'location' => $location
        ]);
    }
}
