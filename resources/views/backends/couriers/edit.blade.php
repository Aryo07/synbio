@extends('backends.layouts.app', ['title' => 'Edit Kurir'])

@section('content')
<section id="basic-vertical-layouts">
    <div class="row match-height">
        <div class="col-md-6 col-12">
            <div class="card border-0 shadow">
                <div class="card-header border-0 bg-primary text-white">
                    <h4 class="card-title m-0 font-weight-bold"><i class="bi bi-truck"></i> TAMBAH KURIR</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" method="POST" action="{{ route('admin.couriers.update', $courier->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nama Kurir</label>
                                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $courier->name }}" placeholder="Tambah Nama Kurir">

                                            @error('name')
                                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="service">Layanan</label>
                                            <input type="text" id="service" name="service" class="form-control @error('service') is-invalid @enderror" value="{{ $courier->service }}" placeholder="Tambah Layanan">

                                            @error('service')
                                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="cost">Biaya</label>
                                            <input type="text" id="cost" name="cost" class="form-control @error('cost') is-invalid @enderror" value="{{ $courier->cost }}" placeholder="Tambah Biaya">


                                            @error('cost')
                                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                                        <a href="{{ route('admin.couriers.index') }}" class="btn btn-light-secondary me-1 mb-1">Back</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
