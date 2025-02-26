<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = Bank::latest()->when(
            request()->q,
            function ($banks) {
                // $banks = $banks->where('bank_name', 'like', '%' . request()->q . '%');
                $banks = $banks->where(function ($query) {
                    $query->where('bank_name', 'like', '%' . request()->q . '%')
                        ->orWhere('account_name', 'like', '%' . request()->q . '%');
                });
            }
        )->orderBy('id', 'desc')->paginate(10);
        return view('backends.banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backends.banks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'bank_name' => 'required',
                'account_name' => 'required',
                'account_number' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'bank_name.required' => 'Nama Bank wajib diisi!',
                'account_name.required' => 'Nama Akun wajib diisi!',
                'account_number.required' => 'Nomor Akun wajib diisi!',
                'image.required' => 'Gambar wajib diisi!',
                'image.image' => 'Gambar harus berupa gambar!',
                'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, svg!',
                'image.max' => 'Ukuran gambar maksimal 2MB!',
            ]
        );

        // menyimpan gambar ke dalam folder storage/banks
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/banks'), $image_name);

        // menyimpan data ke dalam tabel banks
        Bank::create([
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'image' => $image_name,
        ]);

        if ($request) {
            toastr()
                ->positionClass('toast-top-center')
                ->success('Data Bank berhasil ditambahkan');

            return redirect()->route('admin.banks.index');
        } else {
            toastr()
                ->positionClass('toast-top-center')
                ->error('Data Bank gagal ditambahkan');

            return redirect()->route('admin.banks.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        return view('backends.banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        $request->validate(
            [
                'bank_name' => 'required',
                'account_name' => 'required',
                'account_number' => 'required',
                // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'bank_name.required' => 'Nama Bank wajib diisi!',
                'account_name.required' => 'Nama Akun wajib diisi!',
                'account_number.required' => 'Nomor Akun wajib diisi!',
                // 'image.required' => 'Gambar wajib diisi!',
                // 'image.image' => 'Gambar harus berupa gambar!',
                // 'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, svg!',
                // 'image.max' => 'Ukuran gambar maksimal 2MB!',
            ]
        );

        // cek apakah gambar diubah atau tidak
        if ($request->hasFile('image')) {

            // hapus gambar lama di dalam folder storage/banks
            $oldImage = public_path('storage/banks/' . $bank->image);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            // menyimpan gambar ke dalam folder storage/banks
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/banks'), $image_name);

            // menyimpan data banks ke dalam database
            Bank::where('id', $bank->id)->update([
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'image' => $image_name,
            ]);
        } else {
            // menyimpan data banks ke dalam database tanpa mengubah gambar
            Bank::where('id', $bank->id)->update([
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
            ]);
        }

        if ($request) {
            toastr()
                ->positionClass('toast-top-center')
                ->success('Data bank berhasil diubah!');
            return redirect()->route('admin.banks.index');
        } else {
            toastr()
                ->positionClass('toast-top-center')
                ->error('Data bank gagal diubah!');
            return redirect()->route('admin.banks.edit', $bank->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        if (file_exists(public_path('storage/banks/' . $bank->image))) {
            unlink(public_path('storage/banks/' . $bank->image));
        }

        Bank::destroy('id', $bank->id);

        if ($bank) {
            toastr()
                ->positionClass('toast-top-center')
                ->success('Data bank berhasil dihapus!');
            return redirect()->route('admin.banks.index');
        } else {
            toastr()
                ->positionClass('toast-top-center')
                ->error('Data bank gagal dihapus!');
            return redirect()->route('admin.banks.index');
        }
    }
}
