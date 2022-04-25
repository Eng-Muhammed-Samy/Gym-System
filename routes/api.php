<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymMembersController;
use App\Http\Controllers\AuthController;
// use Google\Service\Storage;
// use Illuminate\Filesystem\FilesystemManager as Storage;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\CoachController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\GymManagerController;
use App\Http\Controllers\Api\GymController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\BanController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CityMangerController;
use App\Http\Controllers\Api\StripeOperationController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Api\UserController;
use App\Models\City;

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

Route::group(['prefix'=>'/gym-members','middleware'=>'auth:sanctum','middleware'=>'atLeastCityManager'],function () { 
// gym member routes
    Route::get('/', [GymMembersController::class, 'index']);
    Route::post('/store', [GymMembersController::class, 'store']);
    Route::post('/{id}/update', [GymMembersController::class, 'update']);
    Route::delete('/{id}/delete', [GymMembersController::class, 'destroy']);
});
//cityManager routes
Route::resource('bans', BanController::class);
Route::resource('users',UserController::class);


Route::group(['middleware'=>'auth:sanctum','middleware'=>'atLeastAdmin'],function () { 

    Route::resource('citymanagers',CityMangerController::class)->except(['update']);
    Route::post('citymanagers/{id}/update',[CityMangerController::class,'update']);
    Route::get('cities-without-manager',[CityController::class,'withoutManager']);
    Route::resource('cities',CityController::class)->except(['update']);
    Route::post('citymanagers/{id}/update',[CityMangerController::class,'update']);
    Route::post('cities/{id}/update',[CityController::class,'update']);

});



Route::group(['middleware'=>'auth:sanctum','middleware'=>'atLeastCityManager'],function () { 

    Route::resource('gymmanagers', GymManagerController::class)->except(['update']);
    Route::post('gymmanagers/{id}/update',[GymManagerController::class,'update']);
    Route::resource('gyms', GymController::class);
    Route::post('gyms/{id}/update',[GymController::class,'update']);

});


Route::group(['middleware'=>'auth:sanctum','middleware'=>'atLeastGymManager'],function () { 

    Route::resource('sessions', SessionController::class);
    Route::post('sessions/{id}/update',[SessionController::class,'update']);
    Route::resource('coaches', CoachController::class);
    Route::post('coaches/{id}/update',[CoachController::class,'update']);
    Route::resource('packages', PackageController::class);
    Route::resource('attendances', AttendanceController::class);

});

// Route::resource('users',UserController::class);
Route::resource('citymanagers',CityMangerController::class)->except(['update']);
Route::post('citymanagers/{id}/update',[CityMangerController::class,'update']);
Route::get('cities-without-manager',[CityController::class,'withoutManager']);
Route::resource('cities',CityController::class)->except(['update']);
Route::post('citymanagers/{id}/update',[CityMangerController::class,'update']);
Route::post('cities/{id}/update',[CityController::class,'update']);

//Gym manager routes
Route::resource('sessions', SessionController::class);
Route::post('sessions/{id}/update',[SessionController::class,'update']);
Route::resource('coaches', CoachController::class);
Route::post('coaches/{id}/update',[CoachController::class,'update']);
Route::resource('packages', PackageController::class);
Route::post('packages/{id}/update',[CoachController::class,'update']);
Route::resource('gymmanagers', GymManagerController::class)->except(['update']);
Route::get('gymmanagers-withoutGyms', [GymManagerController::class,'withoutGyms']);
Route::post('gymmanagers/{id}/update',[GymManagerController::class,'update']);


//StripeOperation routes
Route::resource('stripe/operation',StripeOperationController::class)->except(['update']);
Route::get('stripe/operation/{id}/update',[StripeOperationController::class,'update']);
Route::get('stripe/operationformat',[StripeOperationController::class,'stripeFormat']);

//Attendances routes
Route::resource('attendances', AttendanceController::class)->except(['update']);;
Route::get('attendancesformat', [AttendanceController::class,'AttendanceFormat']);

//Gym Route
Route::resource('gyms', GymController::class);
Route::post('gyms/{id}/update',[GymController::class,'update']);
Route::post('gym-remove-manager',[GymController::class,'removeManager']);
Route::post('gym-add-manager',[GymController::class,'addManager']);

//Payment gateway routes
Route::post('stripe/token', [StripeController::class, 'stripePost'])->name('stripe.post');
Route::post('stripe/customer', [StripeController::class, 'createCustomer'])->name('stripe.customer');
Route::post('stripe/charge', [StripeController::class, 'createCharge'])->name('stripe.charge');
Route::post('stripe/createRefund', [StripeController::class, 'createRefund'])->name('stripe.refund');
Route::post('stripe/createInvoice', [StripeController::class, 'createInvoice'])->name('stripe.invoice');
Route::post('stripe/createSubscription', [StripeController::class, 'createSubscription'])->name('stripe.subscription');
Route::post('stripe/createPaymentMethod', [StripeController::class, 'createPaymentMethod'])->name('stripe.paymentMethod');



Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
