<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1','middleware'=>'authKey','throttle:3,10'], function () {
    
    Route::post('search-by-phone', 'SearchController@searchByPhone');
    Route::post('get-register-domains-by-email', 'SearchController@getRegisterDomainsByEmail');    
    Route::post('address-overview', 'CryptoSearchController@getAddressOverview');
    Route::post('risk-score', 'CryptoSearchController@getRiskScore');
    
    Route::post('address-labels', 'CryptoSearchController@getAddressLabels');    
    Route::post('user-favourits', 'CryptoSearchController@getUserFavourits');
    Route::post('address-profile-analysis', 'CryptoSearchController@getAddressProfileAnalysis');
    Route::post('address-details', 'CryptoSearchController@getAddressDetails');
    
});

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1'], function () {

Route::get('crypto-attackers', 'CryptoSearchController@getRandomCryptoAttacker');

});