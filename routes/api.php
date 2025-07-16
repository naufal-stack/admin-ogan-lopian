<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\InformasiPentingController;
use App\Http\Controllers\Api\LokerController;
use App\Http\Controllers\Api\KategoriLokerController;
use App\Http\Controllers\Api\WisataController;
use App\Http\Controllers\Api\SekolahController;
use App\Http\Controllers\Api\LaporController;
use App\Http\Controllers\Api\FaskesController;
use App\Http\Controllers\Api\DokterController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\AuthController; // Import controller Auth baru
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BookingPdfController;
use App\Http\Controllers\Api\TicketController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Rute untuk Hotel
Route::prefix('hotels')->group(function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::get('/{id}', [HotelController::class, 'show']);
    Route::post('/', [HotelController::class, 'store']);
    Route::get('index/jumlah', [HotelController::class, 'getHotelCount']);
});

Route::prefix('informasi')->group(function () {
    Route::get('/', [InformasiPentingController::class, 'index']);
    Route::get('/{id}', [InformasiPentingController::class, 'show']);
    Route::post('/', [InformasiPentingController::class, 'store']);
    Route::get('index/jumlah', [InformasiPentingController::class, 'getInfoCount']);
});

Route::prefix('loker')->group(function () {
    Route::get('/', [LokerController::class, 'index']);
    Route::get('/{id}', [LokerController::class, 'show']);
    Route::post('/', [LokerController::class, 'store']);
    Route::get('index/jumlah', [LokerController::class, 'getLokerCount']);
});

Route::prefix('kategori-lokers')->group(function () {
    Route::get('/', [KategoriLokerController::class, 'index']);
    Route::post('/', [KategoriLokerController::class, 'store']);
    Route::get('/{id}', [KategoriLokerController::class, 'show']);
});

Route::prefix('wisata')->group(function () {
    Route::get('/', [WisataController::class, 'index']);       // GET untuk daftar wisata
    Route::post('/', [WisataController::class, 'store']); // Ini adalah rute untuk menyimpan data
    Route::get('/{id}', [WisataController::class, 'show']);    // GET untuk detail wisata
    Route::get('index/jumlah', [WisataController::class, 'getWisataCount']); // GET untuk jumlah wisata
    Route::put('/{id}', [WisataController::class, 'update']);  // PUT untuk memperbarui wisata
    Route::delete('/{id}', [WisataController::class, 'destroy']); // DELETE untuk menghapus wisata
});

Route::prefix('sekolah')->group(function () {
    Route::get('/', [SekolahController::class, 'index']);
    Route::post('/', [SekolahController::class, 'store']);
    Route::get('/{id}', [SekolahController::class, 'show']);
    Route::get('index/jumlah', [SekolahController::class, 'getSekolahCount']);
});

Route::prefix('lapor')->group(function () {
    Route::get('/', [LaporController::class, 'index']);
    Route::get('/{id}', [LaporController::class, 'show']);
    Route::post('/', [LaporController::class, 'store']);
});

Route::prefix('dokter')->group(function () {
    Route::get('/', [DokterController::class, 'index']);
    Route::get('/{id}', [DokterController::class, 'show']);
    Route::post('/', [DokterController::class, 'store']);
    Route::get('index/jumlah', [DokterController::class, 'getDokterCount']);
});

// Rute untuk Register (Pendaftaran)
Route::prefix('register')->group(function () {
    Route::post('/', [RegisterController::class, 'store']);
});

Route::prefix('faskes')->group(function () {
    Route::get('/', [FaskesController::class, 'index']);
});

// Rute untuk Otentikasi (Login/Logout/Reset Password)
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('admin/login', [AuthController::class, 'adminLogin']); // Rute untuk login admin
});



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rute untuk Booking
    Route::get('/bookings/list', [BookingController::class, 'index']); // Melihat daftar pemesanan pengguna
    Route::post('/bookings', [BookingController::class, 'store']); // Membuat pemesanan baru
    Route::get('/bookings/{booking}', [BookingController::class, 'show']); // Melihat detail pemesanan
    Route::put('/bookings/{booking}/cancel', [BookingController::class, 'cancel']); // Membatalkan pemesanan
    Route::put('/bookings/{booking}/confirm', [BookingController::class, 'confirm']);

});


Route::middleware('auth:sanctum')->get('/booking/{id}/pdf', [BookingPdfController::class, 'show']);

Route::post('/tickets/send-qr', [TicketController::class, 'sendQr']);
