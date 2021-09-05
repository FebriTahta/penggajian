<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pegawaicontroller;
use App\Http\Controllers\umumcontroller;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect('/login');
    // return view('maintenance');
});
Auth::routes();
Route::get('/home', [HomeController::class,'index']);
Route::get('/dashboard', [pegawaicontroller::class,'page_absensi']);
Route::get('uploaddata/{id}',[umumcontroller::class,'page_uploaddata']);
Route::get('getData',[umumcontroller::class,'page_getDataUID']);
Route::get('testCode',[umumcontroller::class,'testcom']);
Route::get('absensi',[pegawaicontroller::class,'page_absensi']);
Route::get('pengajian',[pegawaicontroller::class,'page_pengajian']);
Route::post('/cari_data_absensi',[pegawaicontroller::class,'page_cari_data_absensi']);
Route::get('daftar',[pegawaicontroller::class,'page_daftar']);
Route::post('/simpanpegawai',[pegawaicontroller::class,'page_simpanpegawai']);
Route::get('deletepegawai/{id',[pegawaicontroller::class,'page_deletepegawai']);
Route::get('updatepegawai/{id}',[pegawaicontroller::class,'page_updateitempegawai']);
Route::post('/updateitempegawai',[pegawaicontroller::class,'page_updateitempegawai']);
Route::post('/bacapenggajian',[pegawaicontroller::class,'page_bacapenggajian']);
Route::get('potongan',[pegawaicontroller::class,'page_potongan']);
Route::post('/simpanpotongan',[pegawaicontroller::class,'page_simpanpotongan']);
Route::get('updatepotongan/{id}',[pegawaicontroller::class,'page_updatepotongan']);
Route::post('/updateitempotongan',[pegawaicontroller::class,'page_updateitempotongan']);
Route::get('deletepotongan/{id}',[umumcontroller::class,'page_hapuspotongan']);
Route::get('jabatan',[umumcontroller::class,'page_jabatan']);
Route::post('/simpanjabatan',[umumcontroller::class,'page_simpanjabatan']);
Route::get('updatejabatan/{id}',[umumcontroller::class,'page_updatejabatan']);
Route::post('/updateitemjabatan',[umumcontroller::class,'page_updateitemjabatan']);
Route::get('deletejabatan/{id}',[umumcontroller::class,'page_hapusjabatan']);
Route::get('tunjangan',[umumcontroller::class,'page_tunjangan']);
Route::post('/simpantunjangan',[umumcontroller::class,'page_simpantunjangan']);
Route::get('updatetunjangan',[umumcontroller::class,'page_updateitemtunjangan']);
Route::get('deletetunjangan/{id}',[umumcontroller::class,'page_deletetunjangan']);
Route::get('updatetunjangan/{id}',[umumcontroller::class,'page_updatetunjangan']);
Route::get('deletepegawai/{id}' , [pegawaicontroller::class,'page_deletepegawai']);
route::get('/update-pegawai/{id}',[pegawaicontroller::class,'edit'] );
route::post('/updatedatapegawai', [pegawaicontroller::class,'update']);
// Route::get('/', 'pegawaicontroller@page_absensi');

// //=====> Upload Data .
// Route::get('uploaddata/{id}' , 'umumcontroller@page_uploaddata');
// Route::get('getData' , 'umumcontroller@page_getDataUID');
// Route::get('testcode' , 'umumcontroller@testcom');
// //=====> Absensi.
// Route::get('absensi', 'pegawaicontroller@page_absensi');
// Route::get('pengajian', 'pegawaicontroller@page_pengajian');   
// Route::post('/cari_data_absensi' , 'pegawaicontroller@page_cari_data_absensi');
// //=====> Pegawai .
// Route::get('daftar', 'pegawaicontroller@page_daftar');
// Route::post('/simpanpegawai' , 'pegawaicontroller@page_simpanpegawai');
// Route::get('deletepegawai/{id}' , 'pegawaicontroller@page_deletepegawai');
// Route::get('updatepegawai/{id}' , 'pegawaicontroller@page_updatepegawai');
// Route::post('/updateitempegawai' , 'pegawaicontroller@page_updateitempegawai');
// Route::post('/bacapenggajian' , 'pegawaicontroller@page_bacapenggajian');
// //=====> Potongan .
// Route::get('potongan', 'umumcontroller@page_potongan');
// Route::post('/simpanpotongan', 'umumcontroller@page_simpanpotongan');
// Route::get('updatepotongan/{id}', 'umumcontroller@page_updatepotongan');
// Route::post('/updateitempotongan' , 'umumcontroller@page_updateitempotongan');
// Route::get('deletepotongan/{id}', 'umumcontroller@page_hapuspotongan');
// //=====> Jabatan . 
// Route::get('jabatan', 'umumcontroller@page_jabatan');
// Route::post('/simpanjabatan', 'umumcontroller@page_simpanjabatan');
// Route::get('updatejabatan/{id}', 'umumcontroller@page_updatejabatan');
// Route::post('/updateitemjabatan' , 'umumcontroller@page_updateitemjabatan');
// Route::get('deletejabatan/{id}', 'umumcontroller@page_hapusjabatan');
// //=====> Tunjangan . 
// Route::get('tunjangan', 'umumcontroller@page_tunjangan');
// Route::post('/simpantunjangan' , 'umumcontroller@page_simpantunjangan');
// Route::get('updatetunjangan' , 'umumcontroller@page_updateitemtunjangan');
// Route::get('deletetunjangan/{id}', 'umumcontroller@page_deletetunjangan');
// Route::get('updatetunjangan/{id}', 'umumcontroller@page_updatetunjangan');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
