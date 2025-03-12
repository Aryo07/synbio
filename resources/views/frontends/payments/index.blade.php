@extends('frontends.layouts.app', ['title' => 'Payments'])

@section('content')
    <section id="payment">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h4>Pembayaran</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-7">
                    <p>Silahkan melakukan pembayaran dan upload bukti bayar sebelum {{ now()->addDays(3)->format('d F Y') }} pukul 00.00 .</p>
                    <img src="{{ asset('storage/banks/' . $payment->order->bank->image) }}" alt="logo" class="mb-3">
                    <p>Nomor Rekening : <b>{{ $payment->order->bank->account_number }}</b></p>
                    <p>Nama Pemilik Rekening : <b>{{ $payment->order->bank->account_name }}</b></p>

                    <form method="POST" action="{{ route('payment.confirm', $payment->id) }}" enctype="multipart/form-data">
                        @csrf
                        <label for="image" class="form-label">Upload Bukti Bayar</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">

                        @error('image')
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror

                        <input type="submit" class="btn btn-success w-100 mt-3" value="Konfirmasi">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection