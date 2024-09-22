<?php

return [
    // 'stripe_key' => 'pk_test_1uuAgvJHgo8l32uH2oMxOKF7', // This is load from db
    // 'stripe_secret' => 'sk_test_51Dn1uREwrDn2ITSjGgHsHoNqcakm5RmdY9CErx3jVC7HQ71Sw4UBWqjVGA5WQ62RqpRK4X5zT1IkJiEKCrj4eECj00bOWHczLe', // This is load from db

    'stripe_key' => env('STRIPE_KEY', ''), // This is load from db
    'stripe_secret' => env('STRIPE_SECRET', ''), // This is load from db    
];