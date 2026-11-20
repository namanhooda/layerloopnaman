<?php

return [
    'contract_prefix' => env('CONTRACT_NUMBER_PREFIX', 'LL-CON'),
    'storage_disk' => env('CONTRACT_STORAGE_DISK', 'local'),
    'product_model' => App\Models\Product::class,
    'product_name_column' => 'name',
    'product_code_column' => 'sku',
    'expiry_reminder_days' => [30, 15, 7],
    'business_units' => [
        '3d_printing' => 'LayerLoop 3D Printing',
        'clothing' => 'LayerLoop Clothing',
        'cafe' => 'LayerLoop Cafe',
        'gaming' => 'LayerLoop Gaming',
        'group' => 'LayerLoop Group',
    ],
];
