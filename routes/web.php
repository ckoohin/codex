<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [SurveyController::class,'index'])->name('survey.index');
    Route::post('/survey/scores', [ResponseController::class,'storeScores'])->name('survey.scores.store');
    Route::post('/survey/responses', [ResponseController::class,'storeResponses'])->name('survey.responses.store');
    Route::post('/survey/submit', [SurveyController::class,'submit'])->name('survey.submit');
    Route::get('/recommendations/{survey}', [RecommendationController::class,'show'])->name('recommendations.show');
  });
  
  Route::middleware(['auth','can:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
      Route::resource('majors', Admin\MajorController::class);
      Route::resource('questions', Admin\QuestionController::class);
      Route::resource('subjects', Admin\SubjectController::class);
  });
require __DIR__.'/auth.php';
