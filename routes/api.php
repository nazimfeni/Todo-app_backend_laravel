<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::options('/{any}', function (Request $request) {
    return response()->json(['status' => 'success'], 200);
})->where('any', '.*');

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);

Route::post('/tasks/{id}/complete', [TaskController::class, 'markAsCompleted']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

