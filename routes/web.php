<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* START:Backend */
Route::group(['prefix' => admin_url(), 'namespace' => 'Backend', 'as'=>'backend.'], function () {

    /* Auth */
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    
    Route::get('refresh-captcha', 'Auth\LoginController@refreshCaptcha')->name('refresh-captcha');

    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['auth:backend']], function () {

        /* Account */
        Route::group(['prefix' => 'account', 'as'=>'account.'], function () {
            Route::get('/profile', 'ProfileController@viewProfile')->name('profile.view');
            Route::post('/profile/update', 'ProfileController@updateProfile')->name('profile.update');
            Route::post('/profile/remove-image/{id}', 'ProfileController@removeImage')->name('profile.remove-image');
            Route::get('change-password', 'ProfileController@viewChangePassword')->name('change-password.view');
            Route::post('change-password', 'ProfileController@saveChangePassword')->name('change-password.update');
        });
        
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('files/{path}/{filename}/{disk?}', 'DashboardController@getFile')->name('get-file');

        /* User management */
        Route::post('users/change-status/{id}', 'UserController@changeStatus')->name('users.change-status');
        Route::post('users/verify-kyc/{id}', 'UserController@verifyKYC')->name('users.verify-kyc');
        Route::resource('users', 'UserController');

        /* Search histories & results */
        Route::resource('search-histories', 'SearchHistoryController');
        
        Route::post('search-results/{id}/get-latest-data', 'SearchResultController@show')->name('search-results.get-latest-data');
        Route::resource('search-results', 'SearchResultController');

        /* Blockchain search histories and results */
        Route::resource('blockchain-searches', 'BlockchainSearchController');
        Route::resource('blockchain-search-histories', 'BlockchainSearchHistoryController');

        /* Plans */
        Route::resource('plans', 'PlanController');

        /* login logs */
        Route::group(['prefix' => 'auth-log', 'as'=>'auth-log.'], function () {

            Route::resource('admin', 'LoginLogController');
            Route::post('removeall-admin','LoginLogController@removeall')->name('removeall-admin');

            Route::resource('user', 'UserLoginLogController');
            Route::post('removeall-user','UserLoginLogController@removeall')->name('removeall-user');

        });        

        /* Plans */
        Route::resource('crypto-plans', 'CryptoPlanController');

        Route::post('crypto-plans-change-status', 'CryptoPlanController@changeStatus')->name('crypto-plans-change-status');

        /* User credits */
        Route::resource('user-credits', 'UserCreditController');

        /* Api services */
        Route::resource('api-services', 'ApiServiceController');

        /* Settings */
        Route::get('settings/{page}', 'SettingController@show')->name('settings.view');
        Route::post('settings/{page}/{key}', 'SettingController@update')->name('settings.update');

        
        /* login logs */
        Route::group(['prefix' => 'cms', 'as'=>'cms.'], function () {
         
            Route::get('edit-about-us/{id}','CmsController@editAboutus')->name('edit-about-us');

        });

        /* CMS */
        Route::resource('cms', 'CmsController');

        /* Partner */
        Route::resource('partners', 'PartnerController');

        /* SEO */
        Route::resource('seo', 'SeoController');
        
        /* Contact */
        Route::resource('contact', 'ContactController');
        Route::post('removeall-inquiry','ContactController@removeall')->name('removeall-inquiry');

        /* Flag */
        Route::resource('flag', 'BlockchainAddressReportController');

        /* Labels */
        Route::resource('labels', 'BlockchainAddressLabelController');

        /* Subscription */
        Route::resource('subscription', 'CryptoPlanSubscriptionController');

        /* Transaction */
        Route::resource('transaction', 'CryptoPlanTransactionController');


        Route::group(['prefix'=>'posts','as'=>'posts.'],function(){

            /*-- Blog Category --*/
            Route::resource('category', 'BlogCategoryController');

            /*-- Blog Tag --*/
            Route::resource('tag', 'BlogTagController');

            /* comment */
            Route::resource('comment', 'BlogRelatedCommentController');         

            Route::post('removeall-comment','BlogRelatedCommentController@removeall')->name('removeall-comment');

            Route::post('change_comment_status','BlogRelatedCommentController@changeStatus')->name('change_comment_status');

            /* newsletter-email */
            Route::resource('newsletter-email', 'NewsLetterController');    
            
            Route::post('removeall-newsletter-email','NewsLetterController@removeall')->name('removeall-newsletter-email');

            /*-- Blog View --*/
            Route::resource('view', 'PostViewController');

        });

        /* Faq */ 
        Route::resource('faq', 'FaqController');

        /* Ads */ 
        Route::resource('ads', 'AdsController');

        /* Blog */
        Route::resource('posts', 'PostController');
        Route::post('posts/restore/{id}', 'PostController@restore')->name('posts.restore');


        Route::get('subscription/upgrade/{id}', 'CryptoPlanSubscriptionController@upgrade')->name('subscription.upgrade');

        Route::get('subscription/downgrade/{id}', 'CryptoPlanSubscriptionController@downgrade')->name('subscription.downgrade');

        Route::post('subscription/upgrade/{id}', 'CryptoPlanSubscriptionController@change_plan')->name('subscription.upgrade');

        Route::post('subscription/downgrade/{id}', 'CryptoPlanSubscriptionController@change_plan')->name('subscription.downgrade');

        Route::get('subscription/renew/{id}', 'CryptoPlanSubscriptionController@renew')->name('subscription.renew');

        Route::post('check-plan-type', 'CryptoPlanSubscriptionController@check_plan_type')->name('check-plan-type');
        
        Route::post('crypto-subscription-change-status', 'CryptoPlanSubscriptionController@changeStatus')->name('crypto-subscription-change-status');

        /* Monitoring */
        Route::resource('crypto-monitoring', 'MonitorigController');
        
        Route::group(['prefix' =>'crypto-investigation','as'=>'investigation.'], function () {
            
            Route::get('/', 'InvestigationController@index')->name('index');

            Route::get('get-receiver-tree-graph', 'InvestigationController@getReceiverGraph')->name('get-receiver-tree-graph');

            Route::get('get-sender-tree-graph', 'InvestigationController@getSenderGraph')->name('get-sender-tree-graph');

            Route::get('get-receiver-common-txn', 'InvestigationController@getReceiverCommonTxn')->name('get-receiver-common-txn');

            Route::get('get-sender-common-txn', 'InvestigationController@getSenderCommonTxn')->name('get-sender-common-txn');

        });

        /* Known wallet addresses */
        Route::resource('wallet-addresses', 'WalletAddressController');

        /* telegram */
        Route::group(['prefix' =>'telegram','as'=>'telegram.'], function () {
        
        Route::resource('users', 'TelegramUserController');

        Route::resource('package', 'TelegramPackageController');

        Route::get('subscription', 'TelegramSubscriptionController@subscription')->name('subscription');

        Route::get('transaction', 'TelegramSubscriptionController@transaction')->name('transaction');

        Route::get('transaction/details/{id}', 'TelegramSubscriptionController@trsnsactionDetails')->name('transaction.details');
        });
    });

