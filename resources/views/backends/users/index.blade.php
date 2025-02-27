@extends('backends.layouts.app', ['title' => 'Users'])

@section('content')
<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header border-0 bg-primary text-white">
                    <h4 class="card-title m-0 font-weight-bold"><i class="bi bi-person"></i> USER</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.users.index') }}">
                            @csrf
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> ADD</a>
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
                                        <th>NAMA</th>
                                        <th>EMAIL</th>
                                        <th>TELEPON</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration + $users->perPage() * ($users->currentPage() - 1) }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            @if ($user->status != 'show')
                                            <button onclick="deleteData('{{ $user->id }}')" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" id="deleteForm{{ $user->id }}" method="POST" class="d-inline">
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
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                            </div>
                            <div>
                                {{ $users->links() }}
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
