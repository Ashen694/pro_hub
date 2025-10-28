<?php

use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// --- Import Controllers ---
use App\Http\Controllers\InternalSolutionController;
use App\Http\Controllers\ConsumerServicePlatformController;
use App\Http\Controllers\ExternalSolutionController;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root URL to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// All authenticated routes will be inside this group
Route::middleware('auth')->group(function () {

    // --- Profile Routes ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Internal Solutions Routes ---

    // NEW: Redirect from the base URL to a default status page
    Route::get('/internal-solutions', function () {
        return redirect()->route('internal-solutions.index', ['status' => 'operational']);
    });

    Route::get('/internal-solutions/export', [InternalSolutionController::class, 'exportAll'])->name('internal-solutions.export');
    Route::get('/internal-solutions/yearly-contribution', [InternalSolutionController::class, 'yearlyContribution'])->name('internal-solutions.yearly-contribution');
    Route::get('/internal-solutions-create', [InternalSolutionController::class, 'create'])->name('internal-solutions.create');
    Route::get('/internal-solutions/{solution}/change-requests', [InternalSolutionController::class, 'showChangeRequests'])->name('internal-solutions.change-requests');
    Route::get('/internal-solutions/{solution}/edit', [InternalSolutionController::class, 'edit'])->name('internal-solutions.edit');
    Route::post('/internal-solutions', [InternalSolutionController::class, 'store'])->name('internal-solutions.store');
    Route::put('/internal-solutions/{solution}', [InternalSolutionController::class, 'update'])->name('internal-solutions.update');
    Route::get('/internal-solutions/{status}', [InternalSolutionController::class, 'index'])->name('internal-solutions.index');


    // --- Consumer Service Platforms Route ---
    Route::get('/consumer-service-platforms', [ConsumerServicePlatformController::class, 'index'])->name('consumer-service.index');

    Route::get('/internal-solutions/yearly-contribution/{year}', [InternalSolutionController::class, 'yearlyContributionDetails'])->name('internal-solutions.yearly-contribution.details');


    // --- Reference Data Routes ---
        Route::prefix('reference-data')->name('reference-data.')->group(function () {
        // Companies CRUD
        Route::resource('companies', \App\Http\Controllers\CompanyController::class);
        // Customer Contacts CRUD (restored)
        Route::resource('customer-contacts', \App\Http\Controllers\CustomerContactController::class);
        // Other reference data
        Route::resource('divisional-members', \App\Http\Controllers\DivisionalMemberController::class);
        Route::resource('application-groups', \App\Http\Controllers\ApplicationGroupController::class);
        Route::resource('fields-of-specializations', \App\Http\Controllers\FieldOfSpecializationController::class);
        
        //partners
        Route::resource('partners', \App\Http\Controllers\PartnerController::class);    });

        // --- DMS (Document Management System) Routes ---
    Route::prefix('dms')->name('dms.')->group(function () {
    Route::get('/{type}', [DocumentController::class, 'index'])->name('index');  
    Route::get('/{type}/create', [DocumentController::class, 'create'])->name('create');
    Route::post('/{type}', [DocumentController::class, 'store'])->name('store');

    Route::get('/{document}/edit', [DocumentController::class, 'edit'])->name('edit');
    Route::put('/{document}', [DocumentController::class, 'update'])->name('update');

    Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('destroy');
    Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
     });



    // Route for showing the list of external solutions based on their status
    Route::get('/external-solutions/{status}', [ExternalSolutionController::class, 'index'])->name('external-solutions.index');

    // Create and store routes for external solutions
    Route::get('/external-solutions-create', [ExternalSolutionController::class, 'create'])->name('external-solutions.create');
    Route::post('/external-solutions', [ExternalSolutionController::class, 'store'])->name('external-solutions.store');

    // CRUD routes
    Route::get('/external-solutions/{externalSolution}/show', [ExternalSolutionController::class, 'show'])->name('external-solutions.show');
    Route::get('/external-solutions/{externalSolution}/edit', [ExternalSolutionController::class, 'edit'])->name('external-solutions.edit');
    Route::put('/external-solutions/{externalSolution}', [ExternalSolutionController::class, 'update'])->name('external-solutions.update');
    Route::delete('/external-solutions/{externalSolution}', [ExternalSolutionController::class, 'destroy'])->name('external-solutions.destroy');

    //  route for deleting a solution
    Route::delete('/internal-solutions/{solution}', [InternalSolutionController::class, 'destroy'])->name('internal-solutions.destroy');
});

// Authentication routes (login, logout, etc.)
require __DIR__.'/auth.php';
