<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\InstitutionController;

Route::post('/credit-offer', [InstitutionController::class, 'fetchInstitutions']);
Route::post('/credit-simulation', [OfferController::class, 'simulateOffer']);

Route::get('/docs', function () {
    return view('swagger::index');
});