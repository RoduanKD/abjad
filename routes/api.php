<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [LoginController::class, 'login']);
Route::post('/detect-character', function (Request $request) {
    $request->validate([
        'file' => 'required|file|mimes:wav'
    ]);

    $file = $request->file('file');

    $res = Http::attach('file', file_get_contents($file), 'test.wav')->post(env('PYTHON_HOST'));

    if ($res->body() === 'ظ') {
        return 'bravo';
    }

    return 'try again!';
});
