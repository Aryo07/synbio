@extends('backends.layouts.app', ['title' => 'Banks'])

@section('content')
<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header border-0 bg-primary text-white">
                    <h4 class="card-title m-0 font-weight-bold"><i class="bi bi-bank"></i> BANK</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.banks.index') }}">
                            @csrf
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.banks.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> ADD</a>
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
                                        <th>NAMA BANK</th>
                                        <th>NO. REKENING</th>
                                        <th>NAMA AKUN</th>
                                        <th>FOTO</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($banks as $bank)
                                    <tr>
                                        <td>{{ $loop->iteration + $banks->perPage() * ($banks->currentPage() - 1) }}</td>
                                        <td>{{ $bank->bank_name }}</td>
                                        <td>{{ $bank->account_number }}</td>
                                        <td>{{ $bank->account_name }}</td>
                                        <td>
                                            @if($bank->image && file_exists(public_path('storage/banks/' . $bank->image)))
                                            <img src="{{ asset('storage/banks/' . $bank->image) }}" alt="{{ $bank->title }}" class="img-fluid" style="max-width: 150px;">
                                            @else
                                            <img src="https://dummyimage.com/1440x600/942594/ffffff.png&text=Bank+Tidak+Ada" alt="{{ $bank->title }}" class="img-fluid" style="max-width: 150px;">
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.banks.edit', $bank->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            @if ($bank->status != 'show')
                                            <button onclick="deleteData('{{ $bank->id }}')" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <form action="{{ route('admin.banks.destroy', $bank->id) }}" id="deleteForm{{ $bank->id }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="6" class="text-center">Data Belum Tersedia!</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-3">
                            <div>
                                Showing {{ $banks->firstItem() }} to {{ $banks->lastItem() }} of {{ $banks->total() }} entries
                            </div>
                            <div>
                                {{ $banks->links() }}
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
