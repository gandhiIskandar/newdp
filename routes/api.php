<?php

use App\Models\Whitelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/addWhiteList', function (Request $request) {

    $email = $request->email;
    $password = $request->password;

    $user = Auth::attempt([
        'email' => $email,
        'password' => $password,
    ]);

    if ($user && Auth::user()->role_id == 4) {

        Whitelist::create([
            'ip_address' => $request->ip,
        ]);

        return 'berhasil tambah ip whitelist';

    } else {
        return response('Forbidden', Response::HTTP_FORBIDDEN);
    }

});
