<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Alat;
use App\Pembayaran;
use Storage;
use DB;

class AdminController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:admin');
  }

  public function index(){
    $alats = Alat::where('tipe', 'Alat')->get();
    $pakets = Alat::where('tipe', 'Paketan')->get();
    $pemesanans = Pembayaran::where('status', 1)->get();
    $pembayarans = Pembayaran::where('status', 2)->get();
    return view('pages.admin.beranda', compact('alats','pakets','pemesanans','pembayarans'));
  }
}
