@extends('template.html')

@section('title', 'log aktifitas')
@section('body')
@include('template.navadmin')
    <div class="container mtp">
        <h2 class="text-center mb-2"> Log Aktifitas </h2>

        <table class="table table-primary">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Tanggal</td>
                    <td>Aktifitas</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($log as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->activity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection