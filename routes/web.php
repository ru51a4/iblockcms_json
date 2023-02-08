<?php

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

Route::get('/', function () {
    return redirect("/catalog");

});


Route::post('/api/login', [\App\Http\Controllers\Api\ApiController::class, "authenticate"]);
Route::post('/api/register', [\App\Http\Controllers\Api\ApiController::class, "register"]);

Route::get('/api/index/{id}/{page}', [\App\Http\Controllers\Api\IndexController::class, "index"]);
Route::get('/api/detail/{id}', [\App\Http\Controllers\Api\IndexController::class, "detail"]);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('/api/logout', [\App\Http\Controllers\Api\ApiController::class, "logout"]);
    Route::post('/api/get_user', [\App\Http\Controllers\Api\ApiController::class, "get_user"]);
});


Auth::routes();

//slug
Route::get('catalog', [App\Http\Controllers\HomeController::class, 'catalog']);
Route::get('catalog/{slug}', [App\Http\Controllers\HomeController::class, 'catalog'])->where(['slug' => '.*']);
Route::post('catalog/{slug}', [App\Http\Controllers\HomeController::class, 'catalog'])->where(['slug' => '.*']);

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index']);
Route::get('/admin/addiblock', [App\Http\Controllers\AdminController::class, 'addiblockform']);
Route::get("/admin/{iblock_element}/editelement", [App\Http\Controllers\AdminController::class, 'editelementform']);
Route::post("/admin/{iblock_element}/editelement", [App\Http\Controllers\AdminController::class, 'editelement']);

Route::post('/admin/addiblock', [App\Http\Controllers\AdminController::class, 'addiblock']);
Route::get('/admin/{iblock}/elementlist', [App\Http\Controllers\AdminController::class, 'elementlist']);
Route::get('/admin/{iblock}/iblockedit', [App\Http\Controllers\AdminController::class, 'iblockeditform']);
Route::post('/admin/{iblock}/iblockedit', [App\Http\Controllers\AdminController::class, 'iblockedit']);
Route::post('/admin/{iblock}/propertyadd', [App\Http\Controllers\AdminController::class, 'propertyadd']);
Route::get('/admin/{iblock}/addelement', [App\Http\Controllers\AdminController::class, 'addelementform']);
Route::post('/admin/{iblock}/addelement', [App\Http\Controllers\AdminController::class, 'addelement']);
Route::get('/admin/{iblock}/delete', [App\Http\Controllers\AdminController::class, 'deleteiblock']);
Route::get('/admin/{iblock}/deletepropery', [App\Http\Controllers\AdminController::class, 'deleteproperty']);

Route::get("/admin/{iblock_element}/deleteelement", [App\Http\Controllers\AdminController::class, 'deleteelement']);
Route::get('/admin/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
