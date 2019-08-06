<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keranjang;
use App\Pembayaran;
use Auth;
use DB;
use Illuminate\Support\Str;


class PembayaranController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index(){
      $keranjangs = Keranjang::where('id_penyewa', Auth::user()->id)->get();
      $tanggal = null;
      foreach ($keranjangs as $keranjang) {
          $tanggal = $keranjang->tgl_pinjam;
      }
      if($keranjangs->isEmpty()){
        return redirect()->back();
      }elseif ($tanggal == null) {
        return redirect()->route('keranjang.tampil')->with('error','Masukan Tanggal pinjam dan kembali terlebih dahulu');
      }
      return view('pembayaran', compact('keranjangs'));
  }

  public function show(){
      $totals = DB::table('pembayarans')->select('no_transaksi',DB::raw('SUM(total) as total_semua'))->groupBy('no_transaksi')->get();
      // dd($total);
      $keranjangs = Keranjang::where('id_penyewa', Auth::user()->id)->get();
      $pembayarans = Pembayaran::where('id_penyewa', Auth::user()->id)->get();
      return view('data_pembayaran', compact('keranjangs', 'pembayarans', 'totals'));
  }

  public function store(Request $request){
    $user = Auth::user();
    $this->validate($request,[
      'telp' => "numeric|digits_between:10,13|unique:users,telp,$user->id",
      'alamat' => 'required|max:255|min:5',
    ]);
    if ($user->email_verified_at == null) {
      return redirect()->back()->with('error','Email belum di verifikasi')->withInput();
    }
    $id_transaksi = 'AL'.strtoupper(Str::random(10));
    $user->update([
      'telp' => $request->telp,
      'alamat' => $request->alamat
    ]);
    $count = count($request->id_alat);
    for ($i=0; $i < $count; $i++) {
      Pembayaran::create([
        'no_transaksi' => $id_transaksi,
        'id_penyewa' => $user->id,
        'id_alat' => $request->id_alat[$i],
        'qty' => $request->qty[$i],
        'total' => $request->total[$i],
        'tgl_pinjam' => $request->tgl_pinjam,
        'tgl_kembali' => $request->tgl_kembali,
        'durasi' => $request->durasi
      ]);
    }
    Keranjang::where('id_penyewa',Auth::user()->id)->delete();
    return redirect()->route('data.pembayaran')->with('success','Pemesanan berhasil');
  }

  public function update(Request $request, $transakasi){
    // dd($request->all());
    $this->validate($request,[
      'bukti' => 'required|mimes:jpeg,jpg,png|max:2048'
    ]);

    $pembayarans = Pembayaran::where('no_transaksi',$transakasi)->where('status', 0)->get();
    $count = count($pembayarans);
    $bukti = $request->file('bukti')->store('bukti');
    for ($i=0; $i < $count ; $i++) {
      $pembayarans[$i]->update([
        'bukti_user' => $bukti,
        'status' => 1
      ]);
    }
    return redirect()->back()->with('success','Bukti Pembayaran berhasil diupload');
  }
}
