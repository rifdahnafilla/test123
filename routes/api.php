<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\AuthController;


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
// get all resource
Route::get('/patients', [PatientsController::class, 'index']);

// add resource
Route::post('/patients', [PatientsController::class, 'store']);

// edit resource
Route::put('/patients/{id}', [PatientsController::class, 'update']);

// delete resource
Route::delete('/patients/{id}', [PatientsController::class, 'destroy']);

// Search Resource
Route::get("/patients/search/{name}", [PatientsController::class, 'search']);
//apiresource
Route::apiResource('/patients', PatientsController::class);

// Get Positive Resource
Route::get("/patients/status/positive", [PatientsController::class, 'positive']);

// Get Recovered Resource
Route::get("/patients/status/recovered", [PatientsController::class, 'recovered']);

// Get Dead Resource
Route::get("/patients/status/dead", [PatientsController::class, 'dead']);

//Membuat route untuk register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/patients', [PatientsController::class, 'index'])->middleware('auth:sanctum');