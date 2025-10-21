<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// --- Import Controllers ---
use App\Http\Controllers\InternalSolutionController;
use App\Http\Controllers\ConsumerServicePlatformController;   
use App\Http\Controllers\ExternalSolutionController;  


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
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
    
    // --- Internal Solutions Routes (CORRECT ORDER) ---
    Route::get('/internal-solutions/{solution}/change-requests', [InternalSolutionController::class, 'showChangeRequests'])->name('internal-solutions.change-requests');
    
    // This route shows the details of ANY internal solution (Main App or CR)
    Route::get('/internal-solutions/{solution}/show', [InternalSolutionController::class, 'show'])->name('internal-solutions.show');

    Route::get('/internal-solutions/yearly-contribution', [InternalSolutionController::class, 'yearlyContribution'])->name('internal-solutions.yearly-contribution');
    Route::get('/internal-solutions-create', [InternalSolutionController::class, 'create'])->name('internal-solutions.create');
    Route::post('/internal-solutions', [InternalSolutionController::class, 'store'])->name('internal-solutions.store');
    
    Route::get('/internal-solutions/{status}', [InternalSolutionController::class, 'index'])->name('internal-solutions.index');
    
    // --- Consumer Service Platforms Route ---
    Route::get('/consumer-service-platforms', [ConsumerServicePlatformController::class, 'index'])->name('consumer-service.index');

    // --- Reference Data Routes ---
    Route::prefix('reference-data')->name('reference-data.')->group(function () {
        // Companies CRUD
        Route::resource('companies', \App\Http\Controllers\CompanyController::class)->except(['show']);
        // Customer Contacts CRUD (restored)
        Route::resource('customer-contacts', \App\Http\Controllers\CustomerContactController::class);
        // Other reference data
        Route::resource('divisional-members', \App\Http\Controllers\DivisionalMemberController::class)->except(['show']);
        Route::resource('application-groups', \App\Http\Controllers\ApplicationGroupController::class);
        Route::resource('fields-of-specializations', \App\Http\Controllers\FieldOfSpecializationController::class);
    });


    // Route for showing the list of external solutions based on their status
    Route::get('/external-solutions/{status}', [ExternalSolutionController::class, 'index'])->name('external-solutions.index');

});

// Authentication routes (login, logout, etc.)
require __DIR__.'/auth.php';