<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QuestionsController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login-post');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
Route::get('/register',[RegisterController::class, 'index'])->name('register');
Route::post('/register',[RegisterController::class, 'store']);


Route::get('/', [QuestionsController::class, 'index'])->name('index');



//  Trong middleware
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionsController')->except('show', 'index');
Route::post('/questions/{question}/answers', [AnswersController::class, 'store'])->name('answers.store');
Route::resource('questions.answers', 'AnswersController')->except(['create', 'show', 'index']);
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

Route::post('/questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');

Route::post('/questions/{question}/vote', 'VoteQuestionController');
Route::post('/answers/{answer}/vote', 'VoteAnswerController');



// Ngoai middleware
// Route::get('/questions/{question}/answers', [AnswersController::class, 'index'])->name('questions.answers.index');
Route::get('/questions/{slug}', [QuestionsController::class, 'show'])->name('questions.show');
Route::get('/questions', [QuestionsController::class, 'index'])->name('questions.index');

Route::post('test', function (Request $request){
    dd('ok');
});
