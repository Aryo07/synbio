<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->when(
            request()->q,
            function ($users) {
                // $users = $users->where('name', 'like', '%' . request()->q . '%');
                $users = $users->where(function ($query) {
                    $query->where('name', 'like', '%' . request()->q . '%')
                        ->orWhere('email', 'like', '%' . request()->q . '%');
                });
            }
        )->orderBy('id', 'desc')->paginate(10);
        return view('backends.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backends.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'password' => 'required|min:8'
        ], [
            'name.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'phone.required' => 'Nomor telepon tidak boleh kosong!',
            'phone.numeric' => 'Nomor telepon harus berupa angka!',
            'phone.unique' => 'Nomor telepon sudah terdaftar!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 8 karakter!',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        if ($user) {
            toastr()
                ->success('Data user berhasil disimpan.');
            return redirect()->route('admin.users.index');
        } else {
            toastr()
                ->error('Data user gagal disimpan.');
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('backends.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|numeric|unique:users,phone,' . $user->id,
            // 'password' => 'required|min:8'
        ], [
            'name.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'phone.required' => 'Nomor telepon tidak boleh kosong!',
            'phone.numeric' => 'Nomor telepon harus berupa angka!',
            'phone.unique' => 'Nomor telepon sudah terdaftar!',
            // 'password.required' => 'Password tidak boleh kosong!',
            // 'password.min' => 'Password minimal 8 karakter!',
        ]);

        // cek password ada perubahan atau tidak
        if ($request->password) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
        }

        if ($user) {
            toastr()
                ->success('Data user berhasil diupdate.');
            return redirect()->route('admin.users.index');
        } else {
            toastr()
                ->error('Data user gagal diupdate.');
            return redirect()->route('admin.users.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        if ($user) {
            toastr()
                ->success('Data user berhasil dihapus.');
            return redirect()->route('admin.users.index');
        } else {
            toastr()
                ->error('Data user gagal dihapus.');
            return redirect()->route('admin.users.index');
        }
    }
}
