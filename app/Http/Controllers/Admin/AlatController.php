<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Alat;

class AlatController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:admin');
  }

  public function alat(){
    $alats = Alat::orderBy('id', 'DESC')->get();
    return view('pages.admin.alat', compact('alats'));
  }

  public function paket(){
    $alats = Alat::orderBy('id', 'DESC')->get();
    return view('pages.admin.paket', compact('alats'));
  }
}
