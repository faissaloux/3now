<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('make:admin', function () {
    \App\Models\Admin::create([
        'name'  => 'Admin',
        'email' => 'admin@3now.com',
        'password' => \Hash::make('1234')
    ]);
})->describe('Create Admin');

Artisan::command('make:data', function () {
    \Artisan::call('db:seed');
})->describe('Add fake data to database');
