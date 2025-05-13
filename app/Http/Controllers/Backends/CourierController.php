<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $couriers = Courier::latest()->when(
            request()->q,
            function ($couriers) {
                // $couriers = $couriers->where('name', 'like', '%' . request()->q . '%');
                $couriers = $couriers->where(function ($query) {
                    $query->where('name', 'like', '%' . request()->q . '%')
                        ->orWhere('service', 'like', '%' . request()->q . '%');
                });
            }
        )->orderBy('id', 'desc')->paginate(10);
        return view('backends.couriers.index', compact('couriers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backends.couriers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'service' => 'required',
                'cost' => 'required|numeric',
            ],
            [
                'name.required' => 'Nama Kurir wajib diisi!',
                'service.required' => 'Layanan wajib diisi!',
                'cost.required' => 'Biaya wajib diisi!',
                'cost.numeric' => 'Biaya harus berupa angka!',
            ]
        );

        // menyimpan data ke dalam tabel couriers
        Courier::create([
            'name' => $request->name,
            'service' => $request->service,
            'cost' => $request->cost,
        ]);

        if ($request) {
            toastr()
                ->success('Data Courier berhasil ditambahkan');

            return redirect()->route('admin.couriers.index');
        } else {
            toastr()
                ->error('Data Courier gagal ditambahkan');

            return redirect()->route('admin.couriers.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Courier $courier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Courier $courier)
    {
        return view('backends.couriers.edit', compact('courier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courier $courier)
    {
        $request->validate(
            [
                'name' => 'required',
                'service' => 'required',
                'cost' => 'required|numeric',
            ],
            [
                'name.required' => 'Nama Kurir wajib diisi!',
                'service.required' => 'Layanan wajib diisi!',
                'cost.required' => 'Biaya wajib diisi!',
                'cost.numeric' => 'Biaya harus berupa angka!',
            ]
        );

        // update data ke dalam tabel couriers
        $courier->update([
            'name' => $request->name,
            'service' => $request->service,
            'cost' => $request->cost,
        ]);

        // fungsi jika data berhasil diupdate dan gagal diupdate
        if ($request) {
            toastr()
                ->success('Data Courier berhasil diubah');

            return redirect()->route('admin.couriers.index');
        } else {
            toastr()
                ->error('Data Courier gagal diubah');

            return redirect()->route('admin.couriers.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courier $courier)
    {
        $courier->delete();

        if ($courier) {
            toastr()
                ->success('Data Courier berhasil dihapus');

            return redirect()->route('admin.couriers.index');
        } else {
            toastr()
                ->error('Data Courier gagal dihapus');

            return redirect()->route('admin.couriers.index');
        }
    }
}
