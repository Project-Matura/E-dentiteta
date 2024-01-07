<?php

use App\Http\Controllers\AddOrganisationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AddCardController;
use App\Http\Controllers\AddUserController;
use App\Http\Controllers\AddUserCardController;
use App\Http\Controllers\OrganisationCardsController;
use App\Http\Controllers\AddUserOrganisationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layout');
})->name('home');
/**
 * Route for logout
 */
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
/**
 * Routes for login
 */
Route::group(['middleware' => 'login'], function () {
    Route::get('/login', [LoginController::class, 'getLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'postLogin'])->name('login.create');
});
/**
 * Routes for register
 */
Route::group(['middleware' => 'register'], function () {
    Route::get('/register', [RegisterController::class, 'getRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'postRegister'])->name('register.create');
});
/**
 * Routes for admin
 */
Route::group(['middleware' => 'ADM'], function () {

    Route::prefix('admin')->group(function (){
        /**
         * Routes for admin profile
         */
        Route::prefix('/profile')->group(function (){
            Route::get('/edit', [ProfileController::class, 'getProfileAdmin'])->name('admin.profile');
            Route::post('/edit', [ProfileController::class, 'postProfileAdmin'])->name('admin.profile.update');
            Route::put('/edit', [ProfileController::class, 'postProfileAdmin'])->name('admin.profile.update');
        });
        Route::prefix('/organisations')->group(function (){
            Route::get('/', [AddOrganisationController::class, 'getOrganisations'])->name('admin.organisations');
            Route::get('/edit/{organisationId}', [AddOrganisationController::class, 'getOrganisation'])->name('admin.organisation');
            Route::post('/edit/{organisationId}', [AddOrganisationController::class, 'postOrganisation'])->name('admin.organisation.update');
            Route::put('/edit/{organisationId}', [AddOrganisationController::class, 'postOrganisation'])->name('admin.organisation.update');
            Route::get('/add', [AddOrganisationController::class, 'getAddOrganisation'])->name('admin.organisation.add');
            Route::post('/add', [AddOrganisationController::class, 'postAddOrganisation'])->name('admin.organisation.create');
            Route::put('/add', [AddOrganisationController::class, 'postAddOrganisation'])->name('admin.organisation.create');
            Route::delete('/delete/{organisationId}', [AddOrganisationController::class, 'deleteOrganisation'])->name('admin.organisation.delete');
        });
        Route::prefix('/cards')->group(function (){
            Route::get('/', [AddCardController::class, 'getCards'])->name('admin.cards');
            Route::get('/edit/{cardId}', [AddCardController::class, 'getCard'])->name('admin.card');
            Route::post('/edit/{cardId}', [AddCardController::class, 'postCard'])->name('admin.card.update');
            Route::put('/edit/{cardId}', [AddCardController::class, 'postCard'])->name('admin.card.update');
            Route::get('/add', [AddCardController::class, 'getAddCard'])->name('admin.card.add');
            Route::post('/add', [AddCardController::class, 'postAddCard'])->name('admin.card.create');
            Route::put('/add', [AddCardController::class, 'postAddCard'])->name('admin.card.create');
            Route::delete('/delete/{cardId}', [AddCardController::class, 'deleteCard'])->name('admin.card.delete');
        });
        Route::prefix('/users')->group(function (){
            Route::get('/', [AddUserController::class, 'getUsers'])->name('admin.users');
            Route::get('/edit/{userId}', [AddUserController::class, 'getUser'])->name('admin.user');
            Route::post('/edit/{userId}', [AddUserController::class, 'postUser'])->name('admin.user.update');
            Route::put('/edit/{userId}', [AddUserController::class, 'postUser'])->name('admin.user.update');
            Route::get('/add', [AddUserController::class, 'getAddUser'])->name('admin.user.add');
            Route::post('/add', [AddUserController::class, 'postAddUser'])->name('admin.user.create');
            Route::put('/add', [AddUserController::class, 'postAddUser'])->name('admin.user.create');
            Route::delete('/delete/{userId}', [AddUserController::class, 'deleteUser'])->name('admin.user.delete');
        });

    });
});
/**
 * Routes for organisation
 */
Route::group(['middleware' => 'ORG'], function () {

    Route::prefix('organisation')->group(function (){
        /**
         * Routes for organisation profile
         */
        Route::prefix('/profile')->group(function (){
            Route::get('/edit', [ProfileController::class, 'getProfileOrganisation'])->name('organisation.profile');
            Route::post('/edit', [ProfileController::class, 'postProfileOrganisation'])->name('organisation.profile.update');
            Route::put('/edit', [ProfileController::class, 'postProfileOrganisation'])->name('organisation.profile.update');
        });
        //TODO: Add routes for cards check
        Route::prefix('/cards')->group(function(){
            Route::get('/', [OrganisationCardsController::class, 'getCards'])->name('organisation.cards');
            Route::get('/edit/{cardId}', [OrganisationCardsController::class, 'getCard'])->name('organisation.card');
            Route::post('/edit/{cardId}', [OrganisationCardsController::class, 'postCard'])->name('organisation.card.update');
            Route::put('/edit/{cardId}', [OrganisationCardsController::class, 'postCard'])->name('organisation.card.update');
            Route::get('/add', [OrganisationCardsController::class, 'getAddCard'])->name('organisation.card.add');
            Route::post('/add', [OrganisationCardsController::class, 'postAddCard'])->name('organisation.card.create');
            Route::put('/add', [OrganisationCardsController::class, 'postAddCard'])->name('organisation.card.create');
            Route::get('/approve', [OrganisationCardsController::class, 'getApproveCards'])->name('organisation.card.approve');
            Route::post('/approve/{requestId}', [OrganisationCardsController::class, 'getApproveCard'])->name('organisation.card.approve.card');
            Route::put('/approve/{requestId}', [OrganisationCardsController::class, 'getApproveCard'])->name('organisation.card.approve.card');
            Route::post('/decline/{requestId}', [OrganisationCardsController::class, 'getDeclineCard'])->name('organisation.card.decline.card');
            Route::put('/decline/{requestId}', [OrganisationCardsController::class, 'getDeclineCard'])->name('organisation.card.decline.card');
            Route::delete('/delete/{cardId}', [OrganisationCardsController::class, 'deleteCard'])->name('organisation.card.delete');
        });
        Route::prefix('/users')->group(function (){
            Route::get('/', [AddUserOrganisationController::class, 'getUsers'])->name('organisation.users');
            Route::get('/add', [AddUserOrganisationController::class, 'getAddUser'])->name('organisation.user.add');;
            Route::post('/add/{userId}', [AddUserOrganisationController::class, 'postAddUser'])->name('organisation.user.add.create');
            Route::put('/add/{userId}', [AddUserOrganisationController::class, 'postAddUser'])->name('organisation.user.add.create');
            Route::delete('/delete/{userId}', [AddUserOrganisationController::class, 'deleteUser'])->name('organisation.user.delete');
        });
    });
});
/**
 * Routes for user
 */
Route::group(['middleware' => 'USR'], function () {

    Route::prefix('user')->group(function (){
        /**
         * Routes for user profile
         */
        Route::prefix('/profile')->group(function (){
            Route::get('/edit', [ProfileController::class, 'getProfileUser'])->name('user.profile');
            Route::post('/edit', [ProfileController::class, 'postProfileUser'])->name('user.profile.update');
            Route::put('/edit', [ProfileController::class, 'postProfileUser'])->name('user.profile.update');
        });
        //TODO: Add routes for cards(show,join)
        Route::prefix('/cards')->group(function (){
            Route::get('/', [AddUserCardController::class, 'getCards'])->name('user.cards');
            Route::get('/card/{cardId}', [AddUserCardController::class, 'getCard'])->name('user.card');
            Route::post('/card/{cardId}', [AddUserCardController::class, 'postCard'])->name('user.card.update');
            Route::put('/card/{cardId}', [AddUserCardController::class, 'postCard'])->name('user.card.update');
            Route::get('/join', [AddUserCardController::class, 'getAddCard'])->name('user.card.join');
            Route::post('/join/{cardId}', [AddUserCardController::class, 'postAddCard'])->name('user.card.create');
            Route::put('/join/{cardId}', [AddUserCardController::class, 'postAddCard'])->name('user.card.create');
            Route::delete('/delete/{cardId}', [AddUserCardController::class, 'deleteCard'])->name('user.card.delete');
        });
    });
});
