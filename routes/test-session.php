<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-session', function () {
    session(['test_key' => 'test_value']);
    return 'Session set. <a href="/test-session-check">Check session</a>';
});

Route::get('/test-session-check', function () {
    return 'Session value: ' . session('test_key', 'Not found');
});
