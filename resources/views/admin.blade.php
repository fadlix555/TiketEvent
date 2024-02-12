@extends('template.html')

@section('title', 'Admin Events')

@section('body')
    @include('template.navadmin')
    <div class="container mtp">
        @if (Session::has('notif'))
            <p class="alert alert-danger">{{ Session::get('notif') }}</p>
        @endif

        <div class="card card-body">
            <h2 class="text-center"> Home Admin Events</h2>
    
            <a href="{{ route('tambah') }}" class="btn btn-success mb-4" style="width: 150px; height: 40px"> Tambah Event </a>
    
            <table class="table table-primary mt-3" id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Stock</th>
                        <th>Update Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td width="150">{{ $event->nama }}</td>
                            <td width="250">
                                <img src="{{ asset($event->foto) }}" alt="Event Image" class="thumbnail" width="150">
                            </td>
                            <td>{{ $event->status }}</td>
                            <td>{{ number_format($event->stok, 0, ',', '.') }}</td>
                            <td width="300">
                                <form action="{{ route('events.update-status', $event->id) }}" method="POST">
                                    @csrf
                                    <label for="status" class="sr-only">Update Status:</label>
                                    <div class="d-flex gap-2">
                                        <select name="status" id="status" class="form-control w-50" >
                                            <option value="active" {{ $event->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $event->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('edit', $event->id) }}" class="btn btn-warning mt-3"> Edit </a>
                                <a href="{{ route('hapus', $event->id) }}" class="btn btn-danger mt-3" onclick="return confirm('Yakin menghapus?')"> Hapus </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        new DataTable('#example', {
            responsive: true
    
        });
    </script>
@endsection
