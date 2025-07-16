<?php
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return view('index');
});

Route::get('/dasboard', function () {
    return view('dasboard');
});

// Rute untuk aktivasi akun
Route::get('/account', [RegisterController::class, 'activate'])->name('account.activate');


Route::get('/logout', function () {
    Auth::logout();
    return redirect('/admin/login');
})->name('logout');


Route::get('/storage/dokter_photos/{filename}', function ($filename) {
    $path = 'dokter_photos/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    $type = Storage::disk('public')->mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
});

Route::get('/storage/hotel_photos/{filename}', function ($filename) {
    $path = 'hotel_photos/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    $type = Storage::disk('public')->mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
});

Route::get('/storage/loker_logos/{filename}', function ($filename) {
    $path = 'loker_logos/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    $type = Storage::disk('public')->mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
});

Route::get('/storage/wisata_images/{filename}', function ($filename) {
    $path = 'wisata_images/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    $type = Storage::disk('public')->mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
});


Route::get('/storage/informasi_images/{filename}', function ($filename) {
    $path = 'informasi_images/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    $type = Storage::disk('public')->mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
});


Route::get('/admin/bookings/{record}/pdf', function (Booking $record) {
    $pdf = Pdf::loadView('pdf.booking', ['record' => $record]);
    return $pdf->stream(); // untuk tampil di iframe
})->name('admin.bookings.pdf.view');
