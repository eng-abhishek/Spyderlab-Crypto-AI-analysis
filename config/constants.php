<?php

return [

    'status' => ['Y' => 'Active', 'N' => 'In-Active'],

    /* haveibeenpwned api key */
    'HIBP_API_KEY' => '4d88b34161e74e0aa941ec683ce062ca',

    /* Settings */
    'settings' => ['general'],

    /* Blockcypher */

    'blockcypher' => [
        'amount' => [
            'btc' => 100000000, // 1 btc = 100000000 sats
            'eth' => 1000000000000000000, // 1 eth = 1000000000000000000 wei
        ],
        'address_txn_limit' => 1000 // Get address records if transactions count is less than address_txn_limit
    ],

    'available_coins' => [
        'btc' => 'Bitcoin',
        'eth' => 'Ethereum'
    ],
    
    'post' => [
        'status' => ['Pending' => 'Pending', 'Draft' => 'Draft', 'Publish' => 'Publish'],
    ],

    'coinpayment' => [
        'public_key' => '650cc71a9063938c45520e087da378d918a79807be754bb866e24fdc51211257',
        'private_key' => '7d6aF85Ebe0e82c6ed600636D585150B432db605018F6C12945ddA77a102472B',
        'merchant_id' => '4fef9fea1cfba3f3162f9fed6d0efde3',
        'ipn_secret' => 'thisistesingipnforrankermail',
        'ipn_debug_email' => 'jigneshpatterndrive@gmail.com'
    ],

    'telegram_custom_amount' => 3, // in usd 
];