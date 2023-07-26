<?php

use App\http\Controllers\MenuController;
use App\http\Controllers\DataLampuController;
use App\http\Controllers\MejaController;
use App\http\Controllers\PesananController;
use App\http\Controllers\PesananDetailController;
use App\http\Controllers\MejaBiliardController;
use App\http\Controllers\PaketBiliardController;
use App\http\Controllers\OrderBiliardController;
use App\http\Controllers\OrderBiliardDetailController;
use App\http\Controllers\LaporanController;
use App\http\Controllers\LaporanBiliardController;
use App\http\Controllers\LaporanCafeController;
use App\http\Controllers\DashboardController;
use App\http\Controllers\LaporanTestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/datalampu', [DataLampuController::class, 'data'])->name('datalampu.data');

Route::get('/mejabiliard/updatetime', [MejaBiliardController::class, 'updatetime'])->name('mejabiliard.updatetime');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect()->route('dashboard.index');
})->name('dashboard');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/dashboard',DashboardController::class);

    Route::get('/menu/data', [MenuController::class, 'data'])->name('menu.data');
    Route::resource('/menu',MenuController::class);

    Route::get('/paketbiliard/data', [PaketBiliardController::class, 'data'])->name('paketbiliard.data');
    Route::resource('/paketbiliard',PaketBiliardController::class);

    Route::get('/orderbiliard/data', [OrderBiliardController::class, 'data'])->name('orderbiliard.data');
    Route::get('/orderbiliard/cetak/{id}', [OrderBiliardController::class, 'cetak'])->name('orderbiliard.cetak');
    Route::get('/orderbiliard/{id}/create', [OrderBiliardController::class, 'create'])->name('orderbiliard.create');
    Route::resource('/orderbiliard',OrderBiliardController::class)
      ->except('create');

    Route::get('/orderbiliarddetail/{index2}/before', [OrderBiliardDetailController::class, 'index2'])->name('orderbiliarddetail.index2');
    Route::get('/orderbiliarddetail/{id}/{meja}/{flag}/stop', [OrderBiliardDetailController::class, 'stop'])->name('orderbiliarddetail.stop');
    Route::get('/orderbiliarddetail/{id}/after', [OrderBiliardDetailController::class, 'index3'])->name('orderbiliarddetail.index3');
    Route::get('/orderbiliarddetail/{id}/{status1}/{status2}/data', [OrderBiliardDetailController::class, 'data'])->name('orderbiliarddetail.data');
    Route::get('/orderbiliarddetail/loadform/{diskon}/{total}/{diterima}', [OrderBiliardDetailController::class, 'loadform'])->name('orderbiliardetail.loadform');
    Route::resource('/orderbiliarddetail',OrderBiliardDetailController::class)
      ->except('create', 'show', 'edit');

    Route::get('/meja/{id}/reset', [MejaController::class, 'reset'])->name('meja.reset');
    Route::get('/meja/data', [MejaController::class, 'data'])->name('meja.data');
    Route::resource('/meja',MejaController::class);

    Route::get('/pesanan/{id}/create', [PesananController::class, 'create'])->name('pesanan.create');
    Route::get('/pesanan/data', [PesananController::class, 'data'])->name('pesanan.data');
    Route::get('/pesanan/cetak/{id}', [PesananController::class, 'cetak'])->name('pesanan.cetak');
    Route::get('/pesanan/cetakreset/{id}', [PesananController::class, 'cetakreset'])->name('pesanan.cetakreset');
    Route::resource('/pesanan',PesananController::class)
      ->except('create');

    //Route::get('/pesanandetail/{idmeja}/{idpesanan}', [PesananDetailController::class, 'index'])->name('pesanandetail.index');
    Route::get('/pesanandetail/{index2}', [PesananDetailController::class, 'index2'])->name('pesanandetail.index2');
    Route::get('/pesanandetail/{id}/{status}/data', [PesananDetailController::class, 'data'])->name('pesanandetail.data');
    Route::get('/pesanandetail/loadform/{diskon}/{total}/{diterima}', [PesananDetailController::class, 'loadform'])->name('pesanandetail.loadform');
    Route::resource('/pesanandetail',PesananDetailController::class)
      ->except('create', 'show', 'edit');

    Route::get('/mejabiliard/{id}/reset', [MejaBiliardController::class, 'reset'])->name('mejabiliard.reset');
    Route::get('/mejabiliard/data', [MejaBiliardController::class, 'data'])->name('mejabiliard.data');
    Route::get('/mejabiliard/pindah/{baru}/{lama}/{order}', [MejaBiliardController::class, 'pindah'])->name('mejabiliard.pindah');
    Route::resource('/mejabiliard',MejaBiliardController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])->name('laporan.data');
    Route::get('/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');

    Route::get('/laporanbiliard', [LaporanBiliardController::class, 'indexbiliard'])->name('laporan.indexbiliard');
    Route::get('/laporan/cetakbiliard/{awal}/{akhir}', [LaporanBiliardController::class, 'cetakbiliard'])->name('laporan.cetakbiliard');
    Route::get('/laporan/databiliard/{awal}/{akhir}', [LaporanBiliardController::class, 'databiliard'])->name('laporan.databiliard');
    Route::get('/laporan/pdfbiliard/{awal}/{akhir}', [LaporanBiliardController::class, 'exportPDFbiliard'])->name('laporan.export_pdfbiliard');

    Route::get('/laporancafe', [LaporanCafeController::class, 'indexcafe'])->name('laporan.indexcafe');
    Route::get('/laporan/cetakcafe/{awal}/{akhir}', [LaporanCafeController::class, 'cetakcafe'])->name('laporan.cetakcafe');
    Route::get('/laporan/datacafe/{awal}/{akhir}', [LaporanCafeController::class, 'datacafe'])->name('laporan.datacafe');
    Route::get('/laporan/pdfcafe/{awal}/{akhir}', [LaporanCafeController::class, 'exportPDFcafe'])->name('laporan.export_pdfcafe');
    
    Route::get('/laporantest', [LaporanTestController::class, 'indextest'])->name('laporan.indextest');
    Route::get('/laporan/cetaktest/{awal}/{akhir}', [LaporanTestController::class, 'cetaktest'])->name('laporan.cetaktest');
    Route::get('/laporan/datatest/{awal}/{akhir}', [LaporanTestController::class, 'datatest'])->name('laporan.datatest');
    Route::get('/laporan/pdftest/{awal}/{akhir}', [LaporanTestController::class, 'exportPDFtest'])->name('laporan.export_pdftest');

    Route::get('/sensor', [DataLampuController::class, 'getAll'])->name('laporan.sensor');
    Route::get('/sensor/data', [DataLampuController::class, 'getAllData'])->name('laporan.sensorData');

    Route::get('/log/hapus-barang', [DataLampuController::class, 'logHapus'])->name('laporan.hapus');
    Route::get('/log/hapus-barang/data', [DataLampuController::class, 'logHapusData'])->name('laporan.hapusData');

});
