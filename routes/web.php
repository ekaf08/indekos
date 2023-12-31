<?php

use App\Http\Controllers\Backend\{
    AppMenuController,
    DashboardController,
    KategoriController,
    LoginController,
    MenuController,
    SubMenuController,
    KamarController,
    UserController,
};
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


//-----***### Start Route Backend ***###-----
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group([
    'middleware' => ['auth', 'getUserMenu', 'getRouteName']
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // route master
    // ***### Route Kategori
    Route::get('/master/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/master/kategori', KategoriController::class)->except('create', 'edit');
    // ***### End Route Kategori

    // ***###  Route Kamar
    Route::get('/master/kamar/data', [KamarController::class, 'data'])->name('kamar.data');
    Route::resource('/master/kamar', KamarController::class)->except('create', 'edit');
    // ***### End Route Kamar

    // ***###  Route User.
    Route::get('/master/user/data', [UserController::class, 'data'])->name('user.data');
    Route::get('/master/user/xlsx', [UserController::class, 'xlsx'])->name('user.xlsx');
    Route::get('/master/user/pdf', [UserController::class, 'pdf'])->name('user.pdf');
    Route::get('master/user/query', [UserController::class, 'byQuery'])->name('user.byquery');
    Route::post('master/user/getcolumn', [UserController::class, 'getColumn'])->name('user.getColumn');
    Route::post('master/user/getdata', [UserController::class, 'getdata'])->name('getdata.sql');
    Route::resource('/master/user', UserController::class)->except('create', 'edit');

    //route profil
    Route::get('/pengaturan/profil', [UserController::class, 'profil'])->name('profil.index');
    Route::post('/pengaturan/profil/update', [UserController::class, 'updateprofil'])->name('profil.update');
    Route::post('/cekemail', [UserController::class, 'getEmail'])->name('cek_email');
    // ***### End Route User


    // route untuk menu dinamis / web menu management
    // route menu
    Route::get('/pengaturan/setup/data', [AppMenuController::class, 'data'])->name('setup.data');
    Route::post('/pengaturan/setup/menu', [AppMenuController::class, 'menu'])->name('setup.menu');
    Route::get('/pengaturan/setup/subMenu', [AppMenuController::class, 'showSubMenu'])->name('setup.showSubMenu');
    Route::post('/pengaturan/setup/store', [AppMenuController::class, 'store'])->name('setup.store');
    Route::post('/pengaturan/setup/addSubMenu/{id}', [AppMenuController::class, 'addSubMenu'])->name('setup.addSubMenu');
    Route::delete('/pengaturan/setup/hapus_menu', [AppMenuController::class, 'hapus_menu'])->name('setup.hapus_menu');
    Route::post('/pengaturan/setup/restore_menu', [AppMenuController::class, 'restore_menu'])->name('setup.restore_menu');
    Route::post('pengaturan/setup/urutanMenu', [AppMenuController::class, 'urutanMenu'])->name('setup.urutanMenu');
    Route::resource('/pengaturan/setup', AppMenuController::class)->except('create', 'edit');

    // route sub menu
    Route::post('/pengaturan/setup/subMenu', [AppMenuController::class, 'subMenu'])->name('setup.subMenu');
    Route::post('/pengaturan/setup/configMenu', [AppMenuController::class, 'configMenu'])->name('setup.configMenu');
    Route::delete('/pengaturan/setup/hapus_subMenu/{id}', [AppMenuController::class, 'hapus_subMenu'])->name('setup.hapus_subMenu');
    Route::post('/pengaturan/setup/restore_subMenu/{id}', [AppMenuController::class, 'restore_subMenu'])->name('setup.restore_subMenu');

    route::resource('/pengaturan/menu', MenuController::class)->except('create', 'edit');
    route::resource('/pengaturan/submenu', SubMenuController::class)->except('create', 'edit');
});
//-----***### End Route Backend ***###-----
