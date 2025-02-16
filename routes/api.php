<?php

use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::post('/credit-offer', [InstitutionController::class, 'fetch']);
Route::post('/credit-simulation', [OfferController::class, 'simulate']);