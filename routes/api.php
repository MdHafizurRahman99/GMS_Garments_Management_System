<?php

use App\Http\Controllers\Api\AllTransactionController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CostController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\IncomeController;
use App\Http\Controllers\API\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('api-transactions', AllTransactionController::class);

// Public routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Income
    Route::apiResource('api-incomes', IncomeController::class);

    // Expenses
    Route::apiResource('api-costs', CostController::class);

    // Settings - Payment Methods
    Route::get('/payment-methods', [SettingsController::class, 'getPaymentMethods']);
    Route::post('/payment-methods', [SettingsController::class, 'storePaymentMethod']);
    Route::put('/payment-methods/{paymentMethod}', [SettingsController::class, 'updatePaymentMethod']);
    Route::delete('/payment-methods/{paymentMethod}', [SettingsController::class, 'destroyPaymentMethod']);

    // Settings - Income Sources
    Route::get('/income-sources', [SettingsController::class, 'getIncomeSources']);
    Route::post('/income-sources', [SettingsController::class, 'storeIncomeSource']);
    Route::put('/income-sources/{incomeSource}', [SettingsController::class, 'updateIncomeSource']);
    Route::delete('/income-sources/{incomeSource}', [SettingsController::class, 'destroyIncomeSource']);

    // Settings - Income Types
    Route::get('/income-types', [SettingsController::class, 'getIncomeTypes']);
    Route::post('/income-types', [SettingsController::class, 'storeIncomeType']);
    Route::put('/income-types/{incomeType}', [SettingsController::class, 'updateIncomeType']);
    Route::delete('/income-types/{incomeType}', [SettingsController::class, 'destroyIncomeType']);

    // Settings - Expense Types
    Route::get('/expense-types', [SettingsController::class, 'getExpenseTypes']);
    Route::post('/expense-types', [SettingsController::class, 'storeExpenseType']);
    Route::put('/expense-types/{expenseType}', [SettingsController::class, 'updateExpenseType']);
    Route::delete('/expense-types/{expenseType}', [SettingsController::class, 'destroyExpenseType']);
});
