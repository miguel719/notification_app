<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessagesController;
use Illuminate\Support\Facades\DB;

Route::post('/messages', [MessagesController::class, 'createMessage']);
Route::get('/messages/logs', [MessagesController::class, 'listMessageLogs']);

Route::get('/test', function (Request $request) {
   return DB::connection()->getDatabaseName();
});
