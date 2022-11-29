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

function getContacts () {
    $cont_data = [
        1 => ['name' => 'Name 1', 'phone' => '1234567890'],
        2 => ['name' => 'Name 2', 'phone' => '2345678901'],
        3 => ['name' => 'Name 3', 'phone' => '3456789012'],
    ];

    return $cont_data;
}

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/contacts', function () {
        $contacts = getContacts();
        return view('contacts.index', compact('contacts'));
    })->name('contacts.index');

    Route::get('/contacts/create', function () {
        return view('contacts.create');
    })->name('contacts.create');

    Route::get('/contacts/{id}', function ($routeId) {
        $contacts = getContacts();
        abort_unless(isset($contacts[$routeId]), 404);
        $contact = $contacts[$routeId];
        return view('contacts.show')->with('contact', $contact);
    })->name('contacts.show');

    Route::fallback(function () {
        return "<h1>Sorry this route doesn't exist.</h1>";
    });
});