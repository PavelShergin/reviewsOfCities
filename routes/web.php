<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/createreview', [\App\Http\Controllers\StoreReviewController::class, 'storeReview'])->name('store_review');
    Route::get('/add_review', [\App\Http\Controllers\AddReviewController::class, 'addReview'])->name('add_review');

    Route::get('profile/{id}', [\App\Http\Controllers\ProfileController::class, 'profile'])->name('profile');
    Route::get('reviews/user/{id}', [\App\Http\Controllers\ProfileReviewsController::class, 'profileReviews'])->name('profile_reviews');
});
Route::get('/logout', [\App\Http\Controllers\DestroyUserController::class, 'destroy'])->name('logout')->middleware('auth');
Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'welcome'])->name('welcome');
Route::get('/citys', [\App\Http\Controllers\ShowController::class, 'show'])->name('index');
Route::get('/reviews', [\App\Http\Controllers\ReviewsController::class, 'reviews'])->name('all_reviews');
Route::get('/reviews/{id}', [\App\Http\Controllers\ReviewsCityController::class, 'reviews_city'])->name('reviews_name');

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [\App\Http\Controllers\RegistrationController::class, 'registration'])->name('register');
    Route::post('/register', [\App\Http\Controllers\CreateUserController::class, 'createUser'])->name('create_user');
    Route::get('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\SignInControllers::class, 'signIn'])->name('signIn');
});

Route::get('/reload-captcha', [\App\Http\Controllers\ReloadCaptcha::class, 'reloadCaptcha']);


Route::post('/savesession', [\App\Http\Controllers\SessionController::class, 'session'])->name('sessions');

Route::middleware(['verified', 'auth'])->group(function () {
    Route::get('/edit_review/{review}', [\App\Http\Controllers\EditController::class, 'edit'])->name('edit_review');
    Route::post('/edit_review/{review}', [\App\Http\Controllers\UpdateController::class, 'update'])->name('update');
    Route::delete('/delete/{review}', [\App\Http\Controllers\DestroyController::class, 'destroy'])->name('delete');
});


Route::get('/email/verify', function () {
    return view('verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {

    $request->fulfill();

    return redirect('/');
})->middleware(['auth'])->name('verification.verify');
