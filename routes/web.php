<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\MobilController;
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Admin\ManagePaymentsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\PenjualController;
use App\Http\Controllers\Admin\PembeliController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DocumentController;
use Illuminate\Support\Facades\Route;

// ──────────────────────────────────────────────
// Frontend Routes
// ──────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');

// Catalog
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{id}', [CatalogController::class, 'show'])->name('catalog.show');

// Info Pages
Route::get('/jual-mobil', [HomeController::class, 'jualMobil'])->name('jual-mobil');
Route::get('/dealer', [HomeController::class, 'dealer'])->name('dealer');
Route::get('/why-us', [HomeController::class, 'whyUs'])->name('why-us');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/help', [HomeController::class, 'help'])->name('help');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');

// ──────────────────────────────────────────────
// Auth Routes (Guest only)
// ──────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Forgot & Reset Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ──────────────────────────────────────────────
// Authenticated User Routes
// ──────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    // Booking
    Route::get('/booking/{mobilId}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{mobilId}', [BookingController::class, 'store'])->name('booking.store');

    // Payment
    Route::get('/payment/{transaksiId}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/{transaksiId}', [PaymentController::class, 'store'])->name('payment.store');

    // Transaction Status
    Route::get('/transaction-status', [TransactionController::class, 'status'])->name('transaction.status');
    Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::post('/transaction/{id}/delivery-choice', [TransactionController::class, 'updateDeliveryChoice'])->name('transaction.delivery.choice');
    Route::post('/transaction/{id}/cancel', [TransactionController::class, 'cancel'])->name('transaction.cancel');
    Route::post('/transaction/{id}/confirm-receipt', [TransactionController::class, 'confirmReceipt'])->name('transaction.confirm-receipt');
    Route::get('/transaction/{id}/kwitansi/{pembayaranId}', [TransactionController::class, 'kwitansi'])->name('transaction.kwitansi');
    Route::post('/transaction/{id}/cancel-booking', [PaymentController::class, 'cancelBooking'])
    ->name('transaction.cancel-booking');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ──────────────────────────────────────────────
// Admin Routes
// ──────────────────────────────────────────────

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manage Cars
    Route::get('/manage-cars', [MobilController::class, 'index'])->name('mobil.index');
    Route::post('/manage-cars', [MobilController::class, 'store'])->name('mobil.store');
    Route::put('/manage-cars/{id}', [MobilController::class, 'update'])->name('mobil.update');
    Route::delete('/manage-cars/{id}', [MobilController::class, 'destroy'])->name('mobil.destroy');

    // Manage Sellers
    Route::get('/manage-sellers', [PenjualController::class, 'index'])->name('penjual.index');
    Route::post('/manage-sellers', [PenjualController::class, 'store'])->name('penjual.store');
    Route::put('/manage-sellers/{id}', [PenjualController::class, 'update'])->name('penjual.update');
    Route::delete('/manage-sellers/{id}', [PenjualController::class, 'destroy'])->name('penjual.destroy');

    // Manage Buyers
    Route::get('/manage-buyers', [PembeliController::class, 'index'])->name('pembeli.index');
    Route::post('/manage-buyers', [PembeliController::class, 'store'])->name('pembeli.store');
    Route::put('/manage-buyers/{id}', [PembeliController::class, 'update'])->name('pembeli.update');
    Route::delete('/manage-buyers/{id}', [PembeliController::class, 'destroy'])->name('pembeli.destroy');

    // Manage Users
    Route::get('/manage-users', [UserController::class, 'index'])->name('user.index');
    Route::post('/manage-users', [UserController::class, 'store'])->name('user.store');
    Route::put('/manage-users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/manage-users/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Manage Orders (Kelola Data Pesanan & Kwitansi)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{id}/kwitansi/{pembayaranId}', [OrderController::class, 'kwitansi'])->name('orders.kwitansi');

    // Manage Vehicle Documents (Kelola Dokumen Kendaraan)
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::put('/documents/{id}', [DocumentController::class, 'update'])->name('documents.update');

    // Payment Verification
    Route::get('/verify-payment', [PaymentVerificationController::class, 'index'])->name('payment.index');
    Route::post('/verify-payment/{id}/approve', [PaymentVerificationController::class, 'approve'])->name('payment.approve');
    Route::post('/verify-payment/{id}/reject', [PaymentVerificationController::class, 'reject'])->name('payment.reject');

    // Manage Payments (Kelola Data Pembayaran)
    Route::get('/manage-payments', [ManagePaymentsController::class, 'index'])->name('payments.manage');
    Route::post('/manage-payments/payment/{id}/force-approve', [ManagePaymentsController::class, 'forceApprove'])->name('payments.forceApprove');
    Route::post('/manage-payments/payment/{id}/force-reject', [ManagePaymentsController::class, 'forceReject'])->name('payments.forceReject');

    // Delivery
    Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery.index');
    Route::post('/delivery/{transaksiId}/update', [DeliveryController::class, 'updateStatus'])->name('delivery.update');
    Route::get('/delivery/{transaksiId}/surat-jalan', [DeliveryController::class, 'suratJalan'])->name('delivery.surat-jalan');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// Helper route untuk migrasi online (Sementara)
Route::get('/run-migration', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed' => true
        ]);
        return "Database successfully migrated and seeded!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
