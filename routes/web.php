<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Front\AuthorController;
use App\Http\Controllers\Front\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
//Frontend
Route::get('/',[FrontendController::class,'index'])->name('index');
Route::get('/author/login/page',[FrontendController::class,'author_login_page'])->name('author.login.page');
Route::get('/author/register/page',[FrontendController::class,'author_register_page'])->name('author.register.page');

//Backend
Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//users
Route::get('/users',[AdminController::class,'users'])->middleware('auth')->name('users');
Route::post('/add-user',[AdminController::class,'store'])->name('user.store');
Route::get('/edit-profile',[AdminController::class,'editProfile'])->middleware('auth')->name('edit.profile');
Route::post('/update-profile',[AdminController::class,'updateProfile'])->name('update.profile');
Route::post('/update-password',[AdminController::class,'updatePassword'])->name('update.password');
Route::post('/photo-update',[AdminController::class,'photoUpdate'])->name('photo.update');
Route::get('/admin-user-delete/{user_id}',[AdminController::class,'adminUserDelete'])->name('admin.user.delete');
//Author
Route::get('/author',[AdminController::class,'author'])->middleware('auth')->name('author');
Route::get('/author/ststus/{author_id}',[AdminController::class,'author_status_change'])->name('author.status');
Route::get('/author/delete/{author_id}',[AdminController::class,'author_delete'])->name('author.delete');

//category
Route::get('/category',[CategoryController::class,'category'])->middleware('auth')->name('category');
Route::get('/trash',[CategoryController::class,'trashCategory'])->middleware('auth')->name('trash');
Route::post('/add-category',[CategoryController::class,'store'])->name('category.store');
Route::get('/category-edit/{category_id}',[CategoryController::class,'categoryEdit'])->middleware('auth')->name('edit');
Route::post('/category-update/{category_id}',[CategoryController::class,'categoryUpdate'])->name('category.update');
Route::get('/category-delete/{category_id}',[CategoryController::class,'categoryDelete'])->name('delete');
Route::get('/category-restore/{category_id}',[CategoryController::class,'categoryRestore'])->name('category.restore');
Route::get('/category-hard-delete/{category_id}',[CategoryController::class,'categoryHardDelete'])->name('category.hard.delete');
Route::post('/category-chack-delete',[CategoryController::class,'categoryChackDelete'])->name('category.chack.delete');
Route::post('/category-chack-restore/and-delete',[CategoryController::class,'categoryChackRestore'])->name('category.chack.restore');
Route::get('category-active/{category_id}',[CategoryController::class,'categoryActive'])->name('category.active');
Route::get('category-inactive/{category_id}',[CategoryController::class,'categoryInactive'])->name('category.inactive');

//tags
Route::get('/tags',[TagController::class,'tags'])->middleware('auth')->name('tags');
Route::post('/tag-store',[TagController::class,'tagStore'])->name('tag.store');
Route::get('/tag-delete/{tag_id}',[TagController::class,'tagDelete'])->name('tag.delete');

//author
Route::post('/author/register',[AuthorController::class,'author_register'])->name('author.register');
Route::post('/author/login',[AuthorController::class,'author_login'])->name('author.login');
Route::get('/author/logout',[AuthorController::class,'author_logout'])->name('author.logout');
Route::get('/author/dashboard',[AuthorController::class,'author_dashboard'])->middleware('author')->name('author.dashboard');
