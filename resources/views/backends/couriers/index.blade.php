@extends('backends.layouts.app', ['title' => 'Kurir'])

@section('content')
<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header border-0 bg-primary text-white">
                    <h4 class="card-title m-0 font-weight-bold"><i class="bi bi-truck"></i> KURIR</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.couriers.index') }}">
                            @csrf
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.couriers.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> ADD</a>
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
                                        <th>KURIR</th>
                                        <th>LAYANAN</th>
                                        <th>BIAYA</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($couriers as $courier)
                                    <tr>
                                        <td>{{ $loop->iteration + $couriers->perPage() * ($couriers->currentPage() - 1) }}</td>
                                        <td>{{ $courier->name }}</td>
                                        <td>{{ $courier->service }}</td>
                                        <td>{{ moneyFormat($courier->cost) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.couriers.edit', $courier->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            @if ($courier->orders->count() == 0)
                                            <button onclick="deleteData('{{ $courier->id }}')" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <form action="{{ route('admin.couriers.destroy', $courier->id) }}" id="deleteForm{{ $courier->id }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="5" class="text-center">Data Belum Tersedia!</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-3">
                            <div>
                                Showing {{ $couriers->firstItem() }} to {{ $couriers->lastItem() }} of {{ $couriers->total() }} entries
                            </div>
                            <div>
                                {{ $couriers->links() }}
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
