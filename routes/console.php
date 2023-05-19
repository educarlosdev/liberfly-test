<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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

Artisan::command('start', function () {
    Artisan::call('migrate');
    if (!\App\Models\User::query()->first()) {
        Artisan::call('migrate:fresh --seed');
    }
})->purpose('Verifica se já tem algum dado semeado no banco e se não tiver roda o seed');
