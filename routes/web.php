<?php

use App\Point;
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
   return view('welcome');
});

Route::get('/api-get', function (){
    $p = Point::query()
        ->where('id', '>', 0)
        ->with('user')
        ->orderBy('id')
        ->limit(10)
        ->get();

    return $p;
//        ->where('id', '>', $variable->value)

});
