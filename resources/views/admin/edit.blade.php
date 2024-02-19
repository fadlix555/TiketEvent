@extends('template.html')

@section('title', 'Edit Events')
@section('body')
@include('template.navadmin')
<div class="container mtp">
    @if (Session::has('berhasil'))
        <alert class="alert-success">{{ Session::get('berhasil') }}</alert>
    @endif
    <form action="{{ route('postedit', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card col-sm-6 p-3 mx-auto">
            <h3 class="text-center mb-3"> Edit Event </h3>
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nama" value="{{ $event->nama }}" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="harga" class="col-sm-2 col-form-label">Harga:</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" name="harga" value="{{ $event->harga }}"  required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="foto" class="col-sm-2 col-form-label">Foto:</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="foto" accept="image/*">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="link-map" class="col-sm-2 col-form-label">Link Map:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="map" value="{{ $event->map }}" >
                </div>
            </div>
            <div class="mb-3 row">
                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="lokasi" value="{{ $event->lokasi }}"  required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tanggal" class="col-sm-2 col-form-label">Tanggal:</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" name="tanggal"  value="{{ $event->tanggal }}"  required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="waktu" class="col-sm-2 col-form-label">Waktu:</label>
                <div class="col-sm-8">
                    <input type="time" class="form-control" name="waktu"  value="{{ $event->waktu }}"  required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="stok" class="col-sm-2 col-form-label">Stok:</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" name="stok" value="{{ $event->stok }}"  required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="stok" class="col-sm-2 col-form-label">Kategori:</label>
                <div class="col-sm-8">
                    <select name="Category_id" id="Category_id" class="form-select">
                        @foreach ($category as $item)
                            <option value="{{ $item->id }}"> {{ $item->nama }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-8 offset-sm-2">
                    <button type="submit" class="btn btn-dark">Edit Event</button>
                    <a href="{{ route('admin') }}" class="btn btn-outline-dark">Kembali</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
