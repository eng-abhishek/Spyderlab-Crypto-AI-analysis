<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;

class HaveIBeenPwned
{
    /**
     * Get/Check account is pwned or not with data.
     *
     * @param  string  $account
     * @return array
     */
    public function checkBreachedAccount($account){

        $api_url = 'https://haveibeenpwned.com/api/v3/breachedaccount/'.$account;

        // $headers = [
        //     'hibp-api-key' => config('constants.HIBP_API_KEY')
        // ];

        $hibp_credentials = app('api_services')['have-i-been-pwned'];
        $apikey = $hibp_credentials['apikey'] ?? '';

        $headers = [
            'hibp-api-key' => $apikey
        ];

        try {

            $response = Http::withHeaders($headers)->get($api_url);

            $data = ['status_code' => $response->status(), 'breached' => false, 'records' => null];
            if($response->status() == 200 && !is_null($response->body())){
                $data['breached'] = true;
                $data['records'] = $response->body();
            }

            //Get Success Response
            return (object) $data;

        } catch (\Exception $e) {
            //Get Error Response
            return (object) ['status_code' => 500, 'breached' => false, 'records' => null];
        }
    }

    /**
     * Search by the given password and returns all occurrences of leaked passwords.
     *
     * @param  string  $password
     * @return array
     */
    public function CheckPwnedPassword($password){

        /* Hash and split password before api call*/
        $hash = strtoupper(sha1($password));
        $prefix = substr($hash, 0, 5);
        $suffix = substr($hash, 5);

        $api_url = 'https://api.pwnedpasswords.com/range/'.$prefix;

        $headers = [
            'Add-Padding' => true
        ];

        try {

            $response = Http::withHeaders($headers)->get($api_url);

            $data = ['pwned' => false, 'count' => 0];
            if($response->status() == 200 && !is_null($response->body())){
                $hashes = explode("\n", trim($response->body()));

                $result = (collect($hashes))
                ->mapWithKeys(function ($value) {
                    $pair = explode(':', trim($value), 2);

                    return count($pair) === 2 && is_numeric($pair[1])
                        ? [$pair[0] => $pair[1]]
                        : [];
                });

                $count = $result[$suffix] ?? 0;
                $pwned = $count > 0;

                $data['pwned'] = $pwned;
                $data['count'] = $count;
            }


            //Get Success Response
            return (object) $data;

        } catch (\Exception $e) {
            //Get Error Response
            return (object) ['pwned' => false, 'count' => 0];
        }
    }
}