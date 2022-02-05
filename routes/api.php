<?php

use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [\App\Http\Controllers\AuthController::class,"login"]);
    Route::post('logout', [\App\Http\Controllers\AuthController::class,"logout"]);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class,"refresh"]);
    Route::post('me', [\App\Http\Controllers\AuthController::class,"me"]);
});

Route::group([
    'middleware' => ['api','auth:api'],
    "prefix" => "alunos"
], function ($router) {
    Route::get("/", [\App\Http\Controllers\AlunoController::class, "index"])->name("alunos.index");
    Route::get("/{idAluno}", [\App\Http\Controllers\AlunoController::class, "show"])->name("alunos.show");
    Route::put("/{idAluno}", [\App\Http\Controllers\AlunoController::class, "update"])->name("alunos.update");
    Route::delete("/{idAluno}", [\App\Http\Controllers\AlunoController::class, "delete"])->name("alunos.delete");
    Route::post("/", [\App\Http\Controllers\AlunoController::class, "store"])->name("alunos.store");
});

Route::group([
    'middleware' => ['api','auth:api'],
    "prefix" => "planos"
], function ($router) {
    Route::get("/", [\App\Http\Controllers\PlanoController::class, "index"])->name("planos.index");
    Route::get("/{idPlano}", [\App\Http\Controllers\PlanoController::class, "show"])->name("planos.show");
    Route::put("/{idPlano}", [\App\Http\Controllers\PlanoController::class, "update"])->name("planos.update");
    Route::delete("/{idPlano}", [\App\Http\Controllers\PlanoController::class, "delete"])->name("planos.delete");
    Route::post("/", [\App\Http\Controllers\PlanoController::class, "store"])->name("planos.store");
});

Route::group([
    'middleware' => ['api','auth:api'],
    "prefix" => "matriculas"
], function ($router) {
    Route::get("/", [\App\Http\Controllers\MatriculaController::class, "index"])->name("matriculas.index");
    Route::get("/{idPlano}", [\App\Http\Controllers\MatriculaController::class, "show"])->name("matriculas.show");
    Route::put("/{idPlano}", [\App\Http\Controllers\MatriculaController::class, "update"])->name("matriculas.update");
    Route::delete("/{idPlano}", [\App\Http\Controllers\MatriculaController::class, "delete"])->name("matriculas.delete");
    Route::post("/", [\App\Http\Controllers\MatriculaController::class, "store"])->name("matriculas.store");
});
