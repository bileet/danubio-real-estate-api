<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Return a not found status until adding a home page.
    abort(404);
});
