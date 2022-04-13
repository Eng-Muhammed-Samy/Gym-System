<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymMembersController;
// use Google\Service\Storage;
// use Illuminate\Filesystem\FilesystemManager as Storage;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\CoachController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\GymManagerController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\BanController;
use App\Http\Controllers\Api\CityMangerController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Api\UserController;

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
Auth::routes(['register' => false]);
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
//cityManager routes
Route::resource('bans', BanController::class);
Route::resource('users',UserController::class);
Route::resource('citymanagers',CityMangerController::class)->except(['update']);
Route::post('citymanagers/{id}/update',[CityMangerController::class,'update']);
//Gym manager routes
Route::resource('sessions', SessionController::class);
Route::resource('coaches', CoachController::class);
Route::resource('packages', PackageController::class);
Route::resource('gymmanagers', GymManagerController::class)->except(['update']);
Route::post('gymmanagers/{id}/update',[GymManagerController::class,'update']);
Route::resource('attendances', AttendanceController::class);

//Payment gateway routes
Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
Route::post('stripe/customer', [StripeController::class, 'createCustomer'])->name('stripe.customer');
Route::post('stripe/charge', [StripeController::class, 'createCharge'])->name('stripe.charge');
Route::post('stripe/createRefund', [StripeController::class, 'createRefund'])->name('stripe.refund');
Route::post('stripe/createInvoice', [StripeController::class, 'createInvoice'])->name('stripe.invoice');
Route::post('stripe/createSubscription', [StripeController::class, 'createSubscription'])->name('stripe.subscription');
Route::post('stripe/createPaymentMethod', [StripeController::class, 'createPaymentMethod'])->name('stripe.paymentMethod');


Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return $user->createToken($request->device_name)->plainTextToken;
});