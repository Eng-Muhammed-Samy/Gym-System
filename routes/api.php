<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymMembersController;
// use Google\Service\Storage;
// use Illuminate\Filesystem\FilesystemManager as Storage;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// gym member routes
Route::prefix('/gym-members')->group(function () {
    Route::get('/', [GymMembersController::class, 'index']);
    Route::post('/store', [GymMembersController::class, 'store']);
    Route::post('/{id}/update', [GymMembersController::class, 'update']);
    Route::delete('/{id}/delete', [GymMembersController::class, 'destroy']);

});