/* Monitoring public */

Route::post('send-verification-email','MonitorigController@sendVerifyEmail')->name('send-verification-email');

Route::post('verify-crypto-email','MonitorigController@verifyCriptoEmail')->name('verify-crypto-email');

Route::get('resend-email','MonitorigController@resendEmail')->name('resend-email');

Route::post('match-verification-code','MonitorigController@matchVerificationCode')->name('match-verification-code');

Route::post('crypto-monitoring-change-status','MonitorigController@changeStatus')->name('crypto-monitoring-change-status');

});
/* END:Backend */


/* START:Frontend */
Route::group(['namespace' => 'Frontend'], function () {

    /* Auth */
    Auth::routes(['verify' => true]);

    /* Web3 auth */
    Route::get('/web3-login-message', 'Auth\Web3LoginController@message');
    Route::post('/web3-login-verify', 'Auth\Web3LoginController@verify');

    /* Google Login */


    Route::get('/google/redirect', 'Auth\GoogleLoginController@redirectToGoogle')->name('google.redirect');

    Route::get('/google/callback', 'Auth\GoogleLoginController@handleGoogleCallback')->name('google.callback');


    Route::get('auth/facebook', 'Auth\GoogleLoginController@facebookRedirect')->name('facebook.redirect');

    Route::get('auth/facebook/callback', 'Auth\GoogleLoginController@loginWithFacebook')->name('facebook.callback');


    Route::get('auth/github', 'Auth\GoogleLoginController@redirectToGithub')->name('auth.github');

    Route::get('auth/github/callback', 'Auth\GoogleLoginController@handleGithubCallback')->name('auth.github.callback');




    Route::group(['as' => 'account.', 'middleware' => 'auth'], function () {
        Route::get('/account', 'AccountController@index')->name('index');
        Route::get('/profile', 'AccountController@viewProfile')->name('profile.view');
        Route::get('/subscription', 'AccountController@viewSubscription')->name('profile.subscription');
        Route::post('/profile/update', 'AccountController@updateProfile')->name('profile.update');
        Route::get('change-password', 'AccountController@viewChangePassword')->name('change-password.view');
        Route::post('change-password', 'AccountController@saveChangePassword')->name('change-password.update');

        Route::get('private-key', 'UserKeyController@index')->name('private-key');

        Route::post('change-private-key-status', 'UserKeyController@status')->name('change-private-key-status');

        Route::get('private-key/destroy/{id}', 'UserKeyController@destroy')->name('private-key.destroy');

        Route::get('create-user-key', 'UserKeyController@createUserKey')->name('create-user-key');
    });

    Route::get('is-authenticated', 'Auth\LoginController@isAuthenticated')->name('is-authenticated');

    Route::get('refresh-captcha', 'Auth\LoginController@refreshCaptcha')->name('refresh-captcha');

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('search', 'SearchController@index')->name('search.index');
    Route::post('search', 'SearchController@index')->name('search.submit');

    Route::get('history', 'SearchHistoryController@index')->name('history.index');
    Route::get('history/{id}', 'SearchHistoryController@show')->name('history.show');
    Route::post('history/{id}/get-latest-data', 'SearchHistoryController@show')->name('history.get-latest-data');

    Route::get('advance-search', 'SearchController@advanceSearch')->name('advance-search');

    Route::get('about-us', 'HomeController@aboutUs')->name('about-us');
    Route::get('pricing', 'HomeController@pricing')->name('pricing');
    Route::post('get-crypto-plan', 'HomeController@gatCryptoPricing')->name('get-crypto-plan');
    
    Route::get('threat-map', 'HomeController@threatMap')->name('threat-map');

    Route::get('/privacy-policy', 'HomeController@privacyPolicy')->name('privacy-policy');
    Route::get('/terms-of-service', 'HomeController@termsOfService')->name('terms-of-service');

    Route::get('/contact-us', 'ContactController@index')->name('contact-us');
    Route::post('/contact-us', 'ContactController@store')->name('contact-us');

    Route::get('/blockchain-analysis', 'BlockchainController@index')->name('blockchain-analysis');


    /*  Sitemap */

    Route::get('sitemap.xml','SitemapController@index');
    Route::get('pages/sitemap.xml', 'SitemapController@pages');
    Route::get('blog/sitemap.xml', 'SitemapController@blogSitemap');

    /* post */
    
    Route::get('blog', 'PostController@index')->name('blog.index');
    Route::get('blog/{slug}', 'PostController@details')->name('blog.details');
    Route::group(['prefix'=>'blog','as'=>'blog.'],function(){

        /*-- Blog Category --*/
        Route::get('category/{slug}', 'PostController@index')->name('blog-category');
        /*-- Blog Tag --*/
        Route::get('tag/{slug}', 'PostController@index')->name('blog-tag');

        Route::post('submit-user-comments', 'PostController@submitUserComments')->name('submit-user-comments');
        
        Route::post('capture_email','PostController@capture_email')->name('capture_email');
        
    });
    

    /* Blockchain search */
    Route::get('blockchain-search', 'BlockchainSearchController@index')->name('blockchain-search');
    Route::get('blockchain-search/network-graph', 'BlockchainSearchController@ajaxNetworkGraph')->name('blockchain-search.network-graph');
    Route::get('blockchain-search/blockcypher-txn-list', 'BlockchainSearchController@ajaxGetBlockcypherTxnList')->name('blockchain-search.blockcypher-txn-list');
    Route::get('blockchain-search/transaction-network-graph', 'BlockchainSearchController@ajaxTransactionNetworkGraph')->name('blockchain-search.transaction-network-graph');

    Route::get('blockchain-search-history', 'BlockchainSearchHistoryController@index')->name('blockchain-search-history.index');
    Route::get('blockchain-search-history/{id}/view', 'BlockchainSearchController@show')->name('blockchain-search-history.show');
    Route::get('blockchain-search/blockcypher-txn-details', 'BlockchainSearchController@getTxnDetails')->name('blockchain-search.blockcypher-txn-details');
    Route::post('flag', 'BlockchainSearchController@createAddressReport')->name('flag');
    Route::post('notes', 'BlockchainSearchController@createUserNote')->name('notes'); 
    Route::get('buy/subscription/{slug}', 'AccountController@buySubscription')->name('buy.subscription');

    /* Monitoring */
    
    Route::resource('monitoring', 'MonitoringController');

    Route::get('get-monitoring-table-data', 'MonitoringController@getTableData')->name('get-monitoring-table-data');

    Route::post('change-monitoring-status', 'MonitoringController@status')->name('change-monitoring-status');

    /* Favorite */

    Route::get('favorites', 'FavoriteController@index')->name('favorites');
    Route::get('get-favorite-data', 'FavoriteController@ajaxGetFavorite')->name('get-favorite-data');

    Route::resource('investigation', 'InvestigationController');

    Route::get('get-investigation-table-data', 'InvestigationController@getTableData')->name('get-investigation-table-data');

    Route::post('change-investigation-status', 'InvestigationController@status')->name('change-investigation-status');

    Route::group(['prefix' =>'investigations','as'=>'investigation.'], function () {

        Route::get('graph', 'InvestigationController@graph_index')->name('graph');
        
        Route::get('get-receiver-tree-graph', 'InvestigationController@getReceiverGraph')->name('get-receiver-tree-graph');

        Route::get('get-sender-tree-graph', 'InvestigationController@getSenderGraph')->name('get-sender-tree-graph');

        Route::get('get-receiver-common-txn', 'InvestigationController@getReceiverCommonTxn')->name('get-receiver-common-txn');

        Route::get('get-sender-common-txn', 'InvestigationController@getSenderCommonTxn')->name('get-sender-common-txn');
    });
    
    Route::get('alerts','InvestigationTxnHistoryController@index')->name('alerts');

    Route::get('get-alerts-table-data','InvestigationTxnHistoryController@getTableData')->name('get-alerts-table-data');
    
    Route::get('workspace','WorkspaceController@index')->name('workspace');


    Route::get('get-aml-report','BlockchainSearchController@get_aml_report')->name('get-aml-report');

    Route::get('crypto-analysis','WorkspaceController@oldCryptoAnalysis');

    Route::get(crypto_analysis_url(),'WorkspaceController@cryptoAnalysis')->name('crypto-analysis');

    /*payment Gateway */

    Route::get('purchase','SubscriptionController@purchase')->name('purchase');
    Route::post('subscribe','SubscriptionController@subscribe')->name('subscribe');
    
    
    Route::get('process-transaction', 'PayPalController@processTransaction')->name('process-transaction');

    // Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('success-transaction');

    // Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancel-transaction');


    Route::get('/checkout/{payment_gateway}/success/{txn_id?}', 'SubscriptionController@success')->name('checkout.success');

    Route::get('/checkout/{payment_gateway}/cancel', 'SubscriptionController@cancel')->name('checkout.cancel');

    Route::post('get-amount-summery', 'SubscriptionController@getAmountSummery')->name('get-amount-summery');


    /* Coinpayment */
    Route::post('get-converted-amount', 'CoinPaymentController@getConvertedAmount')->name('get-converted-amount');
    
    // Route::get('/coinpayment/ipn', 'CoinPaymentController@ipn')->name('coinpayment-ipn');
    Route::get('/coinpayment/checkout/{transaction_id}', 'CoinPaymentController@checkout')->name('coinpayment-checkout');

     /*  upgrade / downgrade / Renew user subscription */

    Route::get('change-subscription', 'SubscriptionController@changeUserSubscription')->name('change-subscription');

    Route::get('crypto-checkout',function(){
        return view('frontend.coinpayment-checkout');
    })->name('crypto-checkout');

    Route::get('download-alm-risk-report',function(){
        return view('frontend.account.alm-risk-report');
    })->name('download-alm-risk-report');

    Route::get('change-password-2',function(){
        return view('frontend.account.change-password-2');
    })->name('change-password-2');

    Route::get('edit-profile-2',function(){
        return view('frontend.account.edit-profile');
    })->name('edit-profile-2');

    Route::get('user-key',function(){
        return view('frontend.account.private-key-2');
    })->name('user-key');
    Route::get('user-subscription',function(){
        return view('frontend.account.user-subscription');
    })->name('user-subscription');

});
/* END:Frontend */

/* START:Frontend */
Route::group(['namespace' => 'Telegram'], function () {

    Route::post('{token}/webhook/telegram-bot', 'TelegramPackageController@getTelegramWebHookResponse');

});
