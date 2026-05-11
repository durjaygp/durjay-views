<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dashboard Route Prefix
    |--------------------------------------------------------------------------
    | The URI prefix for all Durjay Views dashboard routes.
    | Default: "durjay-views"  →  accessible at /durjay-views/stats
    |
    */
    'path' => 'durjay-views',

    /*
    |--------------------------------------------------------------------------
    | Dashboard Middleware
    |--------------------------------------------------------------------------
    | Middleware applied to the dashboard route.
    |
    | Examples:
    |   ['web']              → public (no auth required)
    |   ['web', 'auth']      → logged-in users only
    |   ['web', 'auth', 'admin'] → admin-only (requires an 'admin' middleware)
    |
    */
    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Admin / Additional Middleware
    |--------------------------------------------------------------------------
    | Set this to true to automatically append the 'auth' middleware so only
    | authenticated users can view the dashboard.  Alternatively, list
    | explicit middleware strings in the 'middleware' key above.
    |
    */
    'require_auth' => false,

];
