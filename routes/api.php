<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

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

// * Public Routes
//Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users/{user}', [AuthController::class, 'fetchUser']);

//Recipes
Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/{recipe}', [RecipeController::class, 'show']);

//Comments
Route::get('/recipes/{recipe}/comments', [CommentController::class, 'index']);
Route::get('/comments/{comment}/replies', [CommentController::class, 'fetchReplies']);

//Ratings
Route::get('/recipes/{recipe}/ratings', [RatingController::class, 'index']);
Route::get('/users/{user}/ratings', [RatingController::class, 'fetchRatingsCreatedByUser']);

// * Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {    
    //Auth
    Route::get('/user/current', [AuthController::class, 'fetchCurrentUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    //Comments
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store']);
    
    //Recipes
    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::put('/recipes', [RecipeController::class, 'update']);
    Route::delete('/recipes', [RecipeController::class, 'destroy']);

    //Ratings
    Route::post('/recipes/{recipe}/ratings', [RatingController::class, 'store']);
});