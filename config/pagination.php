return [

'default' => env('PAGINATION_DRIVER', 'bootstrap-5'),

'views' => [
    'default' => 'vendor.pagination.default',
    'simple' => 'vendor.pagination.simple-default',
    'bootstrap-4' => 'vendor.pagination.bootstrap-4',
    'bootstrap-5' => 'vendor.pagination.bootstrap-5',
],
];
