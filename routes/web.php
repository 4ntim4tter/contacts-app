<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactCreateController;
use App\Http\Controllers\ContactShowController;
use App\Http\Controllers\WelcomeController;
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

function getContacts()
{
    $cont_data = [
        1 => ['id' => 1, 'name' => 'Name 1', 'phone' => '1234567890'],
        2 => ['id' => 2, 'name' => 'Name 2', 'phone' => '2345678901'],
        3 => ['id' => 3, 'name' => 'Name 3', 'phone' => '3456789012'],
    ];

    return $cont_data;
}

Route::get('/', WelcomeController::class);

Route::controller(ContactController::class)->name('contacts.')->group(function(){
    
    Route::get('/contacts', 'index')->name('index');
    
    Route::get('/contacts/create', 'create')->name('create');
    
    Route::get('/contacts/{id}', 'show')->name('show');

});


Route::fallback(function () {
    return "<h1>Sorry this route doesn't exist.</h1>";
});
