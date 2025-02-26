@extends('backends.layouts.app', ['title' => 'Banners'])

@section('content')
<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header border-0 bg-primary text-white">
                    <h4 class="card-title m-0 font-weight-bold"><i class="bi bi-image"></i> BANNER</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.banners.index') }}">
                            @csrf
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> ADD</a>
                                    </div>
                                    <input type="text" class="form-control" name="q" placeholder="Search data here...">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> SEARCH</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Table with outer spacing -->
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>JUDUL</th>
                                        <th>DESKRIPSI</th>
                                        <th>FOTO</th>
                                        <th>STATUS</th>
                                        <th>POSISI</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($banners as $banner)
                                    <tr>
                                        <td>{{ $loop->iteration + $banners->perPage() * ($banners->currentPage() - 1) }}</td>
                                        {{-- <td>{{ $banner->id }}</td> --}}
                                        <td>{{ $banner->title }}</td>
                                        <td>{!! $banner->description !!}</td>
                                        <td>
                                            @if($banner->image && file_exists(public_path('storage/banners/' . $banner->image)))
                                            <img src="{{ asset('storage/banners/' . $banner->image) }}" alt="{{ $banner->title }}" class="img-fluid" style="max-width: 150px;">
                                            @else
                                            <img src="https://dummyimage.com/1440x600/942594/ffffff.png&text=Banner+Tidak+Ada" alt="{{ $banner->title }}" class="img-fluid" style="max-width: 150px;">
                                            @endif
                                        </td>
                                        <td>
                                            @if($banner->status == 'show')
                                            <span class="badge bg-success">{{ $banner->status }}</span>
                                            @else
                                            <span class="badge bg-danger">{{ $banner->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $banner->position }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            @if ($banner->status != 'show')
                                            <button onclick="deleteData('{{ $banner->id }}')" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" id="deleteForm{{ $banner->id }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="7" class="text-center">Data Belum Tersedia!</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-3">
                            <div>
                                Showing {{ $banners->firstItem() }} to {{ $banners->lastItem() }} of {{ $banners->total() }} entries
                            </div>
                            <div>
                                {{ $banners->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="{{ asset('assets/js/sweetalert-delete.js') }}"></script>
@endpush
