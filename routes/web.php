<?php

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
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'prefix' => 'admin',
    'middleware' => 'role:admin',
], function () {
    Route::get('/home', 'HomeController@adminHome')->name('admin.home');

    /**
     * =============================================================================
     *  Roles
     * ==============================================================================
     */
    Route::get('/roles-json', 'RoleController@indexJson')->name('admin.users.roles');

    /**
     * =============================================================================
     *  Users
     * ==============================================================================
     */
    Route::get('/users', 'UserController@index')->name('admin.users');
    Route::get('/users-json', 'UserController@indexJson')->name('admin.users.json');
    Route::post('/users', 'UserController@store')->name('admin.users.store');
    Route::put('/users/{user}', 'UserController@update')->name('admin.users.update');
    Route::delete('/users/{user}', 'UserController@destroy')->name('admin.users.delete');

    /**
     * =============================================================================
     *  Users logs
     * ==============================================================================
     */
    Route::get('/users-logs', 'LogController@index')->name('admin.users.logs');
    Route::get('/users-logs-json', 'LogController@indexJson')->name('admin.users.logs.json');

    /**
     * =============================================================================
     *  Chats
     * ==============================================================================
     */
    Route::get('/chats', 'ChatController@index')->name('admin.users.chats');
    Route::get('/chats-json/{from}/{to}', 'ChatController@indexJson')->name('admin.users.chats.json');

});

//Staff routes
Route::group([
    'prefix' => 'staff',
    'middleware' => 'role:staff',
], function () {
//    Route::get('/home', 'HomeController@staffHome')->name('staff.home');
    /**
     * =============================================================================
     *  Users
     * ==============================================================================
     */
    Route::get('/home', 'StaffController@index')->name('staff.home');
    Route::get('/users-json', 'StaffController@indexJson')->name('staff.users.json');
    Route::post('/users', 'StaffController@store')->name('staff.users.store');
    Route::put('/users/{user}', 'StaffController@update')->name('staff.users.update');
    Route::delete('/users/{user}', 'StaffController@destroy')->name('staff.users.delete');
    Route::post('/assign-tutor', 'StaffController@assignTutorToTutees')->name('staff.users.assignTutor');

    /**
     * =============================================================================
     *  Users logs
     * ==============================================================================
     */
    Route::get('/users-logs', 'LogController@index')->name('staff.users.logs');
    Route::get('/users-logs-json', 'LogController@indexJson')->name('staff.users.logs.json');

    /**
     * =============================================================================
     *  Chats
     * ==============================================================================
     */
    Route::get('/chats', 'ChatController@index')->name('staff.users.chats');
    Route::get('/chats-json/{from}/{to}', 'ChatController@indexJson')->name('staff.users.chats.json');

    /**
     * =============================================================================
     *  Chats
     * ==============================================================================
     */
});

//Tutors routes
Route::group([
    'prefix' => 'tutor',
    'middleware' => 'role:tutor',
], function () {
//    Route::get('/home', 'HomeController@tutorHome')->name('tutor.home');
    /**
     * =============================================================================
     *  Users
     * ==============================================================================
     */
    Route::get('/home', 'TutorController@index')->name('tutor.home');
    Route::get('/users-json', 'TutorController@users')->name('tutor.users.json');
    Route::get('/chats/{user}', 'TutorController@chats')->name('tutor.chats');
    Route::post('/chats/{user}', 'TutorController@storeMessage')->name('tutee.chats.store');
});

//Tutors routes
Route::group([
    'prefix' => 'tutee',
    'middleware' => 'role:tutee',
], function () {
//    Route::get('/home', 'HomeController@tuteeHome')->name('tutee.home');
    /**
     * =============================================================================
     *  Users
     * ==============================================================================
     */
    Route::get('/home', 'TuteeController@index')->name('tutee.home');
    Route::get('/users-json', 'TuteeController@users')->name('tutee.users.json');
    Route::get('/chats/{user}', 'TuteeController@chats')->name('tutee.chats');
    Route::post('/chats/{user}', 'TuteeController@storeMessage')->name('tutee.chats.store');
});
