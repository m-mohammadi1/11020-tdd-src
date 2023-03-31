<?php

use App\Http\Controllers\Admin\SyncInternetPackagesController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->get('internet-package/sync', [SyncInternetPackagesController::class, 'run']);
