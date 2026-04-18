<?php

use Contensio\Plugins\RobotsTxt\Http\Controllers\RobotsTxtController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'contensio.admin'])
    ->prefix('account/settings')
    ->group(function () {
        Route::get('robots-txt',          [RobotsTxtController::class, 'edit'])  ->name('robots-txt.settings');
        Route::post('robots-txt',         [RobotsTxtController::class, 'update'])->name('robots-txt.settings.update');
        Route::post('robots-txt/reset',   [RobotsTxtController::class, 'reset']) ->name('robots-txt.settings.reset');
    });
