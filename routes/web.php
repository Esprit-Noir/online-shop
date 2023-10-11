<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function (){
    Route::group(['middleware' => 'admin.guest'], function (){
        Route::get('/login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.auth');

    });
    Route::group(['middleware' => 'admin.auth'], function (){
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.home');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
        Route::get('/categories/new', [CategoryController::class, 'create'])->name('admin.create-categories');
        Route::post('/categories/new', [CategoryController::class, 'store'])->name('admin.store-categories');

        Route::get('/getSlug', function(Request $request){
            $slug = '';
            if (!empty($request->title)){
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status'=> true,
                'slug'=> $slug
            ]);
        })->name('getSlug');
    });
});
