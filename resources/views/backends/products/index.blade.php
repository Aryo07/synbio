@extends('backends.layouts.app', ['title' => 'Products'])

@section('content')
<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header border-0 bg-primary text-white">
                    <h4 class="card-title m-0 font-weight-bold"><i class="bi bi-box"></i> PRODUCT</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.products.index') }}">
                            @csrf
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> ADD</a>
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
                                        <th>BERAT</th>
                                        <th>HARGA</th>
                                        <th>STATUS</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration + $products->perPage() * ($products->currentPage() - 1) }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{!! $product->description !!}</td>
                                        <td>
                                            @if($product->image && file_exists(public_path('storage/products/' . $product->image)))
                                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->title }}" class="img-fluid" style="max-width: 150px;">
                                            @else
                                            <img src="https://dummyimage.com/1440x600/942594/ffffff.png&text=Product+Tidak+Ada" alt="{{ $product->title }}" class="img-fluid" style="max-width: 150px;">
                                            @endif
                                        </td>
                                        <td>{{ $product->weight }} gram</td>
                                        <td>{{ moneyFormat($product->price) }}</td>
                                        <td>
                                            @if($product->status == 'show')
                                            <span class="badge bg-success">{{ $product->status }}</span>
                                            @else
                                            <span class="badge bg-danger">{{ $product->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            @if ($product->status != 'show')
                                            <button onclick="deleteData('{{ $product->id }}')" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <form action="{{ route('admin.products.destroy', $product->id) }}" id="deleteForm{{ $product->id }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="8" class="text-center">Data Belum Tersedia!</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 d-flex justify-content-between mt-3">
                            <div>
                                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
                            </div>
                            <div>
                                {{ $products->links() }}
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

