@extends('templates.admin.default')
@section('content')
<!-- @if(Session::has('success'))
<div class="alert alert-fill-success" role="alert">
   <i class="mdi mdi-check"></i>
  {{Session::get('success')}}
</div>
@endif -->
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Data Alat</h4>
    <!-- <div class="text-right mb-4">
      <button type="button" class="btn btn-primary" data-target="#tambah" data-toggle="modal"> Tambah</button>
    </div> -->
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table id="order-listing" class="table">
            <thead>
              <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Nama Toko</th>
                  <th>No Telepon</th>
                  <th>Alamat</th>
                  <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @php($no = 1)
              @foreach($alats as $alat)
              <tr>
                  <td>{{$no}}</td>
                  <td>{{$alat->nama}}</td>
                  <td>{{$alat->email}}</td>
                  <td>{{$alat->hah}}</td>
                  <td>{{$alat->telp}}</td>
                  <td>{{$alat->alamat}}</td>
                  <td></td>
              </tr>
              @endforeach
              @php($no++)
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
