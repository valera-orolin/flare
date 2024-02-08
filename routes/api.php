<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/*
Route::get('/suggested-users', [FollowController::class, 'suggestedUsers'])
    ->name('follows.suggested')
    ->middleware(['auth:sanctum']);;*/

Route::get('/suggested-users', [FollowController::class, 'suggestedUsers'])
    ->name('follows.suggested');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
