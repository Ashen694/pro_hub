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